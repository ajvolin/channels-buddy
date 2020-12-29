<?php

namespace App\ChannelSourceModels;

use App\Exceptions\ChannelPropertyDoesNotExist;

/**
 * Class Channel
 * @package App\ChannelSourceModels
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
    public ?string $guideName;

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
    public ?string $stationId;

    /**
     * @var string
     */
    public ?string $title;

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
    public ?string $videoCodec;

    /**
     * @var string
     */
    public ?string $audioCodec;

    /**
     * @var string
     */
    public string $streamUrl;

    /**
     * @var string
     */
    public ?string $sortValue;

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
     * Get the channel guide name.
     *
     * @return string
     */
    public function getGuideName(): ?string
    {
        return $this->guideName;
    }

    /**
     * Set the channel guide name.
     *
     * @param string $guideName
     */
    public function setGuideName(?string $guideName): void
    {
        $this->guideName = $guideName;
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
    public function setCallSign(?string $callSign): void
    {
        $this->callSign = $callSign;
    }

    /**
     * Get the channel station ID.
     *
     * @return string
     */
    public function getStationId(): ?string
    {
        return $this->stationId;
    }

    /**
     * Set the channel station ID.
     *
     * @param string $stationId
     */
    public function setStationId(?string $stationId): void
    {
        $this->stationId = $stationId;
    }

    /**
     * Get the channel title.
     *
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the channel title.
     *
     * @param string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
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
     * Get the channel video codec.
     *
     * @return string
     */
    public function getVideoCodec(): ?string
    {
        return $this->videoCodec;
    }

    /**
     * Set the channel video codec.
     *
     * @param string $videoCodec
     */
    public function setVideoCodec(?string $videoCodec): void
    {
        $this->videoCodec = $videoCodec;
    }

    /**
     * Get the channel audio codec.
     *
     * @return string
     */
    public function getAudioCodec(): ?string
    {
        return $this->audioCodec;
    }

    /**
     * Set the channel audio codec.
     *
     * @param string $audioCodec
     */
    public function setAudioCodec(?string $audioCodec): void
    {
        $this->audioCodec = $audioCodec;
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

    /**
     * Get the channel sort value.
     *
     * @return string
     */
    public function getSortValue(): ?string
    {
        return $this->sortValue;
    }

    /**
     * Set the channel sort value.
     *
     * @param string $sortValue
     */
    public function setSortValue(?string $sortValue): void
    {
        $this->sortValue = $sortValue;
    }
}
