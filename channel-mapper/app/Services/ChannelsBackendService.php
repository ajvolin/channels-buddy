<?php

namespace App\Services;

use GuzzleHttp\Client;

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
                env('CHANNELS_SERVER_IP'), env('CHANNELS_SERVER_PORT')
            );
        
        $this->playlistBaseUrl =
            sprintf("http://%s:%s",
                env('CHANNELS_SERVER_IP_FOR_PLAYLIST'), env('CHANNELS_SERVER_PORT_FOR_PLAYLIST')
            );

        $this->httpClient = new Client(['base_uri' => $this->baseUrl]);

    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getPlaylistBaseUrl()
    {
        return $this->playlistBaseUrl;
    }

    public function getScannedChannels($source)
    {
        $deviceChannelsStream = $this->httpClient->get(sprintf('/devices/%s/channels?ScanResult=true', $source));
        $deviceChannelsJson = $deviceChannelsStream->getBody()->getContents();
        $deviceChannels = collect(json_decode($deviceChannelsJson))->filter(function ($channel, $key) {
            return (property_exists($channel, 'Hidden') && $channel->Hidden == 1) ? false : true;
        })->keyBy('GuideNumber');

        $guideChannelsStream = $this->httpClient->get(sprintf('/devices/%s/guide?time=1&duration=1', $source));
        $guideChannelsJson = $guideChannelsStream->getBody()->getContents();
        $guideChannels = collect(json_decode($guideChannelsJson))->pluck('Channel')->keyBy("Number");

        $deviceChannels->transform(function ($channel, $key) use ($guideChannels) {
            $channel->CallSign = $guideChannels->get($key)->CallSign ?? $channel->GuideName;
            return $channel;
        });

        unset($deviceChannelsStream, $deviceChannelsJson,
                $guideChannelsStream, $guideChannelsJson,
                $guideChannels
            );

        return $deviceChannels;
    }

    public function getGuideData($device, $startTimestamp, $duration)
    {
        $stream = $this->httpClient->get(
            sprintf('/devices/%s/guide?time=%d&duration=%d', $device, $startTimestamp, $duration));
        $json = $stream->getBody()->getContents();
        return json_decode($json);
    }

    public function isValidDevice($device)
    {
        return ($this->getDevices(true)->has($device) !== false);
    }

    public function getDevices($allowAny = true)
    {
        $stream = $this->httpClient->get(sprintf('/devices'));
        $json = $stream->getBody()->getContents();

        $devices = collect(json_decode($json))->pluck('FriendlyName', 'DeviceID');
        if($allowAny) {
            $devices->prepend('All Devices', 'ANY');
        }

        return $devices;

    }


}
