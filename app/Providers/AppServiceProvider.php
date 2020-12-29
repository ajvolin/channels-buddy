<?php

namespace App\Providers;

use App\Contracts\ChannelSource;
use App\Exceptions\InvalidSourceException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected array $channelSources = [
        'channels' => \App\Services\ChannelsService::class,
        'pluto' => \App\Services\PlutoService::class,
        'stirr' => \App\Services\StirrService::class
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ChannelSource::class, function() {
            $source = explode(':', $this->app->make('router')->input('channelSource'))[0];

            if (isset($this->channelSources[$source])) {
                return new $this->channelSources[$source];
            }
            else {
                throw new InvalidSourceException("Source {$source} does not exist.");
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}