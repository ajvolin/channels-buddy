<?php

namespace App\Http\Controllers\ChannelSource;

use App\APIModels\Guide;
use App\Contracts\BackendService;
use App\Http\Controllers\Controller;
use App\Models\ExternalChannel;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use XmlTv\Tv;
use XmlTv\Tv\Elements\Language;
use XmlTv\Tv\Elements\OrigLanguage;
use XmlTv\Tv\Elements\Url;
use XmlTv\XmlTv;

class GuideController extends Controller
{
    protected BackendService $backend;
    protected Collection $existingChannels;
    protected Tv $tv;
    protected array $processedChannels = [];
    protected array $processedAirings = [];

    public function __construct(BackendService $backend)
    {
        $this->backend = $backend;
        $this->tv = new Tv();
    }

    public function xmltv(Request $request, $source)
    {
        if ($request->has("fresh")) {
            Cache::forget("{$source}_channelsource_epg");
        }

        $xml = Cache::remember("{$source}_channelsource_epg", 1800, function () use ($source) {
            ini_set('memory_limit', '-1');

            $this->existingChannels =
                ExternalChannel::where('source', $source)->pluck('channel_id', 'channel_number');

            $guideDuration = config("channels.channelSources.{$source}.guideDuration");
            $guideChunkSize = config("channels.channelSources.{$source}.guideChunkSize");

            if (is_null($guideChunkSize) && is_null($guideDuration)) {
                $guideData = $this->backend
                        ->getGuideData(null, null);

                $this->parseGuide($guideData);
            } else {
                $guideIntervals = CarbonInterval::seconds($guideChunkSize)
                    ->toPeriod(
                        Carbon::now(),
                        Carbon::now()->addSeconds($guideDuration)
                    );

                foreach ($guideIntervals as $guideInterval) {
                    $guideData = $this->backend
                        ->getGuideData($guideInterval->timestamp, $guideChunkSize);

                    $this->parseGuide($guideData);

                    unset($guideData);
                    gc_collect_cycles();
                }
            }

            return XmlTv::generate($this->tv, true);
        });

        return response($xml)->header('Content-Type', 'text/xml');
    }

    private function parseGuide(Guide $guide)
    {
        foreach ($guide->guideEntries as $entry) {
            $channelNumber = $this->existingChannels
                ->search($entry->channel->id) ?? 
                    $entry->channel->number ?? null;
            
            if (!in_array($entry->channel->id, $this->processedChannels)) {
                $this->processedChannels[] = $entry->channel->id;
                $channel = new Tv\Channel($entry->channel->id);

                if (isset($entry->channel->callSign)) {
                    $channel->addDisplayName(
                        new Tv\Elements\DisplayName($entry->channel->callSign)
                    );
                }

                if (isset($entry->channel->name)) {
                    $channel->addDisplayName(
                        new Tv\Elements\DisplayName($entry->channel->name)
                    );
                }

                if (isset($entry->channel->title)) {
                    $channel->addDisplayName(
                        new Tv\Elements\DisplayName($entry->channel->title)
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

                if (isset($entry->channel->streamUrl)) {
                    $channel->addUrl(
                        new Url($entry->channel->streamUrl)
                    );
                }


                $this->tv->addChannel($channel);
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

                    if (isset($entry->channel->streamUrl)) {
                        $program->addUrl(
                            new Url($entry->channel->streamUrl)
                        );
                    }

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
                        $program->addEpisodeNum(
                            new Tv\Elements\EpisodeNum(
                                ($airing->seasonNumber ?? "")
                                    . $airing->episodeNumber,
                                'onscreen'
                            )
                        );

                        if (isset($airing->seasonNumber)
                            && is_numeric($airing->seasonNumber)
                            && is_numeric($airing->episodeNumber)
                            && ($airing->seasonNumber > 0
                                || $airing->episodeNumber > 0)
                        ) {
                            $sN = $airing->seasonNumber - 1;
                            $eN = $airing->episodeNumber - 1;

                            $program->addEpisodeNum(
                                new Tv\Elements\EpisodeNum(
                                    ($sN >= 0 ? $sN : "") . "."
                                    . ($eN >= 0 ? $eN : "") . ".",
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
                                $airing->source ?? 'original-date'
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

                    $this->tv->addProgramme($program);
                }
            }
        }
        unset($guide);
    }
}
