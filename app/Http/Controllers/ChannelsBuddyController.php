<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ChannelsService;
use ChannelsBuddy\SourceProvider\ChannelSourceProviders;
use Inertia\Inertia;

class ChannelsBuddyController extends Controller
{
    public function index(ChannelsService $channelSource, ChannelSourceProviders $sourceProviders)
    {
        $channelsSources = 
            $channelSource->getDevices()->values() ?? [];
        $externalSources =
            collect($sourceProviders->toArray()['providers'])->values() ?? [];

        return Inertia::render('Home', [
            'title' => 'Home',
            'sources' => [
                'channels_dvr' => $channelsSources,
                'external' => $externalSources
            ]
        ]);
    }
}