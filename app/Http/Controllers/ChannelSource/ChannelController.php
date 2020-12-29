<?php

namespace App\Http\Controllers\ChannelSource;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SourceChannel;
use App\Services\ChannelsService;
use ChannelsBuddy\SourceProvider\ChannelSourceProviders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChannelController extends Controller
{
    protected $channelSource;

    public function __construct(Request $request, ChannelSourceProviders $channelSources)
    {
        $source = $channelSources
            ->getChannelSourceProvider($request->channelSource);
        $serviceClass = $source->getChannelSourceClass();
        $this->channelSource = new $serviceClass;
    }

    public function list(Request $request, $source)
    {
        $channels = $this->channelSource->getChannels()->channels;

        $existingChannels = SourceChannel::where('source', $source)
            ->get()
            ->keyBy("channel_id");

        $channels = $channels->map(function ($channel, $key) use ($existingChannels) {
            $channel->mapped_channel_number = $existingChannels->get($key)->channel_number ?? $channel->number;
            $channel->channel_enabled = $existingChannels->get($key)->channel_enabled ?? true;
            return $channel;
        });

        return view('channelsource.channels.map',
            [
                'channels' => $channels,
                'channelsBackendUrl' => (new ChannelsService)->getBaseUrl(),
                'channelStartNumber' => Setting::getSetting("{$source}_channelsource.channel_start_number"),
                'channelSource' => $source,
                'channelSources' => collect(config('channels.channelSources'))
            ]
        );
    }

    public function map(Request $request, $source)
    {
        $channels = collect($request->channel)
            ->transform(function ($channel, $key) use ($source) {
            return [
                'source' => $source,
                'channel_id' => $key,
                'channel_number' => $channel['mapped'] ?? $channel['number'],
                'channel_enabled' => $channel['enabled'] ?? 0
            ];
        })->values()->toArray();

        SourceChannel::upsert(
            $channels,
            [ 'source', 'channel_id' ],
            [ 'channel_number', 'channel_enabled' ],
        );

        Setting::updateSetting(
            "{$source}_channelsource.channel_start_number",
            $request->channel_start_number
        );

        Cache::forget("{$source}_channelsource_m3u");

        return redirect(route('getChannelSourceMapUI', ['channelSource' => $source]));

    }

    public function playlist(Request $request, $source)
    {
        if ($request->has("fresh")) {
            Cache::forget("{$source}_channelsource_m3u");
        }

        $playlist = Cache::remember("{$source}_channelsource_m3u", 1800, function () use ($source) {
            $channels = $this->channelSource->getChannels()->channels;
            $existingChannels = SourceChannel::where('source', $source)
                ->get()
                ->keyBy("channel_id");

            $channels =
                $channels->filter(function ($channel, $key) use ($existingChannels) {
                    return $existingChannels->get($key)->channel_enabled ?? false;
                })->map(function($channel, $key) use ($existingChannels) {
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
