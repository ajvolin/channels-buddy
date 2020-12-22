<?php

namespace App\APIModels;

use App\APIModels\Channel;
use App\Exceptions\ChannelsInvalidObject;
use Illuminate\Support\Collection;

/**
 * Class Channels
 * @package App\APIModels
 *
 */

class Channels
{
    /**
     * @var Channel[]
     */
    public array $channels = [];

    /**
     * Channels constructor.
     *
     * @param array $attributes Initialize the channel with the provided attributes.
     */
    public function __construct(array $channels = [])
    {
        foreach ($channels as $channel) {
            if ($channel instanceof Channel) {
                $this->addChannel($channel);
            } else {
                throw new ChannelsInvalidObject("Object must be instance of Channel: {$channel}");
            }
        }
    }

    /**
     * Adds a channel to the $channels array
     * 
     * @param Channel $channel
     */
    public function addChannel(Channel $channel): void
    {
        array_push($this->channels, $channel);
    }

    /**
     * Returns the channels as an array
     * 
     * @return Channel[]
     */
    public function getChannels(): array
    {
        return $this->channels;
    }

    /**
     * Returns the channels as a collection
     * 
     * @return Collection
     */
    public function getChannelsCollection(): Collection
    {
        return collect($this->channels);
    }
}
