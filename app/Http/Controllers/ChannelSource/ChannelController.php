<?php

namespace App\Http\Controllers\ChannelSource;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SourceChannel;
use ChannelsBuddy\SourceProvider\ChannelSourceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class ChannelController extends Controller
{
    public function getChannels(ChannelSourceProvider $channelSource)
    {
        $sourceName = $channelSource->getSourceName();
        $service = $channelSource->getChannelSourceService();
        $channels = $service->getChannels()->channels;

        $existingChannels = SourceChannel::where('source', $sourceName)
            ->get()
            ->keyBy("channel_id");

        $channels = $channels->map(function ($channel, $key) use ($existingChannels) {
            $existingChannel =
                $existingChannels->get($key) ?? null;
            $channel->mapped_channel_number =
                $existingChannel->channel_number ?? null;

            $channel->channel_enabled =
                (bool) ($existingChannel
                        ->channel_enabled ?? true);

            $channel->customizations =
                $existingChannel->customizations ??
                    [
                        'callSign'  => null,
                        'category'  => null,
                        'channelArt' => null,
                        'description' => null,
                        'logo' => null,
                        'name' => null,
                        'stationId' => null,
                        'title' => null
                    ];

            return $channel;
        })->sortBy(function($channel) {
            return $channel->sortValue ??
                $channel->number ??
                $channel->name ??
                $channel->title ??
                $channel->callSign ??
                $channel->id;
        }, SORT_NATURAL | SORT_FLAG_CASE);
        
        return response()->json($channels->values(), 200);
    }

    public function updateChannels(Request $request)
    {

    }

    public function mapUi(ChannelSourceProvider $channelSource)
    {
        $sourceName = $channelSource->getSourceName();

        return Inertia::render('channelsource/Map', [
            'title' => $channelSource->getDisplayName() . ' - External Source Provider',
            'source' => $channelSource->toArray(),
            'channelStartNumber' => (int) Setting::getSetting("{$sourceName}_channelsource.channel_start_number"),
        ]);
    }

    public function applyMap(Request $request)
    {
        $sourceName = $request->channelSource->getSourceName();
        
        $channels = collect($request->channel)
            ->transform(function ($channel, $key) use ($sourceName) {
            return [
                'source' => $sourceName,
                'channel_id' => $key,
                'channel_number' => $channel['mapped'] ?? $channel['number'],
                'channel_enabled' => $channel['enabled'] ?? 0,
                'custom_logo' => $channel['custom_logo'] ?? null,
                'custom_channel_art' => $channel['custom_channel_art'] ?? null
            ];
        })->values()->toArray();

        SourceChannel::upsert(
            $channels,
            [ 'source', 'channel_id' ],
            [ 'channel_number', 'channel_enabled', 'custom_logo', 'custom_channel_art' ],
        );

        Setting::updateSetting(
            "{$sourceName}_channelsource.channel_start_number",
            $request->channel_start_number
        );

        Cache::forget("{$sourceName}_channelsource_m3u");

        return redirect(route('channel-source.source.map-ui', ['channelSource' => $sourceName]));
    }

    public function playlist(Request $request)
    {
        return response()->stream(function() use ($request) {
            $sourceName = $request->channelSource->getSourceName();
            $service = $request->channelSource->getChannelSourceService();

            echo "#EXTM3U\n\n";
            flush();

            $channels = $service->getChannels()->channels;
            $existingChannels = SourceChannel::where('source', $sourceName)
                ->get()
                ->keyBy("channel_id");

            $channels =
                $channels->filter(function ($channel, $key) use ($existingChannels) {
                    return $existingChannels->get($key)->channel_enabled ?? false;
                })->map(function($channel, $key) use ($existingChannels, $sourceName) {
                    $channel->mappedChannelNum =
                        $existingChannels->get($key)->channel_number ?? $channel->number ?? null;
                    $channel->logo = $existingChannels->get($key)->custom_logo ??
                        $channel->logo ?? null;
                    $channel->channelArt = $existingChannels->get($key)->custom_channel_art ??
                        $channel->channelArt ?? null;
                    $channel->id =
                        sprintf('%s.%s', $sourceName, $channel->id);
                    return $channel;
                });

            foreach($channels as $channel) {
                echo view('playlist.channel', [
                    'channel' => $channel
                ])->render();
                flush();
            }
        }, 200,
        [
            'Content-Type' => 'application/x-mpegurl',
            'X-Accel-Buffering' => 'no'
        ]);
    }
}