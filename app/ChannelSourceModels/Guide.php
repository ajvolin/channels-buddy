<?php

namespace App\ChannelSourceModels;

use Illuminate\Support\LazyCollection;

/**
 * Class Guide
 * @package App\ChannelSourceModels
 *
 */

class Guide
{
    /**
     * Yields a LazyCollection of GuideEntry objects
     * 
     * @var LazyCollection
     */
    public LazyCollection $guideEntries;

    /**
     * Guide constructor.
     *
     * @param array $attributes Initialize the guide with the
     *                          guide entries LazyCollection.
     */
    public function __construct(LazyCollection $guideEntries)
    {
        $this->guideEntries = $guideEntries;
    }

    /**
     * Returns the guideEntries LazyCollection
     * 
     * @return LazyCollection
     */
    public function getGuideEntries(): LazyCollection
    {
        return $this->guideEntries;
    }
}
