<?php

namespace App\APIModels;

use App\Exceptions\ChannelPropertyDoesNotExist;

/**
 * Class Channel
 * @package App\APIModels
 *
 */

class Channel
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public ?string $number;

    /**
     * @var string
     */
    public ?string $callSign;

    /**
     * @var string
     */
    public ?string $description;

    /**
     * @var string
     */
    public ?string $logo;

    /**
     * @var string
     */
    public ?string $channelArt;

    /**
     * @var string
     */
    public ?string $category;

    /**
     * @var string
     */
    public string $streamUrl;

    /**
     * Channel constructor.
     *
     * @param array $attributes Initialize the channel with the provided attributes.
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            } else {
                throw new ChannelPropertyDoesNotExist("Channel property {$attribute} does not exist.");
            }
        }
    }

    /**
     * Get the channel ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the channel ID.
     *
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Get the channel name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the channel name.
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    /**
     * Get the channel number.
     *
     * @return string
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * Set the channel number.
     *
     * @param string $number
     */
    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }

    /**
     * Get the channel call sign.
     *
     * @return string
     */
    public function getCallSign(): ?string
    {
        return $this->callSign;
    }

    /**
     * Set the channel call sign.
     *
     * @param string $callSign
     */
    public function CallSign(?string $callSign): void
    {
        $this->callSign = $callSign;
    }

    /**
     * Get the channel description.
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the channel description.
     *
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get the channel logo.
     *
     * @return string
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * Set the channel logo.
     *
     * @param string $logo
     */
    public function setLogo(?string $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * Get the channel art.
     *
     * @return string
     */
    public function getChannelArt(): ?string
    {
        return $this->channelArt;
    }

    /**
     * Set the channel art.
     *
     * @param string $channelArt
     */
    public function setChannelArt(?string $channelArt): void
    {
        $this->channelArt = $channelArt;
    }

    /**
     * Get the channel category.
     *
     * @return string
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * Set the channel category.
     *
     * @param string $category
     */
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }


    /**
     * Get the channel stream URL.
     *
     * @return string
     */
    public function getStreamUrl(): string
    {
        return $this->streamUrl;
    }

    /**
     * Set the channel stream URL.
     *
     * @param string $streamUrl
     */
    public function setStreamUrl(string $streamUrl): void
    {
        $this->streamUrl = $streamUrl;
    }
}
