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
    Route::get('status/lookup', 'Api\StatusesController@statusLookup');

    Route::get('user_statuses', 'Api\StatusesController@userStatuses');
    Route::get('user_timeline', 'Api\StatusesController@userTimeline');
    Route::get('public_timeline', 'Api\StatusesController@publicTimeline');
});

Route::group(['middleware' => ['api', 'auth']], function(){
    Route::prefix('search')->group(function() {
        Route::get('avatar', 'Api\SearchController@searchAvatar');
        Route::get('user', 'Api\SearchController@searchUser');
        Route::get('song', 'Api\SearchController@searchSong');
    });

    Route::post('status/update', 'Api\StatusesController@statusUpdate');
    
    Route::get('user_common', 'Api\StatusesController@userCommon');
});
