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

    Route::get('analysis/artist_rate', 'Api\ApplicationController@artistRate');

    Route::get('timeline', 'Api\PostController@index');
    
    Route::get('statuses/lookup', 'Api\StatusController@lookup');
    Route::get('statuses/registereUser', 'Api\StatusController@registereUser');

    Route::prefix('songs')->group(function() {
        Route::get('/', 'Api\SongController@index');
        Route::get('{id}', 'Api\SongController@user');
        Route::get('{id}/common', 'Api\SongController@common');
    });

    Route::get('users', 'Api\UserController@index');
});

Route::group(['middleware' => ['api', 'auth.api']], function(){
    Route::get('avatars', 'Api\AvatarController@index');
    Route::get('notifications', 'Api\NotificationController@index');
    
    Route::post('statuses/update', 'Api\StatusController@update');

    Route::post('likes/create', 'Api\LikeController@create');
    Route::post('likes/destroy', 'Api\LikeController@destroy');
});
