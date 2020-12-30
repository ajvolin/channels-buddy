<?php

namespace App\Providers;

use ChannelsBuddy\SourceProvider\ChannelSourceProvider;
use ChannelsBuddy\SourceProvider\ChannelSourceProviders;
use ChannelsBuddy\SourceProvider\Contracts\ChannelSource;
use ChannelsBuddy\SourceProvider\Exceptions\InvalidSourceException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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
    public function boot(ChannelSourceProviders $sourceProviders)
    {
        Route::bind('channelSource', function (string $channelSource)
            use ($sourceProviders): ChannelSourceProvider {
            return $sourceProviders->getChannelSourceProvider($channelSource);
        });

        View::composer('*', function ($view) use ($sourceProviders) {
            $view->with('channelSources', $sourceProviders);
        });
    }
}