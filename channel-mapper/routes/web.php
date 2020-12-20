<?php

use App\Http\Controllers\Channels\ChannelController;
use App\Http\Controllers\Channels\GuideController;
use App\Http\Controllers\Pluto\ChannelController as PlutoChannelController;
use App\Http\Controllers\Pluto\GuideController as PlutoGuideController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ChannelController::class, 'index']);

Route::get('/channels/{source}', [ChannelController::class, 'list'])
    ->name('getChannelMapUI');

Route::post('/channels/{source}/map', [ChannelController::class, 'map'])
    ->name('applyChannelMap');

Route::get('/channels/{source}/playlist', [ChannelController::class, 'playlist'])
    ->name('sourcePlaylist');

Route::get('/channels/{source}/guide', [GuideController::class, 'xmltv'])
    ->name('sourceXmlTv');

Route::get('/pluto', [PlutoChannelController::class, 'list'])
    ->name('getPlutoMapUI');

Route::post('/pluto/map', [PlutoChannelController::class, 'map'])
    ->name('applyPlutoChannelMap');

Route::get('/pluto/playlist', [PlutoChannelController::class, 'playlist'])
    ->name('plutoPlaylist');

Route::get('/pluto/guide', [PlutoGuideController::class, 'xmltv'])
    ->name('plutoXmlTv');
