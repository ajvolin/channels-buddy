<?php

namespace App\Providers;

use App\Contracts\BackendService;
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
                throw new \Exception("Source {$source} does not exist.");
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