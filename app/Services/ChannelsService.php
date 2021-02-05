<?php

namespace App\Services;

use ChannelsBuddy\SourceProvider\Models\Airing;
use ChannelsBuddy\SourceProvider\Models\Channel;
use ChannelsBuddy\SourceProvider\Models\Channels;
use ChannelsBuddy\SourceProvider\Models\Guide;
use ChannelsBuddy\SourceProvider\Models\GuideEntry;
use ChannelsBuddy\SourceProvider\Models\Rating;
use ChannelsBuddy\SourceProvider\Models\Review;
use ChannelsBuddy\SourceProvider\Contracts\ChannelSource;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use JsonMachine\JsonMachine;
use JsonMachine\JsonDecoder\ExtJsonDecoder;
use stdClass;

class ChannelsService implements ChannelSource
{
    protected $channelsServiceDisabled = false;
    protected $baseUrl;
    protected $playlistBaseUrl;
    protected $httpClient;

    public function __construct()
    {
        if(env('CHANNELS_SERVER_IP') === null || env('CHANNELS_SERVER_PORT') === null) {
            $this->channelsServiceDisabled = true;
        } else {
            $this->baseUrl =
                sprintf("http://%s:%s",
                    env('CHANNELS_SERVER_IP'),
                    env('CHANNELS_SERVER_PORT')
                );
            
            $this->playlistBaseUrl =
                sprintf("http://%s:%s",
                    env('CHANNELS_SERVER_IP_FOR_PLAYLIST'),
                    env('CHANNELS_SERVER_PORT_FOR_PLAYLIST')
                );

            $this->httpClient = new Client(['base_uri' => $this->baseUrl]);
        }
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getPlaylistBaseUrl(): string
    {
        return $this->playlistBaseUrl;
    }

    public function getChannels(?string $device = 'ANY'): Channels
    {
        $guideChannels =
            $this->getGuideChannels()->channels;

        $channels = $this->getDeviceChannels($device)
            ->filter(function ($channel, $key) {
                return (property_exists($channel, 'Hidden')
                    && $channel->Hidden == 1) ? false : true;
            })->map(function ($channel, $key) use ($guideChannels, $device) {
                $channel->CallSign = 
                    $guideChannels->get($key)->callSign ??
                        $channel->GuideName;
                $channel->Name = $guideChannels->get($key)->name ??
                    $channel->GuideName;
                $channel->StreamUrl = 
                    $this->getStreamUrl($device, $channel->GuideNumber);

                return $this->generateChannel($channel);
            })->keyBy('number');
            
        return new Channels($channels);
    }

    public function getGuideChannels(): Channels
    {
        $stream = $this->httpClient->get('/dvr/guide/channels');
        $json = \GuzzleHttp\Psr7\StreamWrapper::getResource(
            $stream->getBody()
        );

        $channels = LazyCollection::make(JsonMachine::fromStream(
            $json, '', new ExtJsonDecoder
        ))->map(function($channel) {
            return $this->generateChannel($channel);
        })->keyBy('number');

        return new Channels($channels);
    }

    public function getGuideData(?int $startTimestamp, ?int $duration, ?string $device = 'ANY'): Guide
    {
        if (is_null($startTimestamp)) {
            $startTimestamp = Carbon::now()->timestamp;
        }

        if (is_null($duration)) {
            $duration = config('channels.backendChunkSize');
        }

        $stream = $this->httpClient->get(
            sprintf('/devices/%s/guide?time=%d&duration=%d',
                $device,
                $startTimestamp,
                $duration
            )
        );
        $json = \GuzzleHttp\Psr7\StreamWrapper::getResource(
            $stream->getBody()
        );
        $guideData = JsonMachine::fromStream(
            $json, '', new ExtJsonDecoder
        );

        $emptyProgramIntervalStartTime =
            Carbon::createFromTimestamp($startTimestamp);

        $emptyProgramIntervals = CarbonInterval::minutes(60)
        ->toPeriod(
                $emptyProgramIntervalStartTime,
                $emptyProgramIntervalStartTime
                    ->copy()
                    ->addSeconds($duration - 1)
        );

        $guideEntries = LazyCollection::make(function()
        use ($guideData, $emptyProgramIntervals) {
            foreach ($guideData as $srcChannel) {                        
                $channel = $this->generateChannel($srcChannel->Channel);
                $guideEntry = new GuideEntry($channel);

                if (count($srcChannel->Airings) > 0) {
                    $airings = LazyCollection::make(function()
                    use ($channel, $srcChannel) {
                        foreach ($srcChannel->Airings as $channelAiring) {
                            yield $this->generateAiring(
                                    $channel,
                                    $channelAiring
                                );
                        }
                    });
                } else {
                    $airings = LazyCollection::make(function()
                    use ($channel, $emptyProgramIntervals) {
                        foreach ($emptyProgramIntervals as $date) {
                            yield $this->generateAiringBlockForChannel(
                                    $channel,
                                    $date
                                );
                        }
                    });
                }
                $guideEntry->airings = $airings;
                yield $guideEntry;
            }
        });

        return new Guide($guideEntries);
    }

    public function isValidDevice($device): bool
    {
        if ($this->channelsServiceDisabled) {
            return false;
        } else {
            return ($this->getDevices()->has($device) !== false);
        }
    }

    public function getDevices($allowAny = true): Collection
    {
        if ($this->channelsServiceDisabled) {
            return collect();
        } else {
            try {
                $stream = $this->httpClient->get('/devices');
                $json = $stream->getBody()->getContents();

                $devices = collect(json_decode($json))
                    ->pluck('FriendlyName', 'DeviceID');
                if($allowAny) {
                    $devices->prepend('All Devices', 'ANY');
                }
                
                return $devices;
            } catch (RequestException $e) {
                return collect();
            }
        }        
    }

    private function generateAiring(Channel $channel, stdClass $channelAiring): Airing
    {
        $startTime = Carbon::createFromTimestamp($channelAiring->Time);
        $stopTime = $startTime
            ->copy()
            ->addSeconds($channelAiring->Duration);
        $length = $channelAiring->Duration;
        $airingId = md5(
            $channel->id.$channelAiring->Time
        );
        $isMovie = (isset($channelAiring->Categories)
            && is_array($channelAiring->Categories)
            && in_array("Movie", $channelAiring->Categories));

        $airing = new Airing([
            'id'                    => $airingId,
            'channelId'             => $channel->id,
            'title'                 => $channelAiring->Title,
            'startTime'             => $startTime,
            'stopTime'              => $stopTime,
            'length'                => $length,
            'isMovie'               => $isMovie
        ]);

        if (isset($channelAiring->Raw->program->titleLang)) {
            $airing->setTitleLanguage(
                $channelAiring->Raw->program->titleLang
            );
        }

        if (isset($channelAiring->EpisodeTitle)) {
            $airing->setSubTitle(
                $channelAiring->EpisodeTitle
            );
        } elseif (isset($channelAiring->EventTitle)) {
            $airing->setSubTitle(
                $channelAiring->EventTitle
            );
        }

        if (isset($channelAiring->Raw->long)
            || isset($channelAiring->Raw->program->longDescription)
            || isset($channelAiring->Raw->program->shortDescription)
            || isset($channelAiring->Summary)) {
            $airing->setDescription(
                $channelAiring->Raw->program->longDescription ??
                $channelAiring->Raw->program->shortDescription ??
                $channelAiring->Summary
            );
        }

        if (isset($channelAiring->Raw->program->descriptionLang)) {
            $airing->setDescriptionLanguage(
                $channelAiring->Raw->program->descriptionLang
            );
        }

        if (isset($channelAiring->Raw->program->preferredImage->uri)
            || isset($channelAiring->Image)) {
            $airing->setImage(
                $channelAiring->Raw->program->preferredImage->uri ??
                $channelAiring->Image
            );
        }

        if (isset($channelAiring->Source)) {
            $airing->setSource(
                $channelAiring->Source
            );
        }
        
        if (isset($channelAiring->ProgramID)) {
            $airing->setProgramId($channelAiring->ProgramID);
        }

        if (!$isMovie && isset($channelAiring->SeriesID)) {
            $airing->setSeriesId($channelAiring->SeriesID);
        }

        if (!$isMovie && isset($channelAiring->SeasonNumber)) {
            $airing->setSeasonNumber(
                $channelAiring->SeasonNumber
            );
        }

        if (!$isMovie && isset($channelAiring->EpisodeNumber)) {
            $airing->setEpisodeNumber(
                $channelAiring->EpisodeNumber
            );
        }

        if (isset($channelAiring->Directors)
            && !is_null($channelAiring->Directors)) {
            foreach ($channelAiring->Directors as $director) {
                $airing->addDirector($director);
            }
        }

        if (isset($channelAiring->Cast)
            && !is_null($channelAiring->Cast)) {
            foreach ($channelAiring->Cast as $cast) {
                $airing->addActor($cast);
            }
        }

        if (isset($channelAiring->OriginalDate)) {
            $originalReleaseDate = Carbon::parse(
                $channelAiring->OriginalDate
            );
            $airing->setOriginalReleaseDate(
                $originalReleaseDate
            );
        }

        if (isset($channelAiring->Genres)
            && !is_null($channelAiring->Genres)) {
            foreach ($channelAiring->Genres as $cat) {
                $airing->addCategory($cat);
            }
        }

        if (isset($channelAiring->Categories)
            && !is_null($channelAiring->Categories)) {
            foreach ($channelAiring->Categories as $cat) {
                $airing->addCategory($cat);
            }
        }

        if (isset($channelAiring->Tags)
            && is_array($channelAiring->Tags)) {
            if (in_array("Live", $channelAiring->Tags)) {
                $airing->setIsLive(true);
            }

            if (in_array("New", $channelAiring->Tags)) {
                $airing->setIsNew(true);
            } elseif (isset($originalReleaseDate) && !$isMovie) {
                $airing->setIsPreviouslyShown(true);
                $airing->setFirstAiredDate(
                    $originalReleaseDate->copy()
                );
            }

            if (in_array("Season Premiere", $channelAiring->Tags)) {
                $airing->setIsPremiere(true);
            }

            if (in_array("HDTV", $channelAiring->Tags)) {
                $airing->setIsHdtv(true);
            }

            if (in_array("DD 5.1", $channelAiring->Tags)) {
                $airing->setIsDolbyDigital(true);
            } elseif (in_array("Dolby", $channelAiring->Tags)) {
                $airing->setIsDolby(true);
            } else {
                $airing->setIsStereo(true);
            }

            if (in_array("CC", $channelAiring->Tags)) {
                $airing->setHasClosedCaptioning(true);
            }
        } else {
            $airing->setIsStereo(true);

            if (!$isMovie
                && isset($originalReleaseDate)
                && $originalReleaseDate
                    ->copy()
                    ->endOfDay()
                    ->isPast()) {
                $airing->setIsPreviouslyShown(true);
                $airing->setFirstAiredDate(
                    $originalReleaseDate->copy()
                );
            }
        }

        if (isset($channelAiring->Raw->ratings)
            && !is_null($channelAiring->Raw->ratings)) {
            foreach ($channelAiring->Raw->ratings as $rating) {
                $airing->addRating(
                    new Rating(
                        $rating->code,
                        $rating->body ?? null
                    )
                );
            }
        }

        if (isset($channelAiring->Raw->program)
            && isset($channelAiring->Raw->program->qualityRating)
            && !is_null($channelAiring->Raw->program->qualityRating)) {
            $airing->addReview(
                new Review(
                    $channelAiring->Raw->program->qualityRating->value,
                    $channelAiring->Raw->program->qualityRating->ratingsBody ?? null
                )
            );
        }

        return $airing;
    }

    private function generateAiringBlockForChannel(Channel $channel, Carbon $date): Airing
    {
        $airingId = md5(
            $channel->id.$date->copy()->timestamp
        );

        $title = $channel->title
            ?? $channel->name
            ?? "To be announced";

        $subTitle = sprintf("%s hour long block", $title);

        $description = $channel->description
            ?? "To be announced";

        $seriesId = md5($channel->id);
        $programId = $seriesId . "." . $date->copy()->timestamp;
        $seasonNumber = $date->copy()->format("Y");
        $episodeNumber = $date->copy()->format("mdH");
        
        return new Airing([
            'id'                    => $airingId,
            'channelId'             => $channel->id,
            'startTime'             => $date->copy()->startOfHour(),
            'stopTime'              => $date->copy()->endOfHour(),
            'length'                => 3600,
            'title'                 => $title,
            'subTitle'              => $subTitle,
            'description'           => $description,
            'programId'             => $programId,
            'seriesId'              => $seriesId,
            'seasonNumber'          => $seasonNumber,
            'episodeNumber'         => $episodeNumber,
            'originalReleaseDate'   => $date->copy(),
            'image'                 => $channel->channelArt ?? null,
            'isMovie'               => false
        ]);
    }

    private function generateChannel(stdClass $srcChannel): Channel
    {
        $channel = new Channel;

        if (isset($srcChannel->CallSign)
            || isset($srcChannel->GuideNumber)
            || isset($srcChannel->Number)) {
            $channel->setId(
                $srcChannel->CallSign ??
                $srcChannel->GuideNumber ??
                $srcChannel->Number
            );
        }
        
        if (isset($srcChannel->Name)) {
            $channel->setName($srcChannel->Name);
        }

        if (isset($srcChannel->GuideName)) {
            $channel->setGuideName($srcChannel->GuideName);
        }

        if (isset($srcChannel->GuideNumber)
            || isset($srcChannel->Number)) {
            $channel->setNumber(
                $srcChannel->GuideNumber ?? $srcChannel->Number
            );
        }

        if (isset($srcChannel->Station)) {
            $channel->setStationId($srcChannel->Station);
        }

        if (isset($srcChannel->CallSign)) {
            $channel->setCallSign($srcChannel->CallSign);
        }

        if (isset($srcChannel->Logo)
            || isset($srcChannel->Image)) {
            $channel->setLogo(
                $srcChannel->Logo ?? $srcChannel->Image
            );
        }

        if (isset($srcChannel->Art)) {
            $channel->setChannelArt($srcChannel->Art);
        }

        if (isset($srcChannel->Title)
            || isset($srcChannel->CallSign)
            || isset($srcChannel->Name)
            || isset($srcChannel->GuideName)) {
            $channel->setTitle(
                $srcChannel->Title ??
                $srcChannel->CallSign ??
                $srcChannel->Name ??
                $srcChannel->GuideName
            );
        }

        if (isset($srcChannel->Description)) {
            $channel->setDescription($srcChannel->Description);
        }

        if (isset($srcChannel->VideoCodec)) {
            $channel->setVideoCodec($srcChannel->VideoCodec);
        }

        if (isset($srcChannel->AudioCodec)) {
            $channel->setAudioCodec($srcChannel->AudioCodec);
        }

        if (isset($srcChannel->StreamUrl)) {
            $channel->setStreamUrl($srcChannel->StreamUrl);
        }
        
        return $channel;
    }

    private function getDeviceChannels($device): LazyCollection
    {
        $stream = $this->httpClient
            ->get(sprintf('/devices/%s/channels', $device));
        $json = \GuzzleHttp\Psr7\StreamWrapper::getResource(
            $stream->getBody()
        );

        $channels = LazyCollection::make(JsonMachine::fromStream(
            $json, '', new ExtJsonDecoder
        ))->keyBy('GuideNumber');

        return $channels;
    }

    private function getStreamUrl(string $device, string $channelNumber): string {
        return sprintf("%s/devices/%s/channels/%s/stream.mpg",
            $this->playlistBaseUrl,
            $device,
            $channelNumber
        );
    }
}