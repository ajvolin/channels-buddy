<?php

namespace App\Services;

use App\APIModels\Channel;
use App\Contracts\BackendService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class StirrBackendService implements BackendService
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

    public function getChannels(): Collection
    {   
        $channels = Cache::remember('stirr_channels', 43200, function() {
            $channelList = collect([]);
            $stationLocations = ['national'];

            $statesListStream = $this->httpClient->get($this->baseStationUrl);
            $statesListJson = $statesListStream->getBody()->getContents();
            $statesList = collect(
                json_decode($statesListJson)->page
            )->filter(function($state){
                return str_starts_with($state->pageComponentUuid, 'nearyou-');
            });
            
            foreach($statesList as $state) {
                $stateStationsStream = $this->httpClient->get($state->content);
                $stateStationsJson = $stateStationsStream->getBody()->getContents();
                $stateStations = collect(
                    json_decode($stateStationsJson)->rss->channel->pagecomponent->component
                )->filter(function ($station) use ($stationLocations) {
                    return !in_array($station->item->{'media:content'}->{'sinclair:action_value'}, $stationLocations);
                });

                foreach ($stateStations as $station) {
                    array_push($stationLocations,
                        $station->item->{'media:content'}->{'sinclair:action_value'}
                    );
                }
            }

            foreach ($stationLocations as $location) {
                $locationChannelsStream = $this->httpClient->get(
                    sprintf('channels/stirr?station=%s', $location)
                );
                $locationChannelsJson = $locationChannelsStream->getBody()->getContents();
                $locationChannels = json_decode($locationChannelsJson);
                foreach ($locationChannels->channel as $locationChannel) {
                    if (!$channelList->has($locationChannel->id)) {
                        try {
                            $channelsStream = $this->httpClient->get(
                                sprintf('status/%s', $locationChannel->id)
                            );
                            $channelsJson = $channelsStream->getBody()->getContents();
                            $channels = json_decode($channelsJson);
                            foreach($channels as $channel) {
                                if (!str_starts_with($channel->channel->title, 'zzz')) {
                                    $channelList->put($locationChannel->id,
                                        new Channel([
                                            'id'            => $locationChannel->id,
                                            'name'          => $channel->channel->title,
                                            'description'   => $channel->channel->description,
                                            'logo'          => strtok(
                                                    $locationChannel->icon->src ?? '', '?'
                                                ) ?: null,
                                            'category'      => $channel->channel->item->category,
                                            'streamUrl'     => $channel->channel->item->link
                                        ])
                                    );
                                }
                            }
                        } catch (RequestException $e) {}
                    }
                }
            }
            return $channelList;
        });

        return $channels;
    }

    public function getGuideData($startTimestamp, $duration): Collection
    {
        $guide = collect([]);
        $channels = $this->getChannels();

        foreach ($channels as $channel) {
            $stream = $this->httpClient->get(
                sprintf('program/stirr/ott/%s', $channel->id)
            );
            $json = $stream->getBody()->getContents();
            $guideData = collect(json_decode($json)->programme);

            $guideEntry = [
                'channel' => $channel,
                'airings' => []
            ];
            
            foreach ($guideData as $entry) {
                $startTime = Carbon::parse($entry->start);
                $endTime = Carbon::parse($entry->stop);
                $duration = $startTime->copy()->diffInSeconds($endTime);
                $startTime = $startTime->format('YmdHis O');
                $endTime = $endTime->format('YmdHis O');

                array_push($guideEntry['airings'], [
                    'title'         => $entry->title->value,
                    'description'   => $entry->desc->value,
                    'startTime'     => $startTime,
                    'endTime'       => $endTime,
                    'duration'      => $duration
                ]);
            }

            $guide->push($channel->id, $guideEntry);
        }
        
        return $guide;
    }
}