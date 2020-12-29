<?php

namespace App\ChannelSourceModels;

/**
 * Class Review
 * @package App\ChannelSourceModels
 *
 */

class Review
{
    /**
     * @var string
     */
    public string $review;

    /**
     * @var string
     */
    public ?string $system;

    /**
     * Review constructor.
     *
     * @param string $review Initialize with the provided review.
     * @param string $system Initialize with the provided system.
     */
    public function __construct(string $review, ?string $system = null)
    {
       $this->review = $review;
       $this->system = $system;
    }

    /**
     * Returns the $review string
     * 
     * @return string
     */
    public function getReview(): string
    {
        return $this->review;
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