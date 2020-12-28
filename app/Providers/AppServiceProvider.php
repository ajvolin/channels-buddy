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
        $this->app->bind(BackendService::class, function() {
            $source = explode(':', $this->app->make('router')->input('channelSource'))[0];

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
                  return explode(':', $app->make('router')->input('channelSource'))[0];
              });

        $this->app->when(GuideController::class)
            ->needs('$subSource')
            ->give(function($app) {
                return explode(':', $app->make('router')->input('channelSource'))[1] ?? null;
            });
        
        $this->app->when(GuideController::class)
            ->needs('$device')
            ->give(function($app) {
                return explode(':', $app->make('router')->input('channelSource'))[2] ?? null;
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