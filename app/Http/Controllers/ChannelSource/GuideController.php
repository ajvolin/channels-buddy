<?php

namespace App\Http\Controllers\ChannelSource;

use ChannelsBuddy\SourceProvider\Contracts\ChannelSource;
use App\Http\Controllers\BaseGuideController;
use App\Models\SourceChannel;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use ChannelsBuddy\SourceProvider\ChannelSourceProvider;
use ChannelsBuddy\SourceProvider\ChannelSourceProviders;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GuideController extends BaseGuideController
{
    protected ChannelSourceProvider $channelSourceProvider;
    protected ChannelSource $channelService;
    protected string $sourceName;

    public function __construct(Request $request)
    {
        $this->sourceName = $request->channelSource;
        $this->existingChannels =
            SourceChannel::where('source', $this->sourceName)
                ->where('channel_enabled', 1)
                ->pluck('channel_number', 'channel_id');
        $this->channelIdField = 'id';
    }

    public function xmltv(Request $request): StreamedResponse
    {
        $this->channelSourceProvider = $request->channelSource;
        $this->channelService = $this->channelSourceProvider->getChannelSourceService();

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

        return $this->streamResponse(function($handle) use ($duration) {
            if (!$this->channelSourceProvider->guideIsChunkable()
                || (is_null($this->channelSourceProvider->getMaxGuideDuration())
                && is_null($this->channelSourceProvider->getMaxGuideChunkSize()))
                ) {
                $guideData = $this->channelService
                        ->getGuideData(null, null);
    
                $this->parseGuide($guideData, $handle);
            } else {
                $guideDuration = intval(
                    min(
                        $duration,
                        $this->channelSourceProvider->getMaxGuideDuration()
                    )
                );
                $guideChunkSize = min(
                    $guideDuration,
                    $this->channelSourceProvider->getMaxGuideChunkSize()
                );

                $now = Carbon::now();
                $guideIntervals = CarbonInterval::seconds($guideChunkSize)
                    ->toPeriod(
                        $now,
                        $now->copy()->addSeconds($guideDuration - 1)
                    );

                foreach ($guideIntervals as $guideInterval) {
                    $guideData = $this->channelService
                        ->getGuideData($guideInterval->timestamp, $guideChunkSize);

                    $this->parseGuide($guideData, $handle);
                }
            }
        });
    }
}
