<?php

namespace App\Contracts;

use App\ChannelSourceModels\Channels;
use App\ChannelSourceModels\Guide;

interface ChannelSource
{
    /**
     * Return the channel list.
     *
     * @param ?string $device The source device to get channels from
     * @return Channels
     */
    public function getChannels(?string $device = null): Channels;

    /**
     * Return guide data.
     *
     * @param int $startTimestamp The unix timestamp from where to start timeline
     * @param int $duration The length of the timeline in seconds
     * @param ?string $device The source device to get guide data from
     * @return Guide
     */
    public function getGuideData(?int $startTimestamp, ?int $duration, ?string $device = null): Guide;
}