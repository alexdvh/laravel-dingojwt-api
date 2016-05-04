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
    $api->post('auth/login', 'App\Modules\Core\Auth\Controllers\Api\AuthController@authenticate');
    $api->post('auth/register', 'App\Modules\Core\Auth\Controllers\Api\AuthController@register');

    $api->get('auth/test', [
    		'uses' => 'App\Modules\Core\Auth\Controllers\Api\AuthController@test',
    		'as' => 'user.list',
    		'middleware' => ['acl:user.list'],
    	]);
});


/* Routes admin */
Route::group(array('middleware' => 'web', 'prefix' => 'admin', 'module' => 'Auth', 'namespace' => 'App\Modules\Core\Auth\Controllers\Admin'), function () {
	Route::any('/login', 'AuthController@login');
	Route::any('/logout', 'AuthController@logout');
});