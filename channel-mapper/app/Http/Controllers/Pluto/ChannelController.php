<?php

namespace App\Http\Controllers\Pluto;

use App\Http\Controllers\Controller;
use App\Models\PlutoChannel;
use App\Models\Setting;
use App\Services\ChannelsBackendService;
use App\Services\PlutoBackendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class ChannelController extends Controller
{
    protected $plutoBackend;

    public function __construct()
    {
        $this->plutoBackend = new PlutoBackendService();
    }

    public function list(Request $request)
    {
        $channels = $this->plutoBackend->getChannels();

        $existingChannels = PlutoChannel::all()->keyBy("channel_id");

        $channels->transform(function ($channel, $key) use ($existingChannels) {
            $channel->mapped_channel_number = $existingChannels->get($key)->channel_number ?? $channel->number;
            $channel->channel_enabled = $existingChannels->get($key)->channel_enabled ?? true;
            return $channel;
        });

        return view('pluto.channels.map',
            [
                'channels' => $channels,
                'channelsBackendUrl' => (new ChannelsBackendService)->getBaseUrl(),
                'channelStartNumber' => Setting::getSetting('pluto.channel_start_number')
            ]
        );
    }

    public function map(Request $request)
    {
        $channels = collect($request->channel)->transform(function ($channel, $key) {
            return [
                'channel_id' => $key,
                'channel_number' => $channel['mapped'] ?? $channel['number'],
                'channel_enabled' => $channel['enabled'] ?? 0
            ];
        })->values()->toArray();

        PlutoChannel::upsert(
            $channels,
            [ 'channel_id' ],
            [ 'channel_number', 'channel_enabled' ],
        );

        Setting::updateSetting('pluto.channel_start_number', $request->channel_start_number);

        Cache::forget('pluto_m3u');

        return redirect(route('getPlutoMapUI'));

    }

    public function playlist(Request $request)
    {
        if ($request->has("fresh")) {
            Cache::forget('pluto_m3u');
        }

        $playlist = Cache::remember('pluto_m3u', 1800, function () {
            $channels = $this->plutoBackend->getChannels();
            $existingChannels = PlutoChannel::all()->keyBy("channel_id");

            $channels =
                $channels->filter(function ($channel, $key) use ($existingChannels) {
                    return $existingChannels->get($key)->channel_enabled ?? false;
                })->transform(function($channel, $key) use ($existingChannels) {
                    $channel->mappedChannelNum =
                        $existingChannels->get($key)->channel_number ?? $channel->number;
                    $channel->tvcArt = str_replace("h=900", "h=562",
                        str_replace("w=1600", "w=1000", $channel->featuredImage->path)
                    );
                    $channel->tvcGuideDescription = str_replace('"', '',
                        str_replace('”', '',
                            preg_replace('/(\r\n|\n|\r)/m', ' ', $channel->summary)
                        )
                    );

                    $params = [];
                    $params['advertisingId'] = '';
                    $params['appName'] = 'web';
                    $params['appVersion'] = 'unknown';
                    $params['appStoreUrl'] = '';
                    $params['architecture'] = '';
                    $params['buildVersion'] = '';
                    $params['clientTime'] = '0';
                    $params['deviceDNT'] = '0';
                    $params['deviceId'] = Uuid::uuid1()->toString();
                    $params['deviceMake'] = 'Chrome';
                    $params['deviceModel'] = 'web';
                    $params['deviceType'] = 'web';
                    $params['deviceVersion'] = 'unknown';
                    $params['includeExtendedEvents'] = 'false';
                    $params['sid'] = Uuid::uuid4()->toString();
                    $params['userId'] = '';
                    $params['serverSideAds'] = 'true';
                    $params = http_build_query($params);

                    $channel->stream = strtok($channel->stitched->urls[0]->url, "?") . "?" . $params;

                    return $channel;
                })->values()->sortBy('mappedChannelNum');
                
            return view('pluto.playlist.full', [
                'channels' => $channels
            ])->render();
        });

        return response($playlist)->header('Content-Type', 'application/x-mpegurl');
    }
}
