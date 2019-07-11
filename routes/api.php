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
    
    Route::get('user_timeline', 'Api\PostController@userTimeline');
    Route::get('public_timeline', 'Api\PostController@publicTimeline');
    
    Route::get('statuses/lookup', 'Api\StatusController@lookup');
    Route::get('statuses/registereUser', 'Api\StatusController@registereUser');

    Route::prefix('songs')->group(function() {
        Route::get('/', 'Api\SongController@index');
        Route::get('{id}', 'Api\SongController@user');
        Route::get('{id}/common', 'Api\SongController@common');
    });
});

Route::group(['middleware' => ['api', 'auth.api']], function(){
    Route::get('notifications', 'Api\NotificationController@index');

    Route::get('avatars/search', 'Api\AvatarController@search');

    Route::prefix('users')->group(function() {
        Route::get('list', 'Api\UserController@list');
        Route::get('search', 'Api\UserController@search');
    });
    
    Route::post('statuses/update', 'Api\StatusController@update');

    Route::post('likes/create', 'Api\LikeController@create');
    Route::post('likes/destroy', 'Api\LikeController@destroy');
});
