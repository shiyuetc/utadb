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

Route::middleware('api')->group(function() {
    Route::get('analysis', 'Api\ApplicationController@analysis');
    Route::get('application/resource', 'Api\ApplicationController@resourceCount');

    Route::prefix('friends')->group(function() {
        Route::get('following', 'Api\FriendController@following');
        Route::get('followers', 'Api\FriendController@followers');
    });

    Route::prefix('songs')->group(function() {
        Route::get('/', 'Api\SongController@index');
        Route::get('@{id}', 'Api\SongController@user');
        Route::get('@{id}/common', 'Api\SongController@common');
        Route::get('recent', 'Api\SongController@recent');
        Route::get('ranking', 'Api\SongController@ranking');
    });

    Route::prefix('statuses')->group(function() {
        Route::get('lookup', 'Api\StatusController@lookup');
        Route::get('registereUser', 'Api\StatusController@registereUser');
    });

    Route::get('timeline', 'Api\PostController@index');

    Route::get('users', 'Api\UserController@index');

    Route::middleware('auth.api')->group(function() {
        Route::get('avatars', 'Api\AvatarController@index');
    
        Route::prefix('friends')->group(function() {
            Route::post('create', 'Api\FriendController@create');
            Route::post('destroy', 'Api\FriendController@destroy');
        });
    
        Route::prefix('likes')->group(function() {
            Route::post('create', 'Api\LikeController@create');
            Route::post('destroy', 'Api\LikeController@destroy');
        });
    
        Route::get('notifications', 'Api\NotificationController@index');
        
        Route::prefix('statuses')->group(function() {
            Route::post('update', 'Api\StatusController@update');
            Route::post('destroy', 'Api\StatusController@destroy');
        });
    });
});
