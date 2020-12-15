<?php

namespace App\Http\Controllers;

use App\Models\DvrChannel;
use App\Services\ChannelsBackendService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    protected $channelsBackend;

    public function __construct()
    {
        $this->channelsBackend = new ChannelsBackendService();
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

        $allChannels = $this->channelsBackend->getGuideChannels();
        $sourceChannels = $this->channelsBackend->getEnabledChannels($source);

        $existingChannels = DvrChannel::all()->keyBy("guide_number");

        $sourceChannels->transform(function ($channel, $key) use ($existingChannels) {
            $channel->mapped_channel_number = $existingChannels->get($key)->mapped_channel_number ?? $channel->GuideNumber;
            $channel->channel_enabled = $existingChannels->get($key)->channel_enabled ?? true;
            return $channel;
        });

        return view('channels.map',
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

        $scannedChannels = $this->channelsBackend->getEnabledChannels($source);
        $existingChannels = DvrChannel::all()->keyBy("guide_number");

        $scannedChannels =
            $scannedChannels->filter(function ($channel, $key) use ($existingChannels) {
                return $existingChannels->get($key)->channel_enabled ?? true;
            })->transform(function($channel, $key) use ($existingChannels) {
                $channel->mappedChannelNum =
                    $existingChannels->get($key)->mapped_channel_number ?? $channel->GuideNumber;
                return $channel;
            })->values()->sortBy('mappedChannelNum');

        return response(view('channels.playlist.full', [
            'scannedChannels' => $scannedChannels,
            'channelsBackendUrl' => $this->channelsBackend->getPlaylistBaseUrl(),
            'source' => $source,
        ]))->header('Content-Type', 'application/x-mpegurl');
    }
}
