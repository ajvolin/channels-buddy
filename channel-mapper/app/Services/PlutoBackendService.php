<?php

namespace App\Services;

use App\APIModels\Channel;
use App\Contracts\BackendService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class PlutoBackendService implements BackendService
{
    protected $baseUrl;
    protected $httpClient;

    public function __construct()
    {
        $this->baseUrl = 'http://api.pluto.tv';

        $this->httpClient = new Client(['base_uri' => $this->baseUrl]);
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getChannels(): Collection
    {
        $stream = $this->httpClient->get('/v2/channels');
        $json = $stream->getBody()->getContents();
        $channels = collect(json_decode($json))->filter(function($channel){
            return $channel->isStitched && !preg_match('/^announcement|^privacy-policy/', $channel->slug);
        })->transform(function($channel, $key) {
            $description = str_replace('”', '',
                preg_replace('/(\r\n|\n|\r)/m', ' ', $channel->summary)
            );
            $channelArt = str_replace("h=900", "h=562",
                str_replace("w=1600", "w=1000", $channel->featuredImage->path)
            );

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
            $streamUrl = strtok($channel->stitched->urls[0]->url, "?") . "?" . $params;

            return new Channel([
                "id" => $channel->slug,
                "number" => $channel->number,
                "name" => $channel->name,
                "description" => $description,
                "logo" => $channel->colorLogoPNG->path ?? null,
                "channelArt" => $channelArt,
                "category" => $channel->category,
                "streamUrl" => $streamUrl
            ]);
        })->sortBy('number')->keyBy('id');

        return $channels;
    }
 
    public function getGuideData($startTimestamp = null, $duration = null): Collection
    {
        $startTimestamp = Carbon::createFromTimestamp($startTimestamp);
        $startTime = urlencode($startTimestamp->format('Y-m-d H:i:s.vO'));
        $stopTime = urlencode($startTimestamp->copy()->addSeconds($duration)->format('Y-m-d H:i:s.vO'));

        $stream = $this->httpClient->get(
            sprintf('/v2/channels?start=%s&stop=%s', $startTime, $stopTime));
        $json = $stream->getBody()->getContents();
        $guide = collect(json_decode($json))->filter(function($channel){
            return $channel->isStitched && !preg_match('/^announcement|^privacy-policy/', $channel->slug);
        })->sortBy('number')->keyBy('slug');
        
        return $guide;
    }
}