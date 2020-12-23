<?php

namespace App\Contracts;

use App\APIModels\Channels;
use App\APIModels\Guide;

interface BackendService
{
    /**
     * Return the channel list.
     *
     * @return Channels
     */
    public function getChannels(): Channels;

    /**
     * Return guide data.
     *
     * @param string $startTimestamp The unix timestamp from where to start timeline
     * @param int    $duration The length of the timeline in seconds
     * @return Guide
     */
    public function getGuideData($startTimestamp = null, $duration = null): Guide;
}