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

Route::get('/', [ChannelsBuddyController::class, 'index'])->name('home');

Route::get('/log', [LogController::class, 'log'])->name('log');

Route::get('/channels/{source}', [ChannelController::class, 'list'])
    ->name('channels.source.map-ui');

Route::post('/channels/{source}/map', [ChannelController::class, 'map'])
    ->name('channels.source.apply-map');

Route::get('/channels/{source}/playlist', [ChannelController::class, 'playlist'])
    ->name('channels.source.playlist');

Route::get('/channels/{source}/guide', [GuideController::class, 'xmltv'])
    ->name('channels.source.guide');

Route::get('/source/{channelSource}/channels', [ChannelSourceChannelController::class, 'getChannels'])
    ->name('channel-source.source.get-channels');

Route::put('/source/{channelSource}/channel', [ChannelSourceChannelController::class, 'updateChannel'])
    ->name('channel-source.source.update-channel');

Route::put('/source/{channelSource}/channels', [ChannelSourceChannelController::class, 'updateChannels'])
    ->name('channel-source.source.update-channels');

Route::get('/source/{channelSource}', [ChannelSourceChannelController::class, 'mapUi'])
    ->name('channel-source.source.map-ui');

Route::get('/source/{channelSource}/playlist', [ChannelSourceChannelController::class, 'playlist'])
    ->name('channel-source.source.playlist');

Route::get('/source/{channelSource}/guide', [ChannelSourceGuideController::class, 'xmltv'])
    ->name('channel-source.source.guide');