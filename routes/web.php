<?php

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

Route::get('/', 'HomeController@index')->name('home');

Route::prefix('@{id}')->group(function() {
  Route::get('/', 'UserController@index')->name('user');
  Route::get('/status/{state}', 'UserController@status')->name('user.status')
    ->where('state', 'all|mastered|training|stacked');
});
Route::get('search/user', 'UserController@search')->name('search.user');

Route::get('search/song', 'SongController@search')->name('search.song');
Route::get('songs/{id}', 'SongController@index')->name('song')
  ->where('id', '\d{5,18}');

Route::get('settings/profile', 'SettingController@showProfileSettingForm')->name('settings.profile');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
