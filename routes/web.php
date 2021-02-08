<?php

use App\Http\Controllers\Channels\ChannelController;
use App\Http\Controllers\Channels\GuideController;
use App\Http\Controllers\ChannelSource\ChannelController as ChannelSourceChannelController;
use App\Http\Controllers\ChannelSource\GuideController as ChannelSourceGuideController;
use App\Http\Controllers\ChannelsBuddyController;
use App\Http\Controllers\LogController;
use App\Services\ChannelsService;
use ChannelsBuddy\SourceProvider\ChannelSourceProviders;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', function(ChannelSourceProviders $sourceProviders, ChannelsService $channelSource){
    Inertia::setRootView('layouts.app');
    Inertia::version(function () {
        return md5_file(public_path('mix-manifest.json'));
    });

    // return $channelSource->getDevices();
    // return $sourceProviders->toArray()['providers'];
            // ?? null;


    return Inertia::render('Home', [
        'channels_dvr' => ['sources' => $channelSource->getDevices() ?? []],
        'external_sources' => ['sources' => $sourceProviders->toArray()['providers'] ?? []]
    ]);
});

Route::get('/', [ChannelsBuddyController::class, 'index'])->name('home');

Route::get('/log', [LogController::class, 'log'])->name('log');

Route::get('/channels/{source}', [ChannelController::class, 'list'])
    ->name('getChannelMapUI');

Route::post('/channels/{source}/map', [ChannelController::class, 'map'])
    ->name('applyChannelMap');

Route::get('/channels/{source}/playlist', [ChannelController::class, 'playlist'])
    ->name('sourcePlaylist');

Route::get('/channels/{source}/guide', [GuideController::class, 'xmltv'])
    ->name('sourceXmlTv');

Route::get('/source/{channelSource}', [ChannelSourceChannelController::class, 'list'])
    ->name('getChannelSourceMapUI');

Route::post('/source/{channelSource}/map', [ChannelSourceChannelController::class, 'map'])
    ->name('applyChannelSourceChannelMap');

Route::get('/source/{channelSource}/playlist', [ChannelSourceChannelController::class, 'playlist'])
    ->name('channelSourcePlaylist');

Route::get('/source/{channelSource}/guide', [ChannelSourceGuideController::class, 'xmltv'])
    ->name('channelSourceXmlTv');