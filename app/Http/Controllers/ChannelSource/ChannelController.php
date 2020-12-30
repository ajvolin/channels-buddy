<?php

namespace App\Http\Controllers\ChannelSource;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SourceChannel;
use ChannelsBuddy\SourceProvider\ChannelSourceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChannelController extends Controller
{
    public function list(ChannelSourceProvider $channelSource)
    {
        $sourceName = $channelSource->getSourceName();
        $service = $channelSource->getChannelSourceService();
        $channels = $service->getChannels()->channels;

        $existingChannels = SourceChannel::where('source', $sourceName)
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
                'channelStartNumber' => Setting::getSetting("{$sourceName}_channelsource.channel_start_number"),
                'channelSource' => $sourceName,
            ]
        );
    }

    public function map(Request $request)
    {
        $sourceName = $request->channelSource->getSourceName();
        
        $channels = collect($request->channel)
            ->transform(function ($channel, $key) use ($sourceName) {
            return [
                'source' => $sourceName,
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
            "{$sourceName}_channelsource.channel_start_number",
            $request->channel_start_number
        );

        Cache::forget("{$sourceName}_channelsource_m3u");

        return redirect(route('getChannelSourceMapUI', ['channelSource' => $sourceName]));

    }

    public function playlist(Request $request)
    {
        $sourceName = $request->channelSource->getSourceName();
        $service = $request->channelSource->getChannelSourceService();

        if ($request->has("fresh")) {
            Cache::forget("{$sourceName}_channelsource_m3u");
        }

        $playlist = Cache::remember("{$sourceName}_channelsource_m3u", 1800, function () use ($sourceName, $service) {
            $channels = $service->getChannels()->channels;
            $existingChannels = SourceChannel::where('source', $sourceName)
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
