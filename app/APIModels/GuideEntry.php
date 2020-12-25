<?php

namespace App\APIModels;

use App\APIModels\Airing;
use App\APIModels\Channel;

/**
 * Class GuideEntry
 * @package App\APIModels
 *
 */

class GuideEntry
{
    /**
     * @var Channel
     */
    public Channel $channel;

    /**
     * @var Airing[]
     */
    public array $airings = [];

    /**
     * GuideEntry constructor.
     *
     */
    public function __construct(Channel $channel = null)
    {
        if (!is_null($channel)) {
            $this->channel = $channel;
        }
    }

    /**
     * Get the guide channel.
     *
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * Set the guide channel.
     *
     * @param Channel $channel
     */
    public function setChannel(Channel $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * @param Airing $airing
     */
    public function addAiring(Airing $airing): void
    {
        array_push($this->airings, $airing);
    }

    /**
     * Returns the airings as an array
     * 
     * @return Airing[]
     */
    public function getAirings(): array
    {
        return $this->airings;
    }
}
