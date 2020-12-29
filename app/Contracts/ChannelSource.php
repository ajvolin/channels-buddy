<?php

namespace App\Contracts;

use App\ChannelSourceModels\Channels;
use App\ChannelSourceModels\Guide;

interface ChannelSource
{
    /**
     * Return the channel list.
     *
     * @param ?string $source The source to get channels from
     * @return Channels
     */
    public function getChannels(?string $source = null): Channels;

    /**
     * Return the guide channel list.
     *
     * @return Channels
     */
    public function getGuideChannels(): Channels;

    /**
     * Return guide data.
     *
     * @param int $startTimestamp The unix timestamp from where to start timeline
     * @param int $duration The length of the timeline in seconds
     * @param ?string $source The source to get guide data from
     * @return Guide
     */
    public function getGuideData(?int $startTimestamp, ?int $duration, ?string $source = null): Guide;
}