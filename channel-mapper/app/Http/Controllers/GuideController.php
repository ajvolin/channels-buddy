<?php

namespace App\Http\Controllers;

use App\Models\DvrChannel;
use App\Services\ChannelsBackendService;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Exception;
use Str;
use Illuminate\Http\Request;
use XmlTv\Tv;
use XmlTv\XmlTv;

class GuideController extends Controller
{
    protected $channelsBackend;

    public function __construct()
    {
        $this->channelsBackend = new ChannelsBackendService();
    }

    public function xmltv(Request $request)
    {
        ini_set('memory_limit', '-1');

        $source = $request->source;
        if (!$this->channelsBackend->isValidDevice($source)) {
            throw new Exception('Invalid source detected.');
        }

        if (!isset($request->duration)) {
            $durationDays = intval($request->days) ?? 0;
            $durationHours = intval($request->hours) ?? 0;
            $durationMinutes = intval($request->minutes) ?? 0;
            $durationSeconds = intval($request->seconds) ?? 0;

            $duration = (($durationDays * 86400) + ($durationHours * 3600) +
                ($durationMinutes * 60) + $durationSeconds) ?: config('channels.guideDuration');
        } else {
            $duration = intval($request->duration);
        }

        $guideDuration = intval(
            min($duration, config('channels.guideDuration'))
        );

        $guideChunkSize = min(
            $guideDuration,
            config('channels.backendChunkSize')
        );

        $guideIntervals = CarbonInterval::seconds($guideChunkSize)
            ->toPeriod(
                Carbon::now()->startOfHour(),
                Carbon::now()->startOfDay()->addSeconds($guideDuration)->endOfDay()
            );

        $emptyProgramIntervals = CarbonInterval::minutes(60)
            ->toPeriod(
                Carbon::now()->startOfHour(),
                Carbon::now()->startOfDay()->addSeconds($guideDuration)->endOfDay()
            );

        $existingChannels = DvrChannel::pluck('guide_number', 'mapped_channel_number');

        // Instantiate new Tv object
        $tv = new Tv();

        // Keep track of channels that have already been added to avoid duplicates
        $processedChannels = [];
        $processedEmptyGuideChannels = [];

        // Keep track of guide entries that have already been added to minimize file size
        $processedAirings = [];

        foreach ($guideIntervals as $guideInterval) {
            $guideData = $this->channelsBackend
                ->getGuideData($source, $guideInterval->timestamp, $guideChunkSize);

            foreach ($guideData as $data) {
                $channelNumber = $existingChannels->search($data->Channel->Number) ?? $data->Channel->Number;
                $channelId = Str::kebab(strtolower($data->Channel->CallSign ?? $data->Channel->Name ?? $channelNumber));

                if (!in_array($channelId, $processedChannels)) {
                    $processedChannels[] = $channelId;

                    $channel = new Tv\Channel($channelId);
                    if (isset($data->Channel->CallSign)) {
                        $channel->addDisplayName(new Tv\Elements\DisplayName($data->Channel->CallSign));
                    }
                    if (isset($data->Channel->Name)) {
                        $channel->addDisplayName(new Tv\Elements\DisplayName($data->Channel->Name));
                    }
                    if (isset($data->Channel->Title)) {
                        $channel->addDisplayName(new Tv\Elements\DisplayName($data->Channel->Title));
                    }
                    $channel->addDisplayName(new Tv\Elements\DisplayName($channelNumber));

                    if (isset($data->Channel->Image)) {
                        $channel->addIcon(new Tv\Elements\Icon($data->Channel->Image));
                    }
                    $tv->addChannel($channel);
                }

                if (count($data->Airings) > 0) {
                    foreach ($data->Airings as $airing) {
                        $airingId = $channelId . $airing->Time;

                        if (!in_array($airingId, $processedAirings)) {
                            $startTime = Carbon::createFromTimestamp($airing->Time);
                            $endTime = $startTime->copy()->addSeconds($airing->Duration)->format('YmdHis O');

                            $startTime = $startTime->format('YmdHis O');

                            $program = new Tv\Programme($channelId, $startTime, $endTime);

                            $program->length = new Tv\Elements\Length(
                                $airing->Duration,
                                Tv\Elements\Length\Unit::SECONDS
                            );

                            if (isset($airing->Title)) {
                                $program->addTitle(new Tv\Elements\Title(
                                    $airing->Title,
                                    $airing->Raw->program->titleLang ?? "")
                                );
                            }

                            if (isset($airing->EpisodeTitle)) {
                                $program->addSubTitle(new Tv\Elements\SubTitle(
                                    $airing->EpisodeTitle,
                                    $airing->Raw->program->titleLang ?? "")
                                );
                            } elseif (isset($airing->EventTitle)) {
                                $program->addSubTitle(new Tv\Elements\SubTitle(
                                    $airing->EventTitle,
                                    $airing->Raw->program->titleLang ?? "")
                                );
                            }

                            $program->addDescription(new Tv\Elements\Desc(
                                $airing->Raw->program->longDescription ??
                                $airing->Raw->program->shortDescription ??
                                $airing->Summary ?? "",
                                $airing->Raw->program->descriptionLang ?? "")
                            );

                            if (isset($airing->Raw->program->preferredImage->uri) || isset($airing->Image)) {
                                $program->addIcon(new Tv\Elements\Icon(
                                    $airing->Raw->program->preferredImage->uri ?? $airing->Image,
                                    $airing->Raw->program->preferredImage->width ?? "",
                                    $airing->Raw->program->preferredImage->height ?? "")
                                );
                            }

                            if (isset($airing->Source) && isset($airing->SeriesID)) {
                                $program->addSeriesId(new Tv\Elements\SeriesId($airing->SeriesID, $airing->Source));
                            }

                            if (isset($airing->Source) && isset($airing->ProgramID)) {
                                $program->addEpisodeNum(new Tv\Elements\EpisodeNum($airing->ProgramID, $airing->Source));
                            }

                            if (isset($airing->SeasonNumber)
                                && isset($airing->EpisodeNumber)
                                && is_numeric($airing->SeasonNumber)
                                && is_numeric($airing->EpisodeNumber)
                                && ($airing->SeasonNumber > 0 || $airing->EpisodeNumber > 0)
                            ) {
                                $episodeNumOnScreen = $airing->SeasonNumber . sprintf("%02d", $airing->EpisodeNumber);
                                $program->addEpisodeNum(new Tv\Elements\EpisodeNum($episodeNumOnScreen, 'onscreen'));
                                $sN = $airing->SeasonNumber - 1;
                                $eN = $airing->EpisodeNumber - 1;
                                $episodeNumXmltvNs = ($sN >= 0 ? $sN : "") . "." . ($eN >= 0 ? $eN : "") . ".";
                                $program->addEpisodeNum(new Tv\Elements\EpisodeNum($episodeNumXmltvNs, 'xmltv_ns'));
                            }

                            $credits = new Tv\Elements\Credits();
                            if (isset($airing->Directors) && !is_null($airing->Directors)) {
                                foreach ($airing->Directors as $director) {
                                    $credits->director[] = new Tv\Elements\Credits\Director($director);
                                }
                            }
                            if (isset($airing->Cast) && !is_null($airing->Cast)) {
                                foreach ($airing->Cast as $cast) {
                                    $credits->actor[] = new Tv\Elements\Credits\Actor($cast);
                                }
                            }
                            $program->addCredits($credits);

                            if (isset($airing->OriginalDate)) {
                                if (isset($airing->Categories)
                                    && is_array($airing->Categories)
                                    && in_array("Movie", $airing->Categories)
                                ) {
                                    $program->date = new Tv\Elements\Date(
                                        Carbon::parse($airing->OriginalDate)->format('Y')
                                    );
                                } else {
                                    $program->date = new Tv\Elements\Date(
                                        Carbon::parse($airing->OriginalDate)->format('Ymd')
                                    );
                                }
                            }

                            if (isset($airing->Genres) && !is_null($airing->Genres)) {
                                foreach ($airing->Genres as $cat) {
                                    $program->addCategory(new Tv\Elements\Category($cat));
                                }
                            }

                            if (isset($airing->Categories) && !is_null($airing->Categories)) {
                                foreach ($airing->Categories as $cat) {
                                    $program->addCategory(new Tv\Elements\Category($cat));
                                }
                            }

                            if (isset($airing->Tags) && is_array($airing->Tags)) {
                                if (in_array("Live", $airing->Tags)) {
                                    $program->live = new Tv\Elements\LiveProgramme();
                                }

                                if (in_array("New", $airing->Tags)) {
                                    $program->new = new Tv\Elements\NewProgramme();
                                    $program->date = new Tv\Elements\Date(
                                        Carbon::createFromTimestamp($airing->Time)->format('Ymd')
                                    );
                                } elseif (isset($airing->OriginalDate)) {
                                    if ((isset($airing->Categories)
                                            && is_array($airing->Categories)
                                            && !in_array("Movie", $airing->Categories))
                                            || is_null($airing->Categories)
                                    ) {
                                        $program->previouslyShown = new Tv\Elements\PreviouslyShown(
                                            Carbon::parse($airing->OriginalDate)->format('Ymd')
                                        );
                                    }
                                }

                                if (in_array("Season Premiere", $airing->Tags)) {
                                    $program->premiere = new Tv\Elements\Premiere('Season Premiere');
                                }

                                if (in_array("HDTV", $airing->Tags)) {
                                    $program->video = new Tv\Elements\Video('yes', '', '', 'HDTV');
                                } else {
                                    $program->video = new Tv\Elements\Video('yes', '', '4:3', 'SDTV');
                                }

                                if (in_array("DD 5.1", $airing->Tags)) {
                                    $program->audio = new Tv\Elements\Audio('yes', 'dolby digital');
                                } elseif (in_array("Dolby", $airing->Tags)) {
                                    $program->audio = new Tv\Elements\Audio('yes', 'dolby');
                                } else {
                                    $program->audio = new Tv\Elements\Audio('yes', 'stereo');
                                }

                                if (in_array("CC", $airing->Tags)) {
                                    $subtitles = new Tv\Elements\Subtitles(Tv\Elements\Subtitles\Type::TELETEXT);
                                    $program->addSubtitles($subtitles);
                                }
                            } else {
                                $program->video = new Tv\Elements\Video('yes', '', '', '');
                                $program->audio = new Tv\Elements\Audio('yes', 'stereo');

                                if (isset($airing->OriginalDate)) {
                                    $originalDate = Carbon::parse($airing->OriginalDate)->endOfDay();
                                    if (((isset($airing->Categories)
                                            && is_array($airing->Categories)
                                            && !in_array("Movie", $airing->Categories)
                                        ) || is_null($airing->Categories))
                                        && $originalDate->isPast()
                                    ) {
                                        $program->previouslyShown = new Tv\Elements\PreviouslyShown(
                                            $originalDate->format('Ymd')
                                        );
                                    }
                                }
                            }

                            if (isset($airing->Raw->ratings) && !is_null($airing->Raw->ratings)) {
                                foreach ($airing->Raw->ratings as $rating) {
                                    $program->addRating(new Tv\Elements\Rating($rating->code, $rating->body));
                                }
                            }

                            if (isset($airing->Raw->program) && isset($airing->Raw->program->qualityRating) && !is_null($airing->Raw->program->qualityRating)) {
                                $program->addStarRating(new Tv\Elements\StarRating($airing->Raw->program->qualityRating->value, $airing->Raw->program->qualityRating->ratingsBody));
                            }

                            $tv->addProgramme($program);
                        }
                    }
                } else {
                    if (!in_array($channelId, $processedEmptyGuideChannels)) {
                        $processedEmptyGuideChannels[] = $channelId;

                        foreach ($emptyProgramIntervals as $date) {
                            $program = new Tv\Programme($channelId, $date->copy()->format('YmdHis O'), $date->copy()->endOfHour()->format('YmdHis O'));

                            $program->length = new Tv\Elements\Length("3600", Tv\Elements\Length\Unit::SECONDS);

                            $program->addTitle(new Tv\Elements\Title($data->Channel->Title ?? $data->Channel->Name ?? "To be announced"));
                            $program->addDescription(new Tv\Elements\Desc($data->Channel->Description ?? "To be announced"));
                            if (isset($data->Channel->Art)) {
                                $program->addIcon(new Tv\Elements\Icon($data->Channel->Art));
                            }

                            $program->video = new Tv\Elements\Video('yes', '', '', 'HDTV');
                            $program->audio = new Tv\Elements\Audio('yes', 'stereo');
                            $tv->addProgramme($program);
                        }
                    }
                }
            }
            unset($guideData);
            gc_collect_cycles();
        }

        $xml = XmlTv::generate($tv, true);
        return response($xml)->header('Content-Type', 'text/xml');
    }
}
