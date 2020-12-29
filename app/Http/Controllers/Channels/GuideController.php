<?php

namespace App\Http\Controllers\Channels;

use App\Http\Controllers\BaseGuideController;
use App\Models\SourceChannel;
use App\Services\ChannelsService;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use ChannelsBuddy\SourceProvider\Exceptions\InvalidSourceException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GuideController extends BaseGuideController
{
    protected ChannelsService $channelSource;

    public function __construct(ChannelsService $channelSource, Request $request)
    {
        $this->channelSource = $channelSource;
        $this->existingChannels =
            SourceChannel::where('source', 'channels')
                ->where('channel_enabled', 1)
                ->pluck('channel_number', 'channel_id');
        $this->channelIdField = 'number';
    }

    public function xmltv(Request $request): StreamedResponse
    {
        $source = $request->source;
        if (!$this->channelSource->isValidDevice($source)) {
            throw new InvalidSourceException('Invalid source detected.');
        }

        if (!isset($request->duration)) {
            $durationDays = intval($request->days) ?? 0;
            $durationHours = intval($request->hours) ?? 0;
            $durationMinutes = intval($request->minutes) ?? 0;
            $durationSeconds = intval($request->seconds) ?? 0;

            $duration = (($durationDays * 86400) + ($durationHours * 3600) +
                ($durationMinutes * 60) + $durationSeconds) ?: config('channels.guideDuration');
        } else {
            $duration = intval($request->duration);
        }

        $guideDuration = intval(
            min($duration, config('channels.guideDuration'))
        );

        $guideChunkSize = min(
            $guideDuration,
            config('channels.backendChunkSize')
        );

        return $this->streamResponse(function($handle)
            use ($source, $guideChunkSize, $guideDuration) {
            $now = Carbon::now();
            $guideIntervals = CarbonInterval::seconds($guideChunkSize)
            ->toPeriod(
                $now,
                $now->copy()->addSeconds($guideDuration - 1)
            );

            foreach ($guideIntervals as $guideInterval) {
                $guideData = $this->channelSource
                ->getGuideData(
                    $guideInterval->timestamp,
                    $guideChunkSize,
                    $source
                );
                
                $this->parseGuide($guideData, $handle);
            }
        });
    }
}
