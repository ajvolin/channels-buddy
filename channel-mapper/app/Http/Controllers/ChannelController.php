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

        $channels = $this->channelsBackend->getScannedChannels($source);

        $existingChannels = DvrChannel::all()->keyBy("guide_number");

        $channels->transform(function ($channel, $key) use ($existingChannels) {
            $channel->mapped_channel_number = $existingChannels->get($key)->mapped_channel_number ?? $channel->GuideNumber;
            $channel->channel_enabled = $existingChannels->get($key)->channel_enabled ?? true;
            return $channel;
        });

        return view('channels.map',
            [
                'channels' => $channels,
                'source' => $source,
                'sources' => $this->channelsBackend->getDevices(),
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

        $scannedChannels = $this->channelsBackend->getScannedChannels($source);
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

    public function xmltv(Request $request)
    {
        $source = $request->source;
        if(!$this->channelsBackend->isValidDevice($source)) {
            throw new Exception('Invalid source detected.');
        }

        if($request->duration === null) {
            $durationDays = intval($request->days) ?? 0;
            $durationHours = intval($request->hours) ?? 0;
            $durationMinutes = intval($request->minutes) ?? 0;
            $durationSeconds = intval($request->seconds) ?? config('channels.guideDuration');

            $duration = ($durationDays * 86400) + ($durationHours * 3600) +
                ($durationMinutes * 60) + $durationSeconds;
        }
        else {
            $duration = intval($request->duration);
        }

        $guideDuration = intval(
            min($duration, config('channels.guideDuration'))
        );

        $guideTime = Carbon::now();
        $endGuideTime = $guideTime->copy()->addSeconds($guideDuration);

        $existingChannels = DvrChannel::pluck('guide_number', 'mapped_channel_number');

        $guideChunkSize = min(
            $guideDuration, config('channels.backendChunkSize')
        );

        while($guideTime < $endGuideTime) {

            $guideData = $this->channelsBackend
                ->getGuideData($source, $guideTime->timestamp, $guideChunkSize);

            foreach($guideData as &$data) {
                $channelId =
                    $existingChannels->search($data->Channel->Number) ?? $data->Channel->Number;

                $data->Channel->channelId = $channelId;

                $data->Channel->displayNames = [
                    sprintf("%s %s", $data->Channel->channelId, $data->Channel->Name),
                    $data->Channel->channelId,
                    $data->Channel->Name,
                ];

                if(isset($data->Channel->Station)) {
                    $data->Channel->displayNames[] = sprintf(
                        "%s %s %s",
                        $data->Channel->channelId,
                        $data->Channel->Name,
                        $data->Channel->Station);

                }

                foreach($data->Airings as &$air) {

                    $air->startTime =
                        Carbon::createFromTimestamp($air->Time, 'America/Los_Angeles');
                    $air->endTime = $air->startTime->copy()->addSeconds($air->Duration);

                    $air->channelId = $channelId;

                }

            }

            echo view('channels.xmltv.full', ['guideData' => $guideData]);
            $guideTime->addSeconds($guideChunkSize);

        }

    }
}
