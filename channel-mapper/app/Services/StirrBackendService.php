<?php

namespace App\Services;

use App\APIModels\Airing;
use App\APIModels\Channel;
use App\APIModels\Channels;
use App\APIModels\Guide;
use App\APIModels\GuideEntry;
use App\Contracts\BackendService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
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

    public function getChannels(): Channels
    {
        $channels = Cache::remember('stirr_channels', 3600, function() {
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
                                    if (isset($locationChannel->icon->src)) {
                                        $logo = str_replace(
                                            "180/center/90",
                                            "512/center/100",
                                            strtok(
                                                $locationChannel->icon->src, '?'
                                            )
                                        );
                                        $channelArt = str_replace(
                                            "512/center/100",
                                            "1024/center/100",
                                            $logo
                                        );
                                    } else {
                                        $logo = null;
                                        $channelArt = null;
                                    }

                                    $channelList->put($locationChannel->id,
                                        new Channel([
                                            'id'            => $locationChannel->id,
                                            'name'          => $channel->channel->title,
                                            'number'        => null,
                                            'description'   => $channel->channel->description,
                                            'logo'          => $logo,
                                            'channelArt'    => $channelArt,
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

        return new Channels($channels->values()->toArray());
    }

    public function getGuideData($startTimestamp = null, $duration = null): Guide
    {
        $guide = new Guide;
        $channels = $this->getChannels()->channels;

        foreach ($channels as $channel) {
            try {
                $stream = $this->httpClient->get(
                    sprintf('program/stirr/ott/%s', $channel->id)
                );
                $json = $stream->getBody()->getContents();
                $guideData = collect(json_decode($json)->programme);

                $guideEntry = new GuideEntry($channel);
                
                foreach ($guideData as $entry) {
                    $startTime = Carbon::parse($entry->start);
                    $stopTime = Carbon::parse($entry->stop);
                    $length = $startTime->copy()->diffInSeconds($stopTime);
                    $airingId = $channel->id . $startTime->copy()->timestamp;
                    $seriesId = md5($entry->title->value);
                    $programId = $seriesId.".".md5($entry->desc->value);
                    $isLive = filter_var($entry->{'sinclair:isLiveProgram'},
                        FILTER_VALIDATE_BOOLEAN
                    );

                    $airing = new Airing([
                        'id'                    => $airingId,
                        'channelId'             => $channel->id,
                        'source'                => "stirr",
                        'title'                 => $entry->title->value,
                        'titleLanguage'         => substr($entry->title->lang, 0, 2),
                        'description'           => $entry->desc->value,
                        'descriptionLanguage'   => substr($entry->desc->lang, 0, 2),
                        'startTime'             => $startTime,
                        'stopTime'              => $stopTime,
                        'length'                => $length,
                        'programId'             => $programId,
                        'seriesId'              => $seriesId,
                        'isLive'                => $isLive
                    ]);
                    
                    if (isset($entry->category)) {
                        foreach ($entry->category as $category) {
                            if(str_starts_with($category->value, "HD")) {
                                $airing->setIsHdtv(true);
                            }
                            if($category->value == 'Live') {
                                $airing->setIsLive(true);
                            }
                            if($category->value == 'New') {
                                $airing->setIsNew(true);
                            }
                            if($category->value == 'Stereo') {
                                $airing->setIsStereo(true);
                            }
                            if($category->value == 'CC') {
                                $airing->setHasClosedCaptioning(true);
                            }
                        }
                    }

                    $guideEntry->addAiring($airing);
                }
                
                $guide->addGuideEntry($guideEntry);
            } catch (RequestException $e) {}
        }
        return $guide;
    }
}