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
Route::get('terms', function () {return view('pages.terms');})->name('terms');
Route::get('privacy', function () {return view('pages.privacy');})->name('privacy');

Route::prefix('@{id}')->group(function() {
  Route::get('/', 'UserController@index')->name('user');
  Route::get('status/{state}', 'UserController@status')->name('user.status')
    ->where('state', 'all|mastered|training|stacked');
  Route::get('random', 'UserController@random')->name('user.random');
});

Route::get('songs/{id}', 'SongController@index')->name('song')
  ->where('id', '\d{5,18}');

Route::group(['prefix' => 'search', 'middleware' => 'auth'], function() {
  Route::get('user', 'SearchController@searchUser')->name('search.user');
  Route::get('song', 'SearchController@searchSong')->name('search.song');
});

Route::group(['prefix' => 'settings', 'middleware' => 'auth'], function() {
  Route::get('profile', 'SettingController@showProfileSettingForm')->name('settings.profile');
  Route::post('profile', 'SettingController@updateProfile');
  Route::get('password', 'SettingController@showPasswordSettingForm')->name('settings.password');
  Route::post('password', 'SettingController@updatePassword');
  Route::get('deactivate', 'SettingController@showDeactivateSettingForm')->name('settings.deactivate');
  Route::post('deactivate', 'SettingController@updateDeactivate');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
