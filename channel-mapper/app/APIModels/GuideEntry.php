<?php

namespace App\APIModels;

use App\Exceptions\GuideEntryPropertyDoesNotExist;

/**
 * Class GuideEntry
 * @package App\APIModels
 *
 */

class GuideEntry
{
    /**
     * @var string
     */
    public $id;

    /**
     * Guide constructor.
     *
     * @param array $attributes Initialize the guide entry with the provided attributes.
     */
    public function __construct(array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            } else {
                throw new GuideEntryPropertyDoesNotExist("GuideEntry property {$attribute} does not exist.");
            }
        }
    }

    /**
     * Get the guide entry ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the guide entry ID.
     *
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }    
}
