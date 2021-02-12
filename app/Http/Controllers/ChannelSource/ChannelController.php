<?php

namespace App\Http\Controllers\ChannelSource;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SourceChannel;
use ChannelsBuddy\SourceProvider\ChannelSourceProvider;
use ChannelsBuddy\SourceProvider\ChannelSourceProviders;
use ChannelsBuddy\SourceProvider\Models\Channel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;

class ChannelController extends Controller
{
    public function getChannels(ChannelSourceProvider $channelSource)
    {
        try {
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
                        (new Channel())->toArray();

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
        } catch (Throwable $e) {
            report($e);
            return response()->json([
                'error' => true,
                'message' => 'Unable to load channels, an error has occurred.'
            ], 500);
        }
    }

    public function updateChannel(Request $request)
    {
        try {
            $sourceName = $request->channelSource->getSourceName();
            $channel = $request->channel;

            $sourceChannel = SourceChannel::firstOrNew([
                'source' => $sourceName,
                'channel_id' => $channel['id']
            ]);

            $sourceChannel->channel_number =
                $channel['mapped_channel_number'] ??
                    $channel['number'] ?? null;
            $sourceChannel->channel_enabled =
                (int) $channel['channel_enabled'] ?? 0;
            $sourceChannel->customizations =
                $channel['customizations'];
            $sourceChannel->save();

            return response()->json([
                'error' => false,
                'message' => sprintf('%s saved.', $channel['name'])
            ], 200);
        } catch(Throwable $e) {
            report($e);
            return response()->json([
                'error' => true,
                'message' => 'Unable to save channel.'
            ], 400);
        }
    }

    public function updateChannels(Request $request)
    {
        try {
            $sourceName = $request->channelSource->getSourceName();
            $channels = collect($request->channels)
                ->transform(function($channel, $key) use ($sourceName) {
                    $channel = (object) $channel;
                    return [
                        'source' => $sourceName,
                        'channel_id' => $channel->id,
                        'channel_number' => $channel->mapped_channel_number ??
                            $channel->number ?? null,
                        'channel_enabled' =>
                            (int) $channel->channel_enabled ?? 0,
                        'customizations' => json_encode($channel->customizations)
                    ];
                })->values()->toArray();

            SourceChannel::upsert(
                $channels,
                [ 'source', 'channel_id' ],
                [ 'channel_number', 'channel_enabled', 'customizations' ],
            );

            Setting::updateSetting(
                "channelsource.{$sourceName}.channel_start_number",
                $request->channelStartNumber
            );

            return response()->json([
                'error' => false,
                'message' => 'Channels saved.'
            ], 200);
        } catch(Throwable $e) {
            report($e);
            return response()->json([
                'error' => true,
                'message' => 'Unable to save channels.'
            ], 400);
        }
    }

    public function mapUi(ChannelSourceProvider $channelSource, ChannelSourceProviders $sourceProviders)
    {
        $sourceName = $channelSource->getSourceName();
        $sources =
            collect($sourceProviders->toArray()['providers'])->values() ?? [];
            
        return Inertia::render('channelsource/Map', [
            'title' => $channelSource->getDisplayName() . ' - External Source Provider',
            'source' => $channelSource->toArray(),
            'sources' => $sources,
            'channelStartNumber' =>
                (int) Setting::getSetting(
                    "channelsource.{$sourceName}.channel_start_number"
                ),
        ]);
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