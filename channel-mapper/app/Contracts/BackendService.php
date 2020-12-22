<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface BackendService
{
    /**
     * Return the channel list.
     *
     * @return Collection
     */
    public function getChannels(): Collection;

    /**
     * Return guide data.
     *
     * @return Collection
     */
    public function getGuideData($startTimestamp = null, $duration = null): Collection;
}