<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use UserToAdmin\Favorites\Http\Controllers\FavoritesController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {
    Route::controller(FavoritesController::class)->group(function () {
        Route::get('/favorites/{pairid}',  'toggleFavoritePair');
        Route::get('/favoritesPairList',  'favoritesPairList');
    });
});
