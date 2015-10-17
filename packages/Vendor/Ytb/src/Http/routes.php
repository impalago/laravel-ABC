<?php

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['prefix' => 'ytb', 'namespace' => 'Vendor\Ytb\Http\Controllers'], function() {

    Route::get('/', ['as' => 'ytb.index', 'uses' => 'YtbController@getListVideo']);
    Route::get('/login', ['as' => 'ytb.index', 'uses' => 'YtbController@index']);
    Route::get('/callbackLogin', ['as' => 'ytb.callback', 'uses' => 'YtbController@callbackLogin']);

});