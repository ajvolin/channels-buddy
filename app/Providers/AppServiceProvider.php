<?php

namespace App\Providers;

use ChannelsBuddy\SourceProvider\ChannelSourceProvider;
use ChannelsBuddy\SourceProvider\ChannelSourceProviders;
use ChannelsBuddy\SourceProvider\Contracts\ChannelSource;
use ChannelsBuddy\SourceProvider\Exceptions\InvalidSourceException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(ChannelSourceProviders $sourceProvider)
    {
        $sourceProvider->registerChannelSourceProvider('pluto', new ChannelSourceProvider(
            \App\Services\PlutoService::class,
            'Pluto TV', true, true, 86400, 21600
        ));

        $sourceProvider->registerChannelSourceProvider('stirr', new ChannelSourceProvider(
            \App\Services\StirrService::class,
            'Stirr', true, false
        ));
    }
}