<?php

namespace App\Http\Controllers\Pluto;

use App\Http\Controllers\Controller;
use App\Models\PlutoChannel;
use App\Services\PlutoBackendService;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use XmlTv\Tv;
use XmlTv\XmlTv;

class GuideController extends Controller
{
    protected $plutoBackend;

    protected $genres = [
        "Children" => ["Kids", "Children & Family", "Kids' TV", "Cartoons", "Animals", "Family Animation", "Ages 2-4", "Ages 11-12"],
        "News" => ["News + Opinion", "General News"],
        "Sports" => ["Sports", "Sports & Sports Highlights", "Sports Documentaries"],
        "Drama" => ["Crime", "Action & Adventure", "Thrillers", "Romance", "Sci-Fi & Fantasy", "Teen Dramas", "Film Noir", "Romantic Comedies", "Indie Dramas", "Romance Classics", "Crime Action", "Action Sci-Fi & Fantasy", "Action Thrillers", "Crime Thrillers", "Political Thrillers", "Classic Thrillers", "Classic Dramas", "Sci-Fi Adventure", "Romantic Dramas", "Mystery", "Psychological Thrillers", "Foreign Classic Dramas", "Classic Westerns", "Westerns", "Sci-Fi Dramas", "Supernatural Thrillers", "Mobster", "Action Classics", "African-American Action", "Suspense", "Family Dramas", "Alien Sci-Fi", "Sci-Fi Cult Classics"]
    ];


    public function __construct()
    {
        $this->plutoBackend = new PlutoBackendService();
    }

    public function xmltv(Request $request)
    {
        if ($request->has("fresh")) {
            Cache::forget('pluto_epg');
        }

        $xml = Cache::remember('pluto_epg', 1800, function () {
            $guideDuration = 86400;
            $guideChunkSize = 21600;

            $guideIntervals = CarbonInterval::seconds($guideChunkSize)
                ->toPeriod(
                    Carbon::now(),
                    Carbon::now()->addSeconds($guideDuration)
                );

            $existingChannels = PlutoChannel::pluck('channel_id', 'channel_number');

            // Instantiate new Tv object
            $tv = new Tv();

            // Keep track of channels that have already been added to avoid duplicates
            $processedChannels = [];

            foreach ($guideIntervals as $guideInterval) {
                $guideData = $this->plutoBackend
                    ->getGuideData($guideInterval->timestamp, $guideChunkSize);

                foreach ($guideData as $data) {
                    $channelNumber = $existingChannels->search($data->slug) ?? $data->number;
                    $channelId = $data->slug;

                    if (!in_array($channelId, $processedChannels)) {
                        $processedChannels[] = $channelId;

                        $channel = new Tv\Channel($channelId);
                        $channel->addDisplayName(new Tv\Elements\DisplayName($data->name));
                        
                        $channel->addDisplayName(new Tv\Elements\DisplayName($channelNumber));

                        if (isset($data->colorLogoPNG->path)) {
                            $channel->addIcon(new Tv\Elements\Icon($data->colorLogoPNG->path));
                        }
                        $tv->addChannel($channel);
                    }

                    if (isset($data->timelines) && count($data->timelines) > 0) {
                        foreach ($data->timelines as $airing) {
                            $startTime = Carbon::parse($airing->start);
                            $endTime = Carbon::parse($airing->stop);
                            $airingDuration = $startTime->copy()->diffInSeconds($endTime);

                            $startTime = $startTime->format('YmdHis O');
                            $endTime = $endTime->format('YmdHis O');

                            $program = new Tv\Programme($channelId, $startTime, $endTime);

                            $program->length = new Tv\Elements\Length(
                                $airingDuration,
                                Tv\Elements\Length\Unit::SECONDS
                            );

                            $isMovie = $airing->episode->series->type == "film";

                            $program->addTitle(new Tv\Elements\Title($airing->title));

                            if (!$isMovie && $airing->title != $airing->episode->name) {
                                $program->addSubTitle(new Tv\Elements\SubTitle($airing->episode->name));
                            }

                            $program->addDescription(new Tv\Elements\Desc($airing->episode->description));

                            if ($isMovie) {
                                $airingArt = $airing->episode->poster->path;
                            } else {
                                $airingArt = str_replace("h=660", "h=900",
                                    str_replace("w=660", "w=900",    
                                        $airing->episode->series->tile->path
                                    )
                                );
                            }

                            $program->addIcon(new Tv\Elements\Icon($airingArt));

                            if (isset($airing->episode->series->_id)) {
                                $program->addSeriesId(
                                    new Tv\Elements\SeriesId($airing->episode->series->_id, "pluto")
                                );
                            }

                            $program->addEpisodeNum(
                                new Tv\Elements\EpisodeNum($airing->episode->_id, "pluto")
                            );

                            $program->addEpisodeNum(
                                new Tv\Elements\EpisodeNum(
                                    $airing->episode->clip->originalReleaseDate,
                                    "original-air-date"
                                )
                            );
                            
                            if (!$isMovie) {
                                $program->addEpisodeNum(
                                    new Tv\Elements\EpisodeNum(
                                        $airing->episode->number,
                                        'onscreen'
                                    )
                                );

                                $program->addEpisodeNum(
                                    new Tv\Elements\EpisodeNum(
                                        ".{$airing->episode->number}.",
                                        'xmltv_ns'
                                    )
                                );
                            }

                            $originalDate = Carbon::parse($airing->episode->clip->originalReleaseDate);
                            if ($isMovie) {
                                $program->date = new Tv\Elements\Date(
                                    $originalDate->copy()->format('Y')
                                );
                            } else {
                                $program->date = new Tv\Elements\Date(
                                    $originalDate->copy()->format('Ymd')
                                );
                            }

                            $program->addCategory(
                                new Tv\Elements\Category($isMovie ? "Movie" : "Series")
                            );
                            $program->addCategory(
                                new Tv\Elements\Category($airing->episode->genre)
                            );
                            $program->addCategory(
                                new Tv\Elements\Category($airing->episode->subGenre)
                            );

                            foreach($this->genres as $genreName => $genres) {
                                if (
                                    in_array($airing->episode->genre, $genres) ||
                                    in_array($airing->episode->subGenre, $genres) ||
                                    in_array($data->category, $genres)
                                ) {
                                    $program->addCategory(new Tv\Elements\Category($genreName));
                                }
                            }

                            $firstAired = Carbon::parse($airing->episode->firstAired);
                            if (!$isMovie && $firstAired->isPast()) {
                                $program->previouslyShown = new Tv\Elements\PreviouslyShown(
                                    $firstAired->format('Ymd')
                                );
                            }
                            elseif (!$isMovie) {
                                $program->new = new Tv\Elements\NewProgramme();
                            }

                            $program->video = new Tv\Elements\Video('yes');
                            $program->audio = new Tv\Elements\Audio('yes');

                            $program->addRating(
                                new Tv\Elements\Rating($airing->episode->rating)
                            );

                            $tv->addProgramme($program);
                        }
                    }
                }
                unset($guideData);
                gc_collect_cycles();
            }

            return XmlTv::generate($tv, true);
        });

        return response($xml)->header('Content-Type', 'text/xml');
    }
}
