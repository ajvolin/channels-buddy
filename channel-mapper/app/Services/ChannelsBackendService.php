<?php

namespace App\Services;

use App\APIModels\Airing;
use App\APIModels\Channel;
use App\APIModels\Channels;
use App\APIModels\Guide;
use App\APIModels\GuideEntry;
use App\APIModels\Rating;
use App\APIModels\Review;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use stdClass;

class ChannelsBackendService
{
    protected $baseUrl;
    protected $playlistBaseUrl;
    protected $httpClient;

    public function __construct()
    {
        if(env('CHANNELS_SERVER_IP') === null) {
            die('CHANNELS_SERVER_IP .env variable must be set. Cannot continue.');
        }

        if(env('CHANNELS_SERVER_PORT') === null) {
            die('CHANNELS_SERVER_PORT .env variable must be set. Cannot continue.');
        }

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

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getPlaylistBaseUrl(): string
    {
        return $this->playlistBaseUrl;
    }

    public function getChannels($source): Channels
    {
        $guideChannels = collect(
            $this->getGuideChannels()->channels
        )->keyBy('number');
        $channels = $this->getDeviceChannels($source)
            ->filter(function ($channel, $key) {
                return (property_exists($channel, 'Hidden')
                    && $channel->Hidden == 1) ? false : true;
            })->transform(function ($channel, $key) use ($guideChannels, $source) {
                    $channel->CallSign = 
                        $guideChannels->get($key)->callSign ??
                            $channel->GuideName;
                    $channel->Name = $guideChannels->get($key)->name ??
                        $channel->GuideName;
                    $channel->StreamUrl = 
                        $this->getStreamUrl($source, $channel->GuideNumber);

                    return $this->generateChannel($channel);
            });
            
        return new Channels($channels->toArray());
    }

    public function getGuideChannels(): Channels
    {
        $stream = $this->httpClient->get('/dvr/guide/channels');
        $json = $stream->getBody()->getContents();
        $channels = collect(json_decode($json))
        ->transform(function($channel){
            return $this->generateChannel($channel);
        })->sortBy('number');

        return new Channels($channels->toArray());
    }

    public function getGuideData($device, $startTimestamp, $duration): Guide
    {
        $guide = new Guide;

        $stream = $this->httpClient->get(
            sprintf('/devices/%s/guide?time=%d&duration=%d',
                $device,
                $startTimestamp,
                $duration
            )
        );
        $json = $stream->getBody()->getContents();
        $guideData = collect(json_decode($json));

        $startTimestamp = Carbon::createFromTimestamp($startTimestamp);

        $emptyProgramIntervals = CarbonInterval::minutes(60)
            ->toPeriod(
                $startTimestamp,
                $startTimestamp->copy()->addSeconds($duration)
            );

        foreach ($guideData as $srcChannel) {                        
            $channel = $this->generateChannel($srcChannel->Channel);
            $guideEntry = new GuideEntry($channel);

            if (count($srcChannel->Airings) > 0) {
                foreach ($srcChannel->Airings as $channelAiring) {
                    $startTime = Carbon::createFromTimestamp($channelAiring->Time);
                    $stopTime = $startTime->copy()->addSeconds($channelAiring->Duration);
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

                    $guideEntry->addAiring($airing);
                    unset(
                        $startTime,
                        $stopTime,
                        $length,
                        $isMovie,
                        $airingId,
                        $airing,
                        $originalReleaseDate,
                        $channelAiring
                    );
                }
            } else {
                foreach ($emptyProgramIntervals as $date) {
                    $airingId = md5(
                        $channel->id.$date->copy()->timestamp
                    );

                    $title = $channel->title
                        ?? $channel->name
                        ?? "To be announced";

                    $subTitle = sprintf(
                        "%s hour long block on %s.",
                        $title,
                        $date->copy()->format('M d, Y')
                    );

                    $description = $channel->description
                        ?? "To be announced";

                    $seriesId = md5($channel->id);
                    $programId = $seriesId . "." . $date->copy()->timestamp;
                    $seasonNumber = $date->copy()->format("Y");
                    $episodeNumber = $date->copy()->format("mdH");
                    
                    $airing = new Airing([
                        'id'                    => $airingId,
                        'channelId'             => $channel->id,
                        'startTime'             => $date->copy(),
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
                        'isMovie'               => false
                    ]);
                    
                    $guideEntry->addAiring($airing);

                    unset(
                        $airingId,
                        $title,
                        $subTitle,
                        $description,
                        $programId,
                        $seriesId,
                        $seasonNumber,
                        $episodeNumber,
                        $airing
                    );
                }
            }
            $guide->addGuideEntry($guideEntry);
            unset(
                $channel,
                $guideEntry
            );
        }

        unset(
            $stream,
            $json,
            $guideData,
            $startTimestamp,
            $emptyProgramIntervals
        );
        return $guide;
    }

    public function isValidDevice($device): bool
    {
        return ($this->getDevices()->has($device) !== false);
    }

    public function getDevices($allowAny = true): Collection
    {
        $stream = $this->httpClient->get('/devices');
        $json = $stream->getBody()->getContents();

        $devices = collect(json_decode($json))
            ->pluck('FriendlyName', 'DeviceID');
        if($allowAny) {
            $devices->prepend('All Devices', 'ANY');
        }

        return $devices;

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

        if (isset($srcChannel->Title)) {
            $channel->setTitle($srcChannel->Title);
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

    private function getDeviceChannels($source): Collection
    {
        $deviceChannelsStream = $this->httpClient
            ->get(sprintf('/devices/%s/channels', $source));
        $deviceChannelsJson = $deviceChannelsStream
            ->getBody()
            ->getContents();
        $deviceChannels = collect(json_decode($deviceChannelsJson))
            ->keyBy('GuideNumber')
            ->sortBy("GuideNumber");

        return $deviceChannels;
    }

    private function getStreamUrl(string $source, string $channelNumber): string {
        return sprintf("%s/devices/%s/channels/%s/stream.mpg",
            $this->playlistBaseUrl,
            $source,
            $channelNumber
        );
    }
}
