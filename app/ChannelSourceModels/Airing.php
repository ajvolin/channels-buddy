<?php

namespace App\ChannelSourceModels;

use App\ChannelSourceModels\Rating;
use App\ChannelSourceModels\Review;
use App\Exceptions\AiringPropertyDoesNotExist;
use Carbon\Carbon;

/**
 * Class Airing
 * @package App\ChannelSourceModels
 *
 */

class Airing
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public string $channelId;

    /**
     * @var Carbon
     */
    public Carbon $startTime;

    /**
     * @var Carbon
     */
    public Carbon $stopTime;

    /**
     * The airing length in seconds
     * 
     * @var int
     */
    public int $length;

    /**
     * @var string
     */
    public string $source;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public ?string $titleLanguage;

    /**
     * @var string
     */
    public ?string $subTitle;

    /**
     * @var string
     */
    public ?string $description;

    /**
     * @var string
     */
    public ?string $descriptionLanguage;

    /**
     * @var string
     */
    public ?string $image;

    /**
     * @var string
     */
    public ?string $programId;

    /**
     * @var string
     */
    public ?string $seriesId;

    /**
     * @var string
     */
    public ?string $seasonNumber;

    /**
     * @var string
     */
    public ?string $episodeNumber;

    /**
     * @var Carbon
     */
    public ?Carbon $originalReleaseDate;

    /**
     * @var Carbon
     */
    public ?Carbon $firstAiredDate;

    /**
     * @var string
     */
    public ?string $airingLanguage;

    /**
     * @var string
     */
    public ?string $airingOriginalLanguage;

    /**
     * @var string[]
     */
    public array $actors = [];

    /**
     * @var string[]
     */
    public array $adapters = [];

    /**
     * @var string[]
     */
    public array $commentators = [];

    /**
     * @var string[]
     */
    public array $composers = [];

    /**
     * @var string[]
     */
    public array $directors = [];

    /**
     * @var string[]
     */
    public array $editors = [];

    /**
     * @var string[]
     */
    public array $guests = [];

    /**
     * @var string[]
     */
    public array $presenters = [];

    /**
     * @var string[]
     */
    public array $producers = [];

    /**
     * @var string[]
     */
    public array $writers = [];

    /**
     * @var string[]
     */
    public array $categories = [];

    /**
     * @var Rating[]
     */
    public array $ratings = [];

    /**
     * @var Review[]
     */
    public array $reviews = [];

    /**
     * @var boolean
     */
    public ?bool $isMovie = null;

    /**
     * @var boolean
     */
    public ?bool $isLive = null;

    /**
     * @var boolean
     */
    public ?bool $isNew = null;

    /**
     * @var boolean
     */
    public ?bool $isPremiere = null;

    /**
     * @var boolean
     */
    public ?bool $isPreviouslyShown = null;

    /**
     * @var boolean
     */
    public ?bool $isHdtv = null;

    /**
     * @var boolean
     */
    public ?bool $isDolbyDigital = null;

    /**
     * @var boolean
     */
    public ?bool $isDolby = null;

    /**
     * @var boolean
     */
    public ?bool $isStereo = null;

    /**
     * @var boolean
     */
    public ?bool $hasClosedCaptioning = null;


    /**
     * Guide constructor.
     *
     * @param array $attributes Initialize the guide entry with the provided attributes.
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            } else {
                throw new AiringPropertyDoesNotExist("Airing property {$attribute} does not exist.");
            }
        }
    }

    /**
     * Get the airing ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the airing ID.
     *
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }
    
    /**
     * Get the channel ID.
     *
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * Set the channel ID.
     *
     * @param string $channelId
     */
    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }
    
    /**
     * Get the startTime
     *
     * @return string
     */
    public function getStartTime(): Carbon
    {
        return $this->startTime;
    }

    /**
     * Set the startTime
     *
     * @param Carbon $startTime
     */
    public function setStartTime(Carbon $startTime): void
    {
        $this->startTime = $startTime;
    }
    
    /**
     * Get the stopTime
     *
     * @return string
     */
    public function getStopTime(): Carbon
    {
        return $this->stopTime;
    }

    /**
     * Set the stopTime
     *
     * @param string $stopTime
     */
    public function setStopTime(Carbon $stopTime): void
    {
        $this->stopTime = $stopTime;
    }
    
    /**
     * Get the length
     *
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * Set the airing length in seconds
     *
     * @param string $length
     */
    public function setLength(int $length): void
    {
        $this->length = $length;
    }
    
    /**
     * Get the source
     *
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * Set the source
     *
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
    }
    
    /**
     * Get the title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the title
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get the title language
     *
     * @return string
     */
    public function getTitleLanguage(): ?string
    {
        return $this->titleLanguage;
    }

    /**
     * Set the title language
     *
     * @param string $titleLanguage
     */
    public function setTitleLanguage(?string $titleLanguage): void
    {
        $this->titleLanguage = $titleLanguage;
    }
    
    /**
     * Get the subTitle
     *
     * @return string
     */
    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    /**
     * Set the subTitle
     *
     * @param string $subTitle
     */
    public function setSubTitle(?string $subTitle): void
    {
        $this->subTitle = $subTitle;
    }
    
    /**
     * Get the description
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the description
     *
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get the description language
     *
     * @return string
     */
    public function getDescriptionLanguage(): ?string
    {
        return $this->descriptionLanguage;
    }

    /**
     * Set the description language
     *
     * @param string $descriptionLanguage
     */
    public function setDescriptionLanguage(?string $descriptionLanguage): void
    {
        $this->descriptionLanguage = $descriptionLanguage;
    }
    
    /**
     * Get the image
     *
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Set the image
     *
     * @param string $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }
    
    /**
     * Get the programId
     *
     * @return string
     */
    public function getProgramId(): ?string
    {
        return $this->programId;
    }

    /**
     * Set the programId
     *
     * @param string $programId
     */
    public function setProgramId(?string $programId): void
    {
        $this->programId = $programId;
    }
    
    /**
     * Get the seriesId
     *
     * @return string
     */
    public function getSeriesId(): ?string
    {
        return $this->seriesId;
    }

    /**
     * Set the seriesId
     *
     * @param string $seriesId
     */
    public function setSeriesId(?string $seriesId): void
    {
        $this->seriesId = $seriesId;
    }
    
    /**
     * Get the seasonNumber
     *
     * @return string
     */
    public function getSeasonNumber(): ?string
    {
        return $this->seasonNumber;
    }

    /**
     * Set the seasonNumber
     *
     * @param string $seasonNumber
     */
    public function setSeasonNumber(?string $seasonNumber): void
    {
        $this->seasonNumber = $seasonNumber;
    }
    
    /**
     * Get the episodeNumber
     *
     * @return string
     */
    public function getEpisodeNumber(): ?string
    {
        return $this->episodeNumber;
    }

    /**
     * Set the episodeNumber
     *
     * @param string $episodeNumber
     */
    public function setEpisodeNumber(?string $episodeNumber): void
    {
        $this->episodeNumber = $episodeNumber;
    }
    
    /**
     * Get the originalReleaseDate
     *
     * @return Carbon
     */
    public function getOriginalReleaseDate(): ?Carbon
    {
        return $this->originalReleaseDate;
    }

    /**
     * Set the originalReleaseDate
     *
     * @param string $originalReleaseDate
     */
    public function setOriginalReleaseDate(?Carbon $originalReleaseDate): void
    {
        $this->originalReleaseDate = $originalReleaseDate;
    }

    /**
     * Get the firstAiredDate
     *
     * @return Carbon
     */
    public function getFirstAiredDate(): ?Carbon
    {
        return $this->firstAiredDate;
    }

    /**
     * Set the firstAiredDate
     *
     * @param string $firstAiredDate
     */
    public function setFirstAiredDate(?Carbon $firstAiredDate): void
    {
        $this->firstAiredDate = $firstAiredDate;
    }

    /**
     * Get the airing language
     *
     * @return string
     */
    public function getAiringLanguage(): ?string
    {
        return $this->airingLanguage;
    }

    /**
     * Set the airing language
     *
     * @param string $airingLanguage
     */
    public function setAiringLanguage(?string $airingLanguage): void
    {
        $this->airingLanguage = $airingLanguage;
    }

    /**
     * Get the airing original language
     *
     * @return string
     */
    public function getAiringOriginalLanguage(): ?string
    {
        return $this->airingOriginalLanguage;
    }

    /**
     * Set the airing original language
     *
     * @param string $airingOriginalLanguage
     */
    public function setAiringOriginalLanguage(?string $airingOriginalLanguage): void
    {
        $this->airingOriginalLanguage = $airingOriginalLanguage;
    }

    /**
     * Add an actor
     *
     * @param string $actor
     */
    public function addActor(string $actor): void
    {
        array_push($this->actors, $actor);
    }
    
    /**
     * Get the actors
     *
     * @return array
     */
    public function getActors(): array
    {
        return $this->actors;
    }

    /**
     * Add an adapter
     *
     * @param string $adapter
     */
    public function addAdapter(string $adapter): void
    {
        array_push($this->adapters, $adapter);
    }
    
    /**
     * Get the adapters
     *
     * @return array
     */
    public function getAdapters(): array
    {
        return $this->adapters;
    }

    /**
     * Add a commentator
     *
     * @param string $commentator
     */
    public function addCommentator(string $commentator): void
    {
        array_push($this->commentators, $commentator);
    }
    
    /**
     * Get the commentators
     *
     * @return array
     */
    public function getCommentators(): array
    {
        return $this->commentators;
    }

    /**
     * Add a composer
     *
     * @param string $composer
     */
    public function addComposer(string $composer): void
    {
        array_push($this->composers, $composer);
    }
    
    /**
     * Get the composers
     *
     * @return array
     */
    public function getComposers(): array
    {
        return $this->composers;
    }

    /**
     * Add a director
     *
     * @param string $director
     */
    public function addDirector(string $director): void
    {
        array_push($this->directors, $director);
    }
    
    /**
     * Get the directors
     *
     * @return array
     */
    public function getDirectors(): array
    {
        return $this->directors;
    }
    
    /**
     * Add an editor
     *
     * @param string $editor
     */
    public function addEditor(string $editor): void
    {
        array_push($this->editors, $editor);
    }

    /**
     * Get the editors
     *
     * @return array
     */
    public function getEditors(): array
    {
        return $this->editors;
    }

    /**
     * Add a guest
     *
     * @param string $guest
     */
    public function addGuest(string $guest): void
    {
        array_push($this->guests, $guest);
    }
    
    /**
     * Get the guests
     *
     * @return array
     */
    public function getGuests(): array
    {
        return $this->guests;
    }

    /**
     * Add a presenter
     *
     * @param string $presenter
     */
    public function addPresenter(string $presenter): void
    {
        array_push($this->presenters, $presenter);
    }
    
    /**
     * Get the presenters
     *
     * @return array
     */
    public function getPresenters(): array
    {
        return $this->presenters;
    }
    
    /**
     * Add a producer
     *
     * @param string $producer
     */
    public function addProducer(string $producer): void
    {
        array_push($this->producers, $producer);
    }

    /**
     * Get the producers
     *
     * @return array
     */
    public function getProducers(): array
    {
        return $this->producers;
    }

    /**
     * Add a writer
     *
     * @param string $writer
     */
    public function setWriters(string $writer): void
    {
        array_push($this->writers, $writer);
    }
    
    /**
     * Get the writers
     *
     * @return array
     */
    public function getWriters(): array
    {
        return $this->writers;
    }
    
    /**
     * Add a category
     *
     * @param string $category
     */
    public function addCategory(string $category): void
    {
        array_push($this->categories, $category);
    }

    /**
     * Get the categories
     *
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }
    
    /**
     * Add a rating to the ratings array
     *
     * @param Rating
     */
    public function addRating(Rating $rating): void
    {
        array_push($this->ratings, $rating);
    }

    /**
     * Get the ratings
     *
     * @return Rating[]
     */
    public function getRatings(): array
    {
        return $this->ratings;
    }

    /**
     * Add a review to the review array
     *
     * @param Review
     */
    public function addReview(Review $review): void
    {
        array_push($this->reviews, $review);
    }

    /**
     * Get the reviews
     *
     * @return Review[]
     */
    public function getReviews(): array
    {
        return $this->reviews;
    }

    /**
     * Get isMovie
     *
     * @return bool
     */
    public function getIsMovie(): ?bool
    {
        return $this->isMovie;
    }

    /**
     * Set isMovie
     *
     * @param bool $isMovie
     */
    public function setIsMovie(?bool $isMovie): void
    {
        $this->isMovie = $isMovie;
    }
    
    /**
     * Get isLive
     *
     * @return bool
     */
    public function getIsLive(): ?bool
    {
        return $this->isLive;
    }

    /**
     * Set isLive
     *
     * @param bool $isLive
     */
    public function setIsLive(?bool $isLive): void
    {
        $this->isLive = $isLive;
    }

    /**
     * Get isNew
     *
     * @return bool
     */
    public function getIsNew(): ?bool
    {
        return $this->isNew;
    }

    /**
     * Set isNew
     *
     * @param bool $isNew
     */
    public function setIsNew(?bool $isNew): void
    {
        $this->isNew = $isNew;
    }

    /**
     * Get isPremiere
     *
     * @return bool
     */
    public function getIsPremiere(): ?bool
    {
        return $this->isPremiere;
    }

    /**
     * Set isPremiere
     *
     * @param bool $isPremiere
     */
    public function setIsPremiere(?bool $isPremiere): void
    {
        $this->isPremiere = $isPremiere;
    }

    /**
     * Get isPreviouslyShown
     *
     * @return bool
     */
    public function getIsPreviouslyShown(): ?bool
    {
        return $this->isPreviouslyShown;
    }

    /**
     * Set isPreviouslyShown
     *
     * @param bool $isPreviouslyShown
     */
    public function setIsPreviouslyShown(?bool $isPreviouslyShown): void
    {
        $this->isPreviouslyShown = $isPreviouslyShown;
    }

    /**
     * Get isHdtv
     *
     * @return bool
     */
    public function getIsHdtv(): ?bool
    {
        return $this->isHdtv;
    }

    /**
     * Set isHdtv
     *
     * @param bool $isHdtv
     */
    public function setIsHdtv(?bool $isHdtv): void
    {
        $this->isHdtv = $isHdtv;
    }

    /**
     * Get isDolbyDigital
     *
     * @return bool
     */
    public function getIsDolbyDigital(): ?bool
    {
        return $this->isDolbyDigital;
    }

    /**
     * Set isDolbyDigital
     *
     * @param bool $isDolbyDigital
     */
    public function setIsDolbyDigital(?bool $isDolbyDigital): void
    {
        $this->isDolbyDigital = $isDolbyDigital;
    }

    /**
     * Get isDolby
     *
     * @return bool
     */
    public function getIsDolby(): ?bool
    {
        return $this->isDolby;
    }

    /**
     * Set isDolby
     *
     * @param bool $isDolby
     */
    public function setIsDolby(?bool $isDolby): void
    {
        $this->isDolby = $isDolby;
    }

    /**
     * Get isStereo
     *
     * @return bool
     */
    public function getIsStereo(): ?bool
    {
        return $this->isStereo;
    }

    /**
     * Set isStereo
     *
     * @param bool $isStereo
     */
    public function setIsStereo(?bool $isStereo): void
    {
        $this->isStereo = $isStereo;
    }

    /**
     * Get hasClosedCaptioning
     *
     * @return bool
     */
    public function getHasClosedCaptioning(): ?bool
    {
        return $this->hasClosedCaptioning;
    }

    /**
     * Set hasClosedCaptioning
     *
     * @param bool $hasClosedCaptioning
     */
    public function setHasClosedCaptioning(?bool $hasClosedCaptioning): void
    {
        $this->hasClosedCaptioning = $hasClosedCaptioning;
    }
}