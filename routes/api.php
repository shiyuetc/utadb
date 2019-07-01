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

Route::group(['middleware' => 'api'], function(){
    Route::get('application/resource', 'Api\ApplicationController@resourceCount');
    
    Route::get('status/lookup', 'Api\StatusController@lookup');

    Route::get('user_statuses', 'Api\SongController@userStatuses');
    
    Route::get('user_timeline', 'Api\ActivityController@userTimeline');
    Route::get('public_timeline', 'Api\ActivityController@publicTimeline');
});

Route::group(['middleware' => ['api', 'auth']], function(){
    Route::prefix('users')->group(function() {
        Route::get('list', 'Api\UserController@list');
        Route::get('search', 'Api\UserController@search');
    });
    
    Route::prefix('search')->group(function() {
        Route::get('avatar', 'Api\SearchController@searchAvatar');
        Route::get('song', 'Api\SearchController@searchSong');
    });
    Route::get('user_common', 'Api\SongController@userCommon');
    Route::post('status/update', 'Api\StatusController@update');
});
