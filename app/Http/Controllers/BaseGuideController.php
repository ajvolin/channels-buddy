<?php

namespace App\Http\Controllers;

use App\APIModels\Guide;
use App\Http\Controllers\Controller;
use DOMDocument;
use DOMElement;
use DOMNode;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;
use XmlTv\Tv;
use XmlTv\Tv\Elements\Language;
use XmlTv\Tv\Elements\OrigLanguage;
use XmlTv\XmlElement;
use XmlTv\XmlSerializable;

abstract class BaseGuideController extends Controller
{
    protected Collection $existingChannels;
    protected string $channelIdField;
    protected array $processedChannels = [];
    protected array $processedAirings = [];


    abstract public function xmltv(Request $request): StreamedResponse;

    /**
     * Returns the streaming XMLTV response.
     *
     * @param callable $callable The callback function
     */
    final protected function streamResponse(callable $callable): StreamedResponse
    {
        return response()->stream(function() use ($callable) {
            $handle = fopen('php://output', 'w');

            $xmlOpen = '<?xml version="1.0" encoding="UTF-8"?>'."\n" .
                        '<!DOCTYPE tv SYSTEM "xmltv.dtd">'."\n" .
                        '<tv source-info-name="channels-buddy">';
            fputs($handle, $xmlOpen);

            $callable($handle);

            fputs($handle, "</tv>");
            fclose($handle);
        }, 200,
        [
            'Content-Type' => 'text/xml'
        ]);
    }

    /**
     * Parses the Guide.
     *
     * @param Guide $guide  The Guide object to parse
     * @param resource  $handle The handle to stream to
     */
    final protected function parseGuide(Guide $guide, $handle): void
    {
        foreach ($guide->guideEntries as $entry) {
            if($this->existingChannels
                ->has($entry->channel->{$this->channelIdField})) {
                if (!in_array($entry->channel->id, $this->processedChannels)) {
                    $this->processedChannels[] = $entry->channel->id;
                    $channel = new Tv\Channel($entry->channel->id);
                    
                    $channelNumber = $this->existingChannels
                    ->get($entry->channel->{$this->channelIdField}) ?: 
                        $entry->channel->number;

                    if (isset($entry->channel->title)) {
                        $channel->addDisplayName(
                            new Tv\Elements\DisplayName($entry->channel->title)
                        );
                    }

                    if (isset($entry->channel->name) &&
                        $entry->channel->name !=
                            ($entry->channel->title ?? "")) {
                        $channel->addDisplayName(
                            new Tv\Elements\DisplayName($entry->channel->name)
                        );
                    }

                    if (isset($entry->channel->callSign) &&
                        $entry->channel->callSign !=
                            ($entry->channel->title ?? "") &&
                        $entry->channel->callSign != 
                            ($entry->channel->name ?? "")) {
                        $channel->addDisplayName(
                            new Tv\Elements\DisplayName($entry->channel->callSign)
                        );
                    }

                    if (!is_null($channelNumber)) {
                        $channel->addDisplayName(
                            new Tv\Elements\DisplayName($channelNumber)
                        );
                    }

                    if (isset($entry->channel->logo)) {
                        $channel->addIcon(
                            new Tv\Elements\Icon($entry->channel->logo)
                        );
                    }

                    fputs($handle, $this->renderXmlTvElement($channel));
                }

                foreach ($entry->airings as $airing) {
                    if (!in_array($airing->id, $this->processedAirings)) {
                        $this->processedAirings[] = $airing->id;

                        $startTime = $airing->startTime->format('YmdHis O');
                        $stopTime = $airing->stopTime->format('YmdHis O');

                        $program = new Tv\Programme(
                            $entry->channel->id,
                            $startTime,
                            $stopTime
                        );

                        $program->length = new Tv\Elements\Length(
                            $airing->length,
                            Tv\Elements\Length\Unit::SECONDS
                        );

                        $program->addTitle(new Tv\Elements\Title($airing->title));

                        if (isset($airing->subTitle)) {
                            $program->addSubTitle(
                                new Tv\Elements\SubTitle($airing->subTitle,
                                    $airing->titleLanguage ?? ''
                                )
                            );
                        }

                        $program->addDescription(
                            new Tv\Elements\Desc(
                                $airing->description,
                                $airing->descriptionLanguage ?? ''
                            )
                        );

                        if (isset($airing->image)) {
                            $program->addIcon(
                                new Tv\Elements\Icon($airing->image)
                            );
                        }

                        if (isset($airing->seriesId)) {
                            $program->addSeriesId(
                                new Tv\Elements\SeriesId(
                                    $airing->seriesId,
                                    $airing->source ?? 'unknown'
                                )
                            );
                        }

                        if (isset($airing->programId)) {
                            $program->addEpisodeNum(
                                new Tv\Elements\EpisodeNum(
                                    $airing->programId,
                                    $airing->source ?? 'unknown'
                                )
                            );
                        }

                        if (!$airing->isMovie && isset($airing->episodeNumber)) {
                            if (is_numeric($airing->episodeNumber)
                                && $airing->episodeNumber > 0) {
                                $eN = $airing->episodeNumber;

                                if (isset($airing->seasonNumber)
                                    && is_numeric($airing->seasonNumber)
                                    && $airing->seasonNumber > 0) {
                                    $sN = $airing->seasonNumber;
                                } else {
                                    $sN = -1;
                                }

                                $program->addEpisodeNum(
                                    new Tv\Elements\EpisodeNum(
                                        sprintf("%sE%02d",
                                            ($sN >= 0)
                                                ? "S{$sN}" : "",
                                                $eN),
                                        'onscreen'
                                    )
                                );

                                $program->addEpisodeNum(
                                    new Tv\Elements\EpisodeNum(
                                        ($sN > 0 ? $sN - 1 : "") . "."
                                        . ($eN - 1) . ".",
                                        'xmltv_ns'
                                    )
                                );
                            }
                        }

                        if (isset($airing->originalReleaseDate)) {
                            $program->addEpisodeNum(
                                new Tv\Elements\EpisodeNum(
                                    $airing->originalReleaseDate
                                        ->copy()->format('Y-m-d'),
                                    'original-date'
                                )
                            );

                            if ($airing->isMovie) {
                                $program->date = new Tv\Elements\Date(
                                    $airing->originalReleaseDate
                                        ->copy()
                                        ->format('Y')
                                );
                            } else {
                                $program->date = new Tv\Elements\Date(
                                    $airing->originalReleaseDate
                                        ->copy()
                                        ->format('Ymd')
                                );
                            }
                        }  

                        if (!empty($airing->actors) ||
                            !empty($airing->adapters) ||
                            !empty($airing->commentators) ||
                            !empty($airing->composers) ||
                            !empty($airing->directors) ||
                            !empty($airing->editors) ||
                            !empty($airing->guests) ||
                            !empty($airing->presenters) ||
                            !empty($airing->producers) ||
                            !empty($airing->writers)) {
                            
                            $credits = new Tv\Elements\Credits();

                            foreach ($airing->actors as $actor) {
                                $credits->actor[] =
                                    new Tv\Elements\Credits\Actor($actor);
                            }
                            
                            foreach ($airing->adapters as $adapter) {
                                $credits->adapter[] =
                                    new Tv\Elements\Credits\Adapter($adapter);
                            }
                            
                            foreach ($airing->commentators as $commentator) {
                                $credits->commentator[] =
                                    new Tv\Elements\Credits\Commentator($commentator);
                            }

                            foreach ($airing->composers as $composer) {
                                $credits->composer[] =
                                    new Tv\Elements\Credits\Composer($composer);
                            }

                            foreach ($airing->directors as $director) {
                                $credits->director[] =
                                    new Tv\Elements\Credits\Director($director);
                            }

                            foreach ($airing->editors as $editor) {
                                $credits->editor[] =
                                    new Tv\Elements\Credits\Editor($editor);
                            }

                            foreach ($airing->guests as $guest) {
                                $credits->guest[] =
                                    new Tv\Elements\Credits\Guest($guest);
                            }

                            foreach ($airing->presenters as $presenter) {
                                $credits->presenter[] =
                                    new Tv\Elements\Credits\Presenter($presenter);
                            }

                            foreach ($airing->producers as $producer) {
                                $credits->producer[] =
                                    new Tv\Elements\Credits\Producer($producer);
                            }

                            foreach ($airing->writers as $writer) {
                                $credits->writer[] =
                                    new Tv\Elements\Credits\Writer($writer);
                            }

                            $program->addCredits($credits);
                        }

                        foreach($airing->categories as $category) {
                            $program->addCategory(
                                new Tv\Elements\Category($category)
                            );
                        }

                        if (!$airing->isMovie && 
                            $airing->isPreviouslyShown) {
                            $program->previouslyShown = new Tv\Elements\PreviouslyShown(
                                $airing->firstAiredDate->format('Ymd') ?? ''
                            );
                        } elseif (!$airing->isMovie && $airing->isNew) {
                            $program->new = new Tv\Elements\NewProgramme();
                        }

                        if ($airing->isLive) {
                            $program->live = new Tv\Elements\LiveProgramme();
                        }

                        if ($airing->isPremiere) {
                            $program->premiere = 
                                new Tv\Elements\Premiere('Season Premiere');
                        }

                        if ($airing->isHdtv) {
                            $program->video =
                                new Tv\Elements\Video('yes', '', '', 'HDTV');
                        } else {
                            $program->video =
                                new Tv\Elements\Video('yes');
                        }

                        if ($airing->isDolbyDigital) {
                            $program->audio =
                                new Tv\Elements\Audio('yes', 'dolby digital');
                        } elseif ($airing->isDolby) {
                            $program->audio =
                                new Tv\Elements\Audio('yes', 'dolby');
                        } elseif ($airing->isStereo) {
                            $program->audio =
                                new Tv\Elements\Audio('yes', 'stereo');
                        } else {
                            $program->audio = new Tv\Elements\Audio('yes');
                        }

                        if ($airing->hasClosedCaptioning) {
                            $program->addSubtitles(
                                new Tv\Elements\Subtitles(
                                    Tv\Elements\Subtitles\Type::TELETEXT
                                )
                            );
                        }

                        if (isset($airing->airingLanguage)) {
                            $program->language = 
                                new Language($airing->airingLanguage);
                        }

                        if (isset($airing->airingOriginalLanguage)) {
                            $program->origLanguage = 
                                new OrigLanguage($airing->airingOriginalLanguage);
                        }

                        foreach ($airing->ratings as $rating) {
                            $program->addRating(
                                new Tv\Elements\Rating(
                                    $rating->rating,
                                    $rating->system ?? ''
                                )
                            );
                        }

                        foreach ($airing->reviews as $review) {
                            $program->addStarRating(
                                new Tv\Elements\StarRating(
                                    $review->review,
                                    $review->system ?? ''
                                )
                            );
                        }

                        fputs($handle, $this->renderXmlTvElement($program));
                    }
                }
            }
        }
        unset($guide);
    }

    /**
     * Renders the XMLTV element to a string for streaming.
     *
     * @param XmlSerializable  $element
     */
    final protected function renderXmlTvElement(XmlSerializable $element): string
    {
        $doc = new DOMDocument();
        $this->buildXmlTvElement($doc, $element->xmlSerialize());
        return $doc->saveXML($doc->firstChild);
    }

    /**
     * Build the serialized XMLTV element (recursively).
     *
     * @param DOMNode     $domNode
     * @param XmlElement  $xmlElement
     */
    final protected function buildXmlTvElement(DOMNode &$domNode, XmlElement $xmlElement): void
    {
        if ($this->isEmptyXmlTvElement($xmlElement)) {
            return;
        }

        $element = new DOMElement($xmlElement->getName());
        $node = $domNode->appendChild($element);

        if ($node instanceof DOMElement) {
            foreach ($xmlElement->getAttributes() as $attribute => $value) {
                $node->setAttribute($attribute, $value);
            }
        }

        if ($xmlElement->hasChildren()) {
            foreach ($xmlElement->getChildren() as $child) {
                $this->buildXmlTvElement($node, $child);
            }
        } else {
            if (!is_null($xmlElement->getValue())) {
                $node->textContent = $xmlElement->getValue();
            }
        }
    }

    /**
     * Returns `true` if the passed element is empty.
     *
     * @param XmlElement $xmlElement
     * @return bool
     */
    final protected function isEmptyXmlTvElement(XmlElement $xmlElement): bool
    {
        return
            is_null($xmlElement->getValue()) &&
            !$xmlElement->hasChildren() &&
            !$xmlElement->hasAttributes() &&
            !in_array($xmlElement->getName(), ['live', 'new']);
    }
}
