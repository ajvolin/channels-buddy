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
        $this->baseUrl =
            'https://ott-gateway-stirr.sinclairstoryline.com/api/rest/v3/';
        $this->baseStationUrl =
            'https://ott-stationselection.sinclairstoryline.com/stationAutoSelection';

        $this->httpClient = new Client(['base_uri' => $this->baseUrl]);
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getChannels(): Channels
    {
        $channelList = collect([]);
        $stationLineups =
            config(
                'channels.channelSources.stirr.stationLineups', 
                ['national']
            );

        $lineupAutoSelectStream = $this->httpClient->get($this->baseStationUrl);
        $lineupAutoSelectJson = $lineupAutoSelectStream->getBody()->getContents();
        $lineupAutoSelectList = json_decode($lineupAutoSelectJson)->page;

        foreach ($lineupAutoSelectList as $lineups) {
            foreach ($lineups
                ->button
                ->{'media:content'}
                ->{'sinclair:action_config'}
                ->station as $lineup) {
                        
                if(!in_array($lineup, $stationLineups)) {
                    array_push($stationLineups, $lineup);
                }
            }
        }

        foreach ($stationLineups as $lineup) {
            $lineupChannelsStream = $this->httpClient->get(
                sprintf('channels/stirr?station=%s', $lineup)
            );
            $lineupChannelsJson = $lineupChannelsStream->getBody()->getContents();
            $lineupChannels = json_decode($lineupChannelsJson);
            foreach ($lineupChannels->channel as $lineupChannel) {
                if (!$channelList->has($lineupChannel->id)) {
                    try {
                        $channelsStream = $this->httpClient->get(
                            sprintf('status/%s', $lineupChannel->id)
                        );
                        $channelsJson = $channelsStream->getBody()->getContents();
                        $channels = json_decode($channelsJson);
                        foreach($channels as $channel) {
                            if (substr($channel->channel->title, 0, 3) != 'zzz') {
                                if (isset($lineupChannel->icon->src)) {
                                    $logo = str_replace(
                                        "180/center/90",
                                        "512/center/100",
                                        strtok(
                                            $lineupChannel->icon->src, '?'
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

                                $channelList->put($lineupChannel->id,
                                    new Channel([
                                        'id'            => $lineupChannel->id,
                                        'name'          => $channel->channel->title,
                                        'number'        => null,
                                        'callSign'      => $lineupChannel->{'display-name'},
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

        $channelList->filter(function($channel, $key){
            return $channel->callSign == 'dco';
        })->sortByDesc('name')
        ->each(function($channel, $key) use (&$channelList) {
            $channelList->pull($key);
            $channelList->prepend($channel, $key);
        });
        
        return new Channels($channelList->values()->toArray());
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
                            if(substr($category->value, 0, 2) == 'HD') {
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