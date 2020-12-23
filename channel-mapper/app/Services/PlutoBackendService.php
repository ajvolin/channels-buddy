<?php

namespace App\Services;

use App\APIModels\Airing;
use App\APIModels\Channel;
use App\APIModels\Channels;
use App\APIModels\Guide;
use App\APIModels\GuideEntry;
use App\APIModels\Rating;
use App\Contracts\BackendService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;
use stdClass;

class PlutoBackendService implements BackendService
{
    protected $baseUrl;
    protected $httpClient;

    protected $genres = [
        "Children" => ["Kids", "Children & Family", "Kids' TV", "Cartoons", "Animals", "Family Animation", "Ages 2-4", "Ages 11-12"],
        "News" => ["News + Opinion", "General News"],
        "Sports" => ["Sports", "Sports & Sports Highlights", "Sports Documentaries"],
        "Drama" => ["Crime", "Action & Adventure", "Thrillers", "Romance", "Sci-Fi & Fantasy", "Teen Dramas", "Film Noir", "Romantic Comedies", "Indie Dramas", "Romance Classics", "Crime Action", "Action Sci-Fi & Fantasy", "Action Thrillers", "Crime Thrillers", "Political Thrillers", "Classic Thrillers", "Classic Dramas", "Sci-Fi Adventure", "Romantic Dramas", "Mystery", "Psychological Thrillers", "Foreign Classic Dramas", "Classic Westerns", "Westerns", "Sci-Fi Dramas", "Supernatural Thrillers", "Mobster", "Action Classics", "African-American Action", "Suspense", "Family Dramas", "Alien Sci-Fi", "Sci-Fi Cult Classics"]
    ];

    public function __construct()
    {
        $this->baseUrl = 'http://api.pluto.tv';

        $this->httpClient = new Client(['base_uri' => $this->baseUrl]);
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getChannels(): Channels
    {
        $stream = $this->httpClient->get('/v2/channels');
        $json = $stream->getBody()->getContents();
        $channels = collect(json_decode($json))->filter(function($channel){
            return $channel->isStitched && !preg_match(
                '/^announcement|^privacy-policy/',
                $channel->slug
            );
        })->transform(function($channel) {
            return $this->generateChannel($channel);
        })->sortBy('number');

        return new Channels($channels->toArray());
    }
 
    public function getGuideData($startTimestamp = null, $duration = null): Guide
    {
        $guide = new Guide;

        $startTimestamp = Carbon::createFromTimestamp($startTimestamp);
        $startTime = urlencode(
            $startTimestamp->format('Y-m-d H:i:s.vO')
        );
        $stopTime = urlencode(
            $startTimestamp
                ->copy()
                ->addSeconds($duration)
                ->format('Y-m-d H:i:s.vO')
        );

        $stream = $this->httpClient->get(
            sprintf('/v2/channels?start=%s&stop=%s', $startTime, $stopTime));
        $json = $stream->getBody()->getContents();
        $guideData = collect(json_decode($json))->filter(function($channel){
            return $channel->isStitched && !preg_match(
                '/^announcement|^privacy-policy/',
                $channel->slug
            );
        })->sortBy('number')->keyBy('slug');

        foreach ($guideData as $channel) {
            $guideEntry = new GuideEntry(
                $this->generateChannel($channel)
            );

            foreach ($channel->timelines as $channelAiring) {
                $startTime = Carbon::parse($channelAiring->start);
                $stopTime = Carbon::parse($channelAiring->stop);
                $length = $startTime->copy()->diffInSeconds($stopTime);
                $airingId = md5(
                    $channel->slug.$startTime->copy()->timestamp
                );
                $isMovie = $channelAiring->episode->series->type == "film";

                $airing = new Airing([
                    'id'                    => $airingId,
                    'channelId'             => $channel->slug,
                    'source'                => "pluto",
                    'title'                 => $channelAiring->title,
                    'description'           => $channelAiring->episode->description,
                    'startTime'             => $startTime,
                    'stopTime'              => $stopTime,
                    'length'                => $length,
                    'programId'             => $channelAiring->episode->_id,
                    'isMovie'               => $isMovie
                ]);

                if (!$isMovie && $channelAiring->title !=
                    $channelAiring->episode->name) {
                    $airing->setSubTitle($channelAiring->episode->name);
                }

                if ($isMovie) {
                    $airingArt = $channelAiring->episode->poster->path;
                } else {
                    $airingArt = str_replace("h=660", "h=900",
                        str_replace("w=660", "w=900",    
                            $channelAiring->episode->series->tile->path
                        )
                    );
                }
                $airing->setImage($airingArt);

                if (isset($channelAiring->episode->series->_id)) {
                    $airing->setSeriesId($channelAiring->episode->series->_id);
                }

                if (!$isMovie) {
                    $airing->setEpisodeNumber($channelAiring->episode->number);
                }

                $originalReleaseDate = Carbon::parse(
                    $channelAiring->episode->clip->originalReleaseDate
                );

                $firstAiredDate = Carbon::parse(
                    $channelAiring->episode->firstAired
                );

                $airing->setOriginalReleaseDate($originalReleaseDate);
                $airing->setFirstAiredDate($firstAiredDate);

                if (!$isMovie && $firstAiredDate->isPast()) {
                    $airing->setIsPreviouslyShown(true);
                } elseif (!$isMovie) {
                    $airing->setIsNew(true);
                }

                $airing->addCategory($isMovie ? "Movie" : "Series");
                $airing->addCategory($channelAiring->episode->genre);
                $airing->addCategory($channelAiring->episode->subGenre);
                foreach($this->genres as $genreName => $genres) {
                    if (
                        in_array($channelAiring->episode->genre, $genres) ||
                        in_array($channelAiring->episode->subGenre, $genres) ||
                        in_array($channel->category, $genres)
                    ) {
                        $airing->addCategory($genreName);
                    }
                }

                $airing->addRating(new Rating(
                    $channelAiring->episode->rating));

                $guideEntry->addAiring($airing);
            }
            $guide->addGuideEntry($guideEntry);
        }
        
        return $guide;
    }

    private function generateChannel(stdClass $channel): Channel
    {
        $description = $this->getCleanDescription($channel->summary);
        $channelArt = $this->getChannelArt($channel->featuredImage->path);
        $streamUrl = $this->getStreamUrl($channel->stitched->urls[0]->url);
        
        return new Channel([
            "id"            => $channel->slug,
            "name"          => $channel->name,
            "number"        => $channel->number,
            "callSign"      => $channel->hash,
            "description"   => $description,
            "logo"          => $channel->colorLogoPNG->path ?? null,
            "channelArt"    => $channelArt,
            "category"      => $channel->category,
            "streamUrl"     => $streamUrl
        ]);
    }

    private function getCleanDescription(string $description): string
    {
        return str_replace('”', '',
                preg_replace('/(\r\n|\n|\r)/m', ' ', $description)
            );
    }

    private function getChannelArt(string $image): string
    {
        return str_replace("h=900", "h=562",
                str_replace("w=1600", "w=1000", $image)
            );
    }

    private function getStreamUrl(string $url): string
    {
        $params = http_build_query([
            'advertisingId'         => '',
            'appName'               => 'web',
            'appVersion'            => 'unknown',
            'appStoreUrl'           => '',
            'architecture'          => '',
            'buildVersion'          => '',
            'clientTime'            => '0',
            'deviceDNT'             => '0',
            'deviceId'              => Uuid::uuid1()->toString(),
            'deviceMake'            => 'Chrome',
            'deviceModel'           => 'web',
            'deviceType'            => 'web',
            'deviceVersion'         => 'unknown',
            'includeExtendedEvents' => 'false',
            'sid'                   => Uuid::uuid4()->toString(),
            'userId'                => '',
            'serverSideAds'         => 'true'
        ]);

        return strtok($url, "?") . "?" . $params;
    }
}