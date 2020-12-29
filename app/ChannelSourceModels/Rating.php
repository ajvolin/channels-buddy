<?php

namespace App\ChannelSourceModels;

/**
 * Class Rating
 * @package App\ChannelSourceModels
 *
 */

class Rating
{
    /**
     * @var string
     */
    public string $rating;

    /**
     * @var string
     */
    public ?string $system;

    /**
     * Rating constructor.
     *
     * @param string $rating Initialize with the provided rating.
     * @param string $system Initialize with the provided system.
     */
    public function __construct(string $rating, ?string $system = null)
    {
       $this->rating = $rating;
       $this->system = $system;
    }

    /**
     * Returns the $rating string
     * 
     * @return string
     */
    public function getRating(): string
    {
        return $this->rating;
    }

    /**
     * Returns the $system string
     * 
     * @return string
     */
    public function getSystem(): string
    {
        return $this->system;
    }    
}