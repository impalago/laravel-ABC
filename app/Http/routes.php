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
Route::post('auth/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@authenticate']);
Route::get('auth/logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);

Route::group(['middleware' => 'auth'], function() {


    // Users
    Route::group(['prefix' => 'users', 'middleware' => 'acl:edit_users'], function() {
        // List users
        Route::get('', ['as' => 'users.index', 'uses' => 'Users\UsersController@index']);

        // Add user...
        Route::get('create', ['as' => 'users.create', 'uses' => 'Auth\AuthController@getRegister']);
        Route::post('create', 'Auth\AuthController@postRegister');

        // Edit user...
        Route::post('edit-status', ['as' => 'users.edit-status', 'uses' => 'Users\UsersController@editStatusAjax']);
        Route::get('edit/{id}', ['as' => 'users.edit', 'uses' => 'Users\UsersController@edit']);
        Route::post('edit/{id}', ['as' => 'users.edit-post', 'uses' => 'Users\UsersController@update']);
        Route::any('destroy', ['as' => 'users.destroy', 'uses' => 'Users\UsersController@destroy']);
    });


    Route::get('/', function () {
        return view('control-panel/dashboard.index');
    });

    // Access denied
    Route::get('401', ['as' => 'error.401', function() {
        return view('errors.access_denied');
    }]);

});
