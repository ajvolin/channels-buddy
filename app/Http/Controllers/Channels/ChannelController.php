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

    public function index()
    {
        $sources = $this->channelSource->getDevices();

        if($sources->count() > 0) {
            return view('layouts.main', [
                'sources' => $sources,
            ]);
        }
        else {
            return view('empty', []);
        }
    }

    public function list(Request $request)
    {
        $source = $request->source;
        if(!$this->channelSource->isValidDevice($source)) {
            throw new InvalidSourceException('Invalid source detected.');
        }

        $allChannels = $this->channelSource->getGuideChannels()->channels;
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
            return $channel;
        });

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
                'channel_enabled' => $channel['enabled'] ?? 0
            ];
        })->values()->toArray();

        SourceChannel::upsert(
            $channels,
            [ 'source', 'channel_id' ],
            [ 'channel_number', 'channel_enabled' ]
        );

        return redirect(route('getChannelMapUI', ['source' => $source]));
    }

    public function playlist(Request $request)
    {
        $source = $request->source;
        $maxChannel = $request->max_channel;

        if(!$this->channelSource->isValidDevice($source)) {
            throw new InvalidSourceException('Invalid source detected.');
        }

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
                return $channel;
            })->values()->sortBy('mappedChannelNum');

        return response(view('playlist.full', [
            'channels' => $channels
        ]))->header('Content-Type', 'application/x-mpegurl');
    }
}
