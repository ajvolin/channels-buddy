<?php

namespace App\Services;

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
                env('CHANNELS_SERVER_IP'), env('CHANNELS_SERVER_PORT')
            );
        
        $this->playlistBaseUrl =
            sprintf("http://%s:%s",
                env('CHANNELS_SERVER_IP_FOR_PLAYLIST'), env('CHANNELS_SERVER_PORT_FOR_PLAYLIST')
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

    public function getEnabledChannels($source): Collection
    {
        $guideChannels = $this->getGuideChannels();
        $enabledChannels = $this->getDeviceChannels($source)->filter(function ($channel, $key) {
                return (property_exists($channel, 'Hidden') && $channel->Hidden == 1) ? false : true;
            })->transform(function ($channel, $key) use ($guideChannels) {
                    $channel->CallSign = $guideChannels->get($key)->CallSign ?? $channel->GuideName;
                    $channel->Name = $guideChannels->get($key)->Name ?? $channel->GuideName;
                    return $channel;
            });

        return $enabledChannels;
    }

    public function getDeviceChannels($source): Collection
    {
        $deviceChannelsStream = $this->httpClient->get(sprintf('/devices/%s/channels', $source));
        $deviceChannelsJson = $deviceChannelsStream->getBody()->getContents();
        $deviceChannels = collect(json_decode($deviceChannelsJson))->keyBy('GuideNumber')->sortBy("GuideNumber");

        return $deviceChannels;
    }

    public function getGuideChannels(): Collection
    {
        $stream = $this->httpClient->get('/dvr/guide/channels');
        $json = $stream->getBody()->getContents();
        $channels = collect(json_decode($json))->sortBy('Number');

        return $channels;
    }

    public function getGuideData($device, $startTimestamp, $duration)
    {
        $stream = $this->httpClient->get(
            sprintf('/devices/%s/guide?time=%d&duration=%d', $device, $startTimestamp, $duration));
        $json = $stream->getBody()->getContents();
        return json_decode($json);
    }

    public function isValidDevice($device): bool
    {
        return ($this->getDevices()->has($device) !== false);
    }

    public function getDevices($allowAny = true): Collection
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
