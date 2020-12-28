<?php

namespace App\Providers;

use App\Contracts\BackendService;
use App\Http\Controllers\ChannelSource\GuideController;
use Exception;
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
        $this->app->bind(BackendService::class, function(){

            $source = $this->app->make('router')->input('channelSource');
            
            if (isset($this->app['config']['channels']['channelSources'][$source])) {
                return new $this->app['config']['channels']['channelSources'][$source]['backendService'];
            }
            else {
                throw new Exception("Source {$source} does not exist.");
            }
        });

        $this->app->when(GuideController::class)
          ->needs('$channelSource')
          ->give(function($app) {
                return $app->make('router')->input('channelSource');
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