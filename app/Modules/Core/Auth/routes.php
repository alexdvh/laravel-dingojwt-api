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

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {

    $api->group([
            'prefix' => 'auth',
            'namespace' => 'App\Modules\Core\Auth\Controllers\Api',
        ], function ($api) {

            $api->post('login', [
                    'uses' => 'AuthController@authenticate',
                    'as' => 'api.auth.login',
                ]);

            $api->post('register', [
                'uses' => 'AuthController@register',
                'as' => 'api.auth.register',
                ]);

            $api->get('logout', [
                'uses' => 'AuthController@logout',
                'as' => 'api.auth.logout',
                'middleware' => ['jwt.auth'],
            ]);
        }
    );
});


/* Routes admin */
Route::group([
    'middleware' => 'web', 
    'prefix' => 'admin', 
    'module' => 'Auth', 
    'namespace' => 'App\Modules\Core\Auth\Controllers\Admin',
], function () {

    Route::any('/login', [
        'uses' => 'AuthController@login',
        'as' => 'admin.auth.login',
    ]);

    Route::any('/register', [
        'uses' => 'AuthController@register',
        'as' => 'admin.auth.register',
    ]);

    Route::get('/logout', [
        'uses' => 'AuthController@logout',
        'as' => 'admin.auth.logout',
    ]);
});