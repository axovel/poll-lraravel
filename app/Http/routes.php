<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['uses' => 'IndexController@index', 'as' => 'index']);

Route::get('admin', 'AdminController@getLogin');

Route::group(['middleware'=> 'auth.admin','prefix' => 'admin'], function () {

    Route::post('login', 'AdminController@postLogin');

    Route::group(['middleware' => 'auth'], function () {

        Route::resource('user', 'UsersController');
        Route::resource('poll-category', 'PollCategoriesController');
    });
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('dashboard', ['uses' => 'AdminController@getDashboard', 'as' => 'admin.dashboard']);
        Route::resource('poll', 'PollsController', ['except' => 'postCastVote']);
        Route::post('create-poll', ['uses' => 'RssFeedDataController@createPoll', 'as' => 'create-poll']);
        Route::resource('rss-feed-url', 'RssFeedUrlsController');
        Route::resource('rss-feed-data', 'RssFeedDataController');
        Route::resource('ad', 'AdController');
        Route::resource('poll-comments', 'PollCommentsController');
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::post('login', 'UsersController@postLogin');
    Route::get('dashboard', ['uses' => 'UsersController@getDashboard', 'as' => 'user.dashboard'])->middleware('auth');

//    Route::group(['middleware' => 'auth'], function () {
//        Route::resource('rss-feed-url', 'RssFeedUrlsController');
//        Route::resource('rss-feed-data', 'RssFeedDataController');
//        Route::resource('poll', 'PollsController', ['except' => 'postCastVote']);
//    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('comment', 'PollCommentsController');
    Route::post('upload-image', 'ImageProcessingController@postUploadAdImage');
    Route::get('auth/reset-password', ['uses' => 'UsersController@getResetPassword', 'as' => 'reset-password']);
    Route::post('auth/reset-password', ['uses' => 'UsersController@postResetPassword', 'as' => 'reset-password']);
});

Route::auth();

Route::post('cast-vote/{id}', ['uses'=>'PollsController@postCastVote', 'as' => 'poll.cast-vote']);
Route::get('check-json/{id}', ['uses'=>'IndexController@jsonCheck', 'as' => 'check-json']);
Route::get('auth/redirect/{provider}', ['uses' => 'Auth\AuthController@redirectToProvider', 'as' => 'social.login.redirect']);
Route::get('auth/{provider}', ['uses' => 'Auth\AuthController@handleProviderCallback', 'as' => 'social.login.callback']);
Route::get('register/verify/{code}', ['uses' => 'Auth\AuthController@confirm', 'as' => 'confirm.account']);
Route::get('add-display-count/{adId}', ['uses' => 'AdController@addDisplayHistory', 'as' => 'ad-display-count']);
Route::get('add-impression-count/{adId}', ['uses' => 'AdController@adVisitorHistory', 'as' => 'ad-impression-count']);

Route::get('{slug}', 'IndexController@getDetailPage');
