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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect(route('control.index'));
    } else {
        return view('home-screen.index');
    }
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@authenticate']);
Route::get('auth/logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);

// Socialite Auth
Route::get('auth/{provider}', ['as' => 'auth.socialite', 'uses' => 'Auth\AuthController@redirectToProvider']);
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

Route::group(['prefix' => 'control', 'middleware' => 'auth'], function () {

    Route::get('/', ['as' => 'control.index', function () {
        return view('control-panel/dashboard.index');
    }]);

    /*
    |--------------------------------------------------------------------------
    | Errors
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'error'], function () {
        // 401 Access denied
        Route::get('401', ['as' => 'error.401', function () {
            return view('errors.401');
        }]);

        // Socialize. Mandatory authorization
        Route::get('auth', ['as' => 'error.auth', function () {
            return view('errors.auth');
        }]);
    });

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'users', 'middleware' => ['acl:edit_users']], function () {
        // List users
        Route::get('', ['as' => 'users.index', 'uses' => 'Users\UsersController@index']);

        // Add user...
        Route::get('create', ['as' => 'users.create', 'uses' => 'Auth\AuthController@getRegister']);
        Route::post('create', 'Auth\AuthController@postRegister');

        // Edit user...
        Route::post('edit-status', ['as' => 'users.edit-status', 'uses' => 'Users\UsersController@editStatusAjax']);
        Route::get('edit/{id}', ['as' => 'users.edit', 'uses' => 'Users\UsersController@edit']);
        Route::post('edit/{id}', ['as' => 'users.edit-post', 'uses' => 'Users\UsersController@update']);
        // Remove user
        Route::any('destroy', ['as' => 'users.destroy', 'uses' => 'Users\UsersController@destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'settings', 'middleware' => ['acl:edit_settings']], function () {
        Route::get('/', ['as' => 'settings.index', 'uses' => 'Settings\SettingsController@index']);

        // User roles
        Route::get('user-roles', ['as' => 'settings.user-roles', 'uses' => 'Settings\RolesController@editUserRoles']);
        // Create role
        Route::post('user-roles-create', ['as' => 'settings.user-roles-create', 'uses' => 'Settings\RolesController@roleCreate']);
        // Update role
        Route::post('user-roles-update/{id}', ['as' => 'settings.get-roles-update', 'uses' => 'Settings\RolesController@getRoleUpdate']);
        Route::post('user-roles-post-update/{id}', ['as' => 'settings.user-roles-update', 'uses' => 'Settings\RolesController@postRoleUpdate']);
        // Remove role
        Route::post('user-roles-destroy/{id}', ['as' => 'settings.user-roles-destroy', 'uses' => 'Settings\RolesController@roleDestroy']);

        // Permissions
        Route::get('permissions', ['as' => 'settings.permissions', 'uses' => 'Settings\PermissionsController@editPermissions']);
        // Create permission
        Route::post('permission-create', ['as' => 'settings.permission-create', 'uses' => 'Settings\PermissionsController@permissionCreate']);
        // Update permission
        Route::post('permission-update/{id}', ['as' => 'settings.get-permission-update', 'uses' => 'Settings\PermissionsController@getPermissionUpdate']);
        Route::post('permission-post-update/{id}', ['as' => 'settings.permission-update', 'uses' => 'Settings\PermissionsController@postPermissionUpdate']);
        // Remove permission
        Route::post('permission-destroy/{id}', ['as' => 'settings.permission-destroy', 'uses' => 'Settings\PermissionsController@permissionDestroy']);

    });

    /*
    |--------------------------------------------------------------------------
    | Facebook
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'facebook', 'middleware' => ['acl:module_facebook']], function () {
        Route::get('', ['as' => 'facebook.index', 'uses' => 'Facebook\FacebookController@index']);
        Route::get('/login', ['as' => 'facebook.login', 'uses' => 'Facebook\FacebookLoginController@login']);
        Route::get('/callback', ['as' => 'facebook.callback', 'uses' => 'Facebook\FacebookLoginController@callback']);
        Route::get('/logout', ['as' => 'facebook.logout', 'uses' => 'Facebook\FacebookLoginController@logout']);

        Route::get('/page/{id}', ['as' => 'fb.page', 'uses' => 'Facebook\FacebookController@getPage']);

        Route::post('/page/create-post', ['as' => 'fb.create-post-page', 'uses' => 'Facebook\FacebookController@createPostPage']);
        Route::get('/page/delete-post/{id}/{page_token}', ['as' => 'fb.delete-post-page', 'uses' => 'Facebook\FacebookController@deletePostPage']);
    });


    /*
    |--------------------------------------------------------------------------
    | Google Auth for Api
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'google'], function () {

        Route::get('', ['as' => 'google.index', 'uses' => 'Google\GoogleController@index']);
        Route::get('/login', ['as' => 'google.login', 'uses' => 'Google\GoogleLoginController@login']);
        Route::get('/logout', ['as' => 'google.logout', 'uses' => 'Google\GoogleLoginController@logout']);
        Route::get('/callback', ['as' => 'google.callback', 'uses' => 'Google\GoogleLoginController@callback']);

        /*
        |--------------------------------------------------------------------------
        | Google Analytics
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix' => 'analytics', 'middleware' => ['google', 'acl:module_google_analytics']], function () {
            Route::get('', ['as' => 'ga.index', 'uses' => 'Google\GoogleAnalyticsController@index']);
            Route::get('account/{id}', ['as' => 'ga.account', 'uses' => 'Google\GoogleAnalyticsController@getAccount']);
            Route::get('account/{id}/webproperties/{idProperty}', ['as' => 'ga.property', 'uses' => 'Google\GoogleAnalyticsController@getWebProperty']);
            Route::any('account/statistic/{id}', ['as' => 'ga.statistic', 'uses' => 'Google\GoogleAnalyticsController@getStatistic']);
        });
    });

});
