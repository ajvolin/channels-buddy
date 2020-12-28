<?php

namespace App\Http\Controllers\Channels;

use App\Http\Controllers\Controller;
use App\Models\DvrChannel;
use App\Services\ChannelsBackendService;
use Exception;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    protected $channelsBackend;

    public function __construct(ChannelsBackendService $channelsBackend)
    {
        $this->channelsBackend = $channelsBackend;
    }

    public function index()
    {
        $sources = $this->channelsBackend->getDevices();

        if($sources->count() > 0) {
            return view('layouts.main', [
                'sources' => $sources,
                'channelsBackendUrl' => $this->channelsBackend->getBaseUrl(),
            ]);
        }
        else {
            return view('empty', ['channelsBackendUrl' => $this->channelsBackend->getBaseUrl()]);
        }
    }

    public function list(Request $request)
    {
        $source = $request->source;
        if(!$this->channelsBackend->isValidDevice($source)) {
            throw new Exception('Invalid source detected.');
        }

        $allChannels = $this->channelsBackend->getGuideChannels()->channels;
        $sourceChannels = $this->channelsBackend->getChannels($source)->channels;

        $existingChannels = DvrChannel::all()->keyBy("guide_number");

        $sourceChannels = $sourceChannels->map(function ($channel, $key) use ($existingChannels) {
            $channel->mapped_channel_number = 
                $existingChannels->get($key)->mapped_channel_number ??
                    $channel->number;
            $channel->channel_enabled =
                $existingChannels->get($key)->channel_enabled ?? true;
            return $channel;
        });

        return view('channels.remap.map',
            [
                'source' => $source,
                'sources' => $this->channelsBackend->getDevices(),
                'allChannels' => $allChannels,
                'sourceChannels' => $sourceChannels,
                'channelsBackendUrl' => $this->channelsBackend->getBaseUrl(),
            ]
        );

    }

    public function map(Request $request)
    {
        $source = $request->source;
        if(!$this->channelsBackend->isValidDevice($source)) {
            throw new Exception('Invalid source detected.');
        }

        $channels = collect($request->channel)->transform(function ($channel, $key) {
            return [
                'guide_number' => $key,
                'mapped_channel_number' => $channel['mapped'] ?? $key,
                'channel_enabled' => $channel['enabled'] ?? 0
            ];
        })->values()->toArray();

        DvrChannel::upsert(
            $channels,
            [ 'guide_number' ],
            [ 'mapped_channel_number', 'channel_enabled' ],
        );

        return redirect(route('getChannelMapUI', ['source' => $source]));

    }

    public function playlist(Request $request)
    {
        $source = $request->source;
        if(!$this->channelsBackend->isValidDevice($source)) {
            throw new Exception('Invalid source detected.');
        }

        $channels = $this->channelsBackend->getChannels($source)->channels;
        $existingChannels = DvrChannel::all()->keyBy("guide_number");

        $channels =
            $channels->filter(function ($channel, $key) use ($existingChannels) {
                return $existingChannels->get($key)->channel_enabled ?? true;
            })->map(function($channel, $key) use ($existingChannels) {
                $channel->mappedChannelNum =
                    $existingChannels->get($key)->mapped_channel_number ??
                        $channel->number;
                return $channel;
            })->values()->sortBy('mappedChannelNum');

        return response(view('playlist.full', [
            'channels' => $channels
        ]))->header('Content-Type', 'application/x-mpegurl');
    }
}
