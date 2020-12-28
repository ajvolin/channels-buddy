<?php

namespace App\APIModels;

use App\APIModels\GuideEntry;
use App\Exceptions\GuideInvalidObject;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

/**
 * Class Guide
 * @package App\APIModels
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

    // /**
    //  * Adds a guide entry to the $guideEntries array 
    //  * 
    //  * @param GuideEntry $entry
    //  */
    // public function addGuideEntry(GuideEntry $entry): void
    // {
    //     array_push($this->guideEntries, $entry);
    // }

    // /**
    //  * Returns the guide entries as an array
    //  * 
    //  * @return GuideEntry[]
    //  */
    // public function getGuideEntries(): array
    // {
    //     return $this->guideEntries;
    // }

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
