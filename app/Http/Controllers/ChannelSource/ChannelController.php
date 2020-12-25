<?php

namespace App\Http\Controllers\ChannelSource;

use App\Contracts\BackendService;
use App\Http\Controllers\Controller;
use App\Models\ExternalChannel;
use App\Models\Setting;
use App\Services\ChannelsBackendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChannelController extends Controller
{
    protected $backend;

    public function __construct(BackendService $backend)
    {
        $this->backend = $backend;
    }

    public function list(Request $request, $source)
    {
        $channels = collect($this->backend->getChannels()->channels)->keyBy('id');

        $existingChannels = ExternalChannel::where('source', $source)->get()->keyBy("channel_id");

        $channels->transform(function ($channel, $key) use ($existingChannels) {
            $channel->mapped_channel_number = $existingChannels->get($key)->channel_number ?? $channel->number;
            $channel->channel_enabled = $existingChannels->get($key)->channel_enabled ?? true;
            return $channel;
        });

        return view('channelsource.channels.map',
            [
                'channels' => $channels,
                'channelsBackendUrl' => (new ChannelsBackendService)->getBaseUrl(),
                'channelStartNumber' => Setting::getSetting("{$source}_channelsource.channel_start_number"),
                'channelSource' => $source,
                'channelSources' => collect(config('channels.channelSources'))
            ]
        );
    }

    public function map(Request $request, $source)
    {
        $channels = collect($request->channel)->transform(function ($channel, $key) use ($source) {
            return [
                'source' => $source,
                'channel_id' => $key,
                'channel_number' => $channel['mapped'] ?? $channel['number'],
                'channel_enabled' => $channel['enabled'] ?? 0
            ];
        })->values()->toArray();

        ExternalChannel::upsert(
            $channels,
            [ 'channel_id' ],
            [ 'source', 'channel_number', 'channel_enabled' ],
        );

        Setting::updateSetting("{$source}_channelsource.channel_start_number", $request->channel_start_number);

        Cache::forget("{$source}_channelsource_m3u");

        return redirect(route('getChannelSourceMapUI', ['channelSource' => $source]));

    }

    public function playlist(Request $request, $source)
    {
        if ($request->has("fresh")) {
            Cache::forget("{$source}_channelsource_m3u");
        }

        $playlist = Cache::remember("{$source}_channelsource_m3u", 1800, function () use ($source) {
            $channels = collect($this->backend->getChannels()->channels)->keyBy('id');
            $existingChannels = ExternalChannel::where('source', $source)->get()->keyBy("channel_id");

            $channels =
                $channels->filter(function ($channel, $key) use ($existingChannels) {
                    return $existingChannels->get($key)->channel_enabled ?? false;
                })->transform(function($channel, $key) use ($existingChannels) {
                    $channel->mappedChannelNum =
                        $existingChannels->get($key)->channel_number ?? $channel->number ?? null;
                    return $channel;
                })->values()->sortBy('mappedChannelNum');
                
            return view('playlist.full', [
                'channels' => $channels
            ])->render();
        });

        return response($playlist)->header('Content-Type', 'application/x-mpegurl');
    }
}
