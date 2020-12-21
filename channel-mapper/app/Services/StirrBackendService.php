<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class StirrBackendService
{
    protected $baseUrl;
    protected $baseStationUrl;
    protected $httpClient;

    public function __construct()
    {
        $this->baseUrl = 'https://ott-gateway-stirr.sinclairstoryline.com/api/rest/v3/';
        $this->baseStationUrl = 'https://ott-stationselection.sinclairstoryline.com/stationSelectionByAllStates';

        $this->httpClient = new Client(['base_uri' => $this->baseUrl]);
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getChannels(): array
    {
        $channelList = [];
        $channelIds = [];
        $stationLocations = ["national"];

        # get $this->baseStationUrl
        $statesListStream = $this->httpClient->get($this->baseStationUrl);
        $statesListJson = $statesListStream->getBody()->getContents();
        $statesList = collect(
            json_decode($statesListJson)->page
        )->filter(function($state){
            return str_starts_with($state->pageComponentUuid, 'nearyou-');
        })->each(function($state) use ($stationLocations){
            $stateStationsStream = $this->httpClient->get($state->content);
            $stateStationsJson = $stateStationsStream->getBody()->getContents();
            collect(
                json_decode($stateStationsJson)->rss->channel->pagecomponent->component
            )->filter(function($station) use ($stationLocations) {
                return !in_array($station, $stationLocations);
            })->each(function($station) use ($stationLocations) {
                array_push($stationLocations,
                    $station->item->{'media:content'}->{'sinclair:action_value'}
                );
            });
        });

        foreach ($stationLocations as $location) {
            $locationStream = $this->httpClient->get(
                sprintf('channels/stirr?station=%s', $location)
            );
            $locationJson = $locationStream->getBody()->getContents();
            $location = collect(
                json_decode($locationJson)
            )->each(function($channel) use ($channelIds, $channelList) {
                if (isset($channel->id) && !in_array($channel->id, $channelIds)) {
                    $channelStream = $this->httpClient->get(
                        sprintf('status/%s', $channel->id)
                    );
                    $channelJson = $channelStream->getBody()->getContents();
                    $channels = collect(
                        json_decode($channelJson)
                    )->each(function($chan) use ($channel, $channelIds, $channelList) {
                        array_push($channelIds, $channel->id);
                        array_push($channelList, $chan);
                    });
                }
            });
        }

        return $channelList;
    }
}