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
    Route::get('show_status', 'Api\ApiController@showStatus');

    Route::get('user_statuses', 'Api\ApiController@userStatuses');
    Route::get('user_timeline', 'Api\ApiController@userTimeline');
    Route::get('public_timeline', 'Api\ApiController@publicTimeline');
});

Route::group(['middleware' => ['api', 'auth']], function(){
    Route::get('search_avatar', 'Api\SearchController@searchAvatar');
    Route::get('search_user', 'Api\SearchController@searchUser');
    Route::get('search_song', 'Api\SearchController@searchSong');
    
    Route::get('user_common', 'Api\ApiController@userCommon');

    Route::post('update_status', 'Api\ApiController@updateStatus');
});
