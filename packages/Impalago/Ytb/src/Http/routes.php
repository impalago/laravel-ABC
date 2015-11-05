<?php

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
|
*/
Route::group(['prefix' => 'ytb', 'namespace' => 'Impalago\Ytb\Http\Controllers', 'middleware' => 'auth'], function () {

    Route::get('/', ['as' => 'ytb.index', 'uses' => 'YoutubeController@index']);
    Route::get('/video/{id}', ['as' => 'ytb.video', 'uses' => 'YoutubeController@getVideo']);
    Route::get('/login', ['as' => 'ytb.login', 'uses' => 'YtbController@index']);
    Route::get('/logout', ['as' => 'ytb.logout', 'uses' => 'YtbController@logout']);
    Route::get('/callbackLogin', ['as' => 'ytb.callback', 'uses' => 'YtbController@callbackLogin']);

});