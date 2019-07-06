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
    
    Route::get('user_timeline', 'Api\ActivityController@userTimeline');
    Route::get('public_timeline', 'Api\ActivityController@publicTimeline');

    Route::get('user_statuses', 'Api\SongController@userStatuses');

    Route::get('statuses/lookup', 'Api\StatusController@lookup');

    Route::get('songs/search_from_artist', 'Api\SongController@searchFromArtist');
});

Route::group(['middleware' => ['api', 'auth.api']], function(){
    Route::get('notifications/list', 'Api\NotificationController@list');

    Route::get('avatars/search', 'Api\AvatarController@search');

    Route::get('songs/search', 'Api\SongController@search');
    Route::get('user_common', 'Api\SongController@userCommon');

    Route::prefix('users')->group(function() {
        Route::get('list', 'Api\UserController@list');
        Route::get('search', 'Api\UserController@search');
    });
    
    Route::post('statuses/update', 'Api\StatusController@edit');

    Route::post('likes/create', 'Api\ActivityController@likeCreate');
    Route::post('likes/destroy', 'Api\ActivityController@likeDestroy');
});
