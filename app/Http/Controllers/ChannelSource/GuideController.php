<?php

namespace App\Http\Controllers\ChannelSource;

use App\Contracts\ChannelSource;
use App\Http\Controllers\BaseGuideController;
use App\Models\SourceChannel;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GuideController extends BaseGuideController
{
    protected ChannelSource $channelSource;
    protected string $source;

    public function __construct(ChannelSource $channelSource, Request $request)
    {
        $this->channelSource = $channelSource;
        $this->source = $request->channelSource;
        $this->existingChannels =
            SourceChannel::where('source', $this->source)
                ->where('channel_enabled', 1)
                ->pluck('channel_number', 'channel_id');
        $this->channelIdField = 'id';
    }

    public function xmltv(Request $request): StreamedResponse
    {
        $guideDuration = config("channels.channelSources.{$this->source}.guideDuration");
        $guideChunkSize = config("channels.channelSources.{$this->source}.guideChunkSize");

        return $this->streamResponse(function($handle)
            use ($guideChunkSize, $guideDuration) {
            if (is_null($guideChunkSize) && is_null($guideDuration)) {
                $guideData = $this->channelSource
                        ->getGuideData(null, null);
    
                $this->parseGuide($guideData, $handle);
            } else {
                $now = Carbon::now();
                $guideIntervals = CarbonInterval::seconds($guideChunkSize)
                    ->toPeriod(
                        $now,
                        $now->copy()->addSeconds($guideDuration - 1)
                    );

                foreach ($guideIntervals as $guideInterval) {
                    $guideData = $this->channelSource
                        ->getGuideData($guideInterval->timestamp, $guideChunkSize);

                    $this->parseGuide($guideData, $handle);
                }
            }
        });
    }
}
