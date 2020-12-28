<?php

namespace App\APIModels;

use App\APIModels\Channel;
use App\Exceptions\ChannelsInvalidObject;
use Illuminate\Support\LazyCollection;

/**
 * Class Channels
 * @package App\APIModels
 *
 */

class Channels
{
    /**
     * Yields a LazyCollection of Channel objects
     * 
     * @var LazyCollection
     */
    public LazyCollection $channels;

    /**
     * Channels constructor.
     *
     * @param array $attributes Initialize the channel with the provided attributes.
     */
    public function __construct(LazyCollection $channels)
    {
        $this->channels = $channels;
    }

    // /**
    //  * Adds a channel to the $channels array
    //  * 
    //  * @param Channel $channel
    //  */
    // public function addChannel(Channel $channel): void
    // {
    //     array_push($this->channels, $channel);
    // }

    /**
     * Returns the channels LazyCollection
     * 
     * @return LazyCollection
     */
    public function getChannels(): LazyCollection
    {
        return $this->channels;
    }
}
