<?php

namespace App\APIModels;

use App\APIModels\GuideEntry;
use App\Exceptions\GuideInvalidObject;
use Illuminate\Support\Collection;

/**
 * Class Guide
 * @package App\APIModels
 *
 */

class Guide
{
    /**
     * @var GuideEntry[]
     */
    public array $guideEntries = [];

    /**
     * Guide constructor.
     *
     * @param array $attributes Initialize the guide with the provided entries.
     */
    public function __construct(array $guideEntries = [])
    {
        foreach ($guideEntries as $entry) {
            if ($entry instanceof GuideEntry) {
                $this->addGuideEntry($entry);
            } else {
                throw new GuideInvalidObject("Object must be instance of GuideEntry: {$entry}");
            }
        }
    }

    /**
     * Adds a guide entry to the $guideEntries array 
     * 
     * @param GuideEntry $entry
     */
    public function addGuideEntry(GuideEntry $entry): void
    {
        array_push($this->guideEntries, $entry);
    }

    /**
     * Returns the guide entries as an array
     * 
     * @return GuideEntry[]
     */
    public function getGuideEntries(): array
    {
        return $this->guideEntries;
    }

    /**
     * Returns the guide entries as a collection
     * 
     * @return Collection
     */
    public function getGuideEntriesCollection(): Collection
    {
        return collect($this->guideEntries);
    }
}
