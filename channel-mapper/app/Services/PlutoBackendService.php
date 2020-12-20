<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;

class PlutoBackendService
{
    protected $baseUrl;
    protected $httpClient;

    public function __construct()
    {
        $this->baseUrl = 'http://api.pluto.tv';

        $this->httpClient = new Client(['base_uri' => $this->baseUrl]);
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getChannels()
    {
        $stream = $this->httpClient->get('/v2/channels');
        $json = $stream->getBody()->getContents();
        $channels = collect(json_decode($json))->filter(function($channel){
            return $channel->isStitched && !preg_match('/^announcement|^privacy-policy/', $channel->slug);
        });

        return $channels;
    }
 
    public function getGuideData($startTimestamp, $duration)
    {
        $startTimestamp = Carbon::createFromTimestamp($startTimestamp);
        $startTime = urlencode($startTimestamp->format('Y-m-d H:i:s.vO'));
        $stopTime = urlencode($startTimestamp->copy()->addSeconds($duration)->format('Y-m-d H:i:s.vO'));

        $stream = $this->httpClient->get(
            sprintf('/v2/channels?start=%s&stop=%s', $startTime, $stopTime));
        $json = $stream->getBody()->getContents();
        $guide = collect(json_decode($json))->filter(function($channel){
            return $channel->isStitched && !preg_match('/^announcement|^privacy-policy/', $channel->slug);
        });
        
        return $guide;
    }
}