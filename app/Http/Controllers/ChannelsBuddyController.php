<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ChannelsService;
use Illuminate\Http\Request;

class ChannelsBuddyController extends Controller
{
    protected $channelSource;

    public function __construct(ChannelsService $channelSource)
    {
        $this->channelSource = $channelSource;
    }

    public function index()
    {
        $channelsSources = $this->channelSource->getDevices()
            ?? null;

        return view('channels-buddy', [
            'channelsSources' => $channelsSources
        ]);
    }
}