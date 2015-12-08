<?php

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
|
*/
Route::group(['prefix' => 'youtube', 'namespace' => 'Impalago\Ytb\Http\Controllers', 'middleware' => ['auth', 'acl:module_youtube']], function () {

    Route::get('/', ['as' => 'ytb.index', 'uses' => 'YoutubeController@index']);
    Route::get('/video/{id}', ['as' => 'ytb.video', 'uses' => 'YoutubeController@getVideo']);
    Route::get('/login', ['as' => 'ytb.login', 'uses' => 'YtbController@index']);
    Route::get('/logout', ['as' => 'ytb.logout', 'uses' => 'YtbController@logout']);
    Route::get('/callbackLogin', ['as' => 'ytb.callback', 'uses' => 'YtbController@callbackLogin']);

    Route::get('/channel/{id}', ['as' => 'ytb.channel', 'uses' => 'YoutubeController@getChannelPlaylist']);
    Route::get('/playlist/{id}', ['as' => 'ytb.playlist', 'uses' => 'YoutubeController@getVideoPlaylist']);
    Route::get('/load-subscriptions/{pageToken}', ['as' => 'ytb.load-subscriptions', 'uses' => 'YoutubeController@getSubscriptionsPage']);

});