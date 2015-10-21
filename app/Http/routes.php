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

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);

Route::group(['middleware' => 'auth'], function() {


    // Users
    Route::get('users', ['as' => 'users.index', 'uses' => 'Users\UsersController@index']);

    // Add user...
    Route::get('users/create', ['as' => 'users.create', 'uses' => 'Auth\AuthController@getRegister']);
    Route::post('users/create', 'Auth\AuthController@postRegister');

    // Edit user...
    Route::post('users/edit-status', ['as' => 'users.edit-status', 'uses' => 'Users\UsersController@editStatusAjax']);
    Route::any('users/destroy', ['as' => 'users.destroy', 'uses' => 'Users\UsersController@destroy']);

    Route::get('/', function () {
        return view('control-panel/dashboard.index');
    });

});
