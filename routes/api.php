<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['api']], function(){
    Route::get('/show_status', 'ApiController@showStatus');
    Route::get('/search_song', 'ApiController@searchSong');
    Route::get('/user_statuses', 'ApiController@userStatuses');
    Route::get('/user_timeline', 'ApiController@userTimeline');
    Route::get('/public_timeline', 'ApiController@publicTimeline');
});

Route::group(['middleware' => ['api', 'auth']], function(){
    Route::post('/update_status', 'ApiController@updateStatus');
});
