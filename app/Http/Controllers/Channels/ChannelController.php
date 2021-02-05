<?php

namespace App\Http\Controllers\Channels;

use App\Http\Controllers\Controller;
use App\Models\SourceChannel;
use App\Services\ChannelsService;
use ChannelsBuddy\SourceProvider\Exceptions\InvalidSourceException;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    protected $channelSource;

    public function __construct(ChannelsService $channelSource)
    {
        $this->channelSource = $channelSource;
    }

    public function list(Request $request)
    {
        $source = $request->source;
        if(!$this->channelSource->isValidDevice($source)) {
            throw new InvalidSourceException('Invalid source detected.');
        }

        $allChannels = $this->channelSource
            ->getGuideChannels()
            ->channels
            ->sortBy('number');
        $sourceChannels = $this->channelSource->getChannels($source)->channels;

        $existingChannels = SourceChannel::where('source', 'channels')
            ->get()
            ->keyBy("channel_id");

        $sourceChannels = $sourceChannels->map(function ($channel, $key) use ($existingChannels) {
            $channel->mapped_channel_number = 
                $existingChannels->get($key)->channel_number ??
                    $channel->number;
            $channel->channel_enabled =
                $existingChannels->get($key)->channel_enabled ?? true;
            $channel->logo =
                $existingChannels->get($key)->custom_logo ?? $channel->logo ?? null;
            $channel->channelArt =
                $existingChannels->get($key)->custom_channel_art ?? $channel->channelArt ?? null;
            $channel->custom_logo =
                $existingChannels->get($key)->custom_logo ?? null;
            $channel->custom_channel_art =
                $existingChannels->get($key)->custom_channel_art ?? null;
            return $channel;
        })->sortBy('number');

        return view('channels.remap.map',
            [
                'source' => $source,
                'sources' => $this->channelSource->getDevices(),
                'allChannels' => $allChannels,
                'sourceChannels' => $sourceChannels,
                'channelsBackendUrl' => $this->channelSource->getBaseUrl(),
            ]
        );
    }

    public function map(Request $request)
    {
        $source = $request->source;
        if(!$this->channelSource->isValidDevice($source)) {
            throw new InvalidSourceException('Invalid source detected.');
        }

        $channels = collect($request->channel)
            ->transform(function ($channel, $key) use ($source) {
            return [
                'source' => "channels",
                'channel_id' => $key,
                'channel_number' => $channel['mapped'] ?? $key,
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

        return redirect(route('getChannelMapUI', ['source' => $source]));
    }

    public function playlist(Request $request)
    {
        $source = $request->source;

        if(!$this->channelSource->isValidDevice($source)) {
            throw new InvalidSourceException('Invalid source detected.');
        }

        return response()->stream(function() use ($request, $source) {
            echo "#EXTM3U\n\n";
            flush();

            $maxChannel = $request->max_channel;
            $channels = $this->channelSource->getChannels($source)->channels;
            $existingChannels = SourceChannel::where('source', 'channels')
                ->get()
                ->keyBy("channel_id");

            $channels =
                $channels->filter(function ($channel, $key) use ($existingChannels, $maxChannel) {
                    return (!is_null($maxChannel) ? intval($key) <= $maxChannel : true)
                        && ($existingChannels->get($key)->channel_enabled ?? true);
                })->map(function($channel, $key) use ($existingChannels) {
                    $channel->mappedChannelNum =
                        $existingChannels->get($key)->channel_number ??
                            $channel->number;
                    $channel->logo = $existingChannels->get($key)->custom_logo ??
                        $channel->logo ?? null;
                    $channel->channelArt = $existingChannels->get($key)->custom_channel_art ??
                        $channel->channelArt ?? null;

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