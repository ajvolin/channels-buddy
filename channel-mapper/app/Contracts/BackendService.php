<?php

namespace App\Contracts;

use App\APIModels\Channels;
use App\APIModels\Guide;
use Illuminate\Support\Collection;

interface BackendService
{
    /**
     * Return the channel list.
     *
     * @return Collection
     */
    public function getChannels(): Channels;

    /**
     * Return guide data.
     *
     * @return Collection
     */
    public function getGuideData($startTimestamp = null, $duration = null): Guide;
}