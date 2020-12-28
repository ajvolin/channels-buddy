<?php

namespace App\Http\Controllers\ChannelSource;

use App\Contracts\BackendService;
use App\Http\Controllers\BaseGuideController;
use App\Models\ExternalChannel;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GuideController extends BaseGuideController
{
    protected BackendService $backend;

    public function __construct(BackendService $backend, $channelSource)
    {
        parent::__construct();
        $this->backend = $backend;
        $this->source = $channelSource;
        $this->existingChannels =
            ExternalChannel::where('source', $channelSource)
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
                $guideData = $this->backend
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
                    $guideData = $this->backend
                        ->getGuideData($guideInterval->timestamp, $guideChunkSize);

                    $this->parseGuide($guideData, $handle);
                }
            }
        });
    }
}
