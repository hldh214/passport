<?php

use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function (Router $router) {
    $router->post('student/login', 'StudentAuthController@login');
    $router->post('student/signup', 'StudentAuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function (Router $router) {
        $router->get('student/logout', 'StudentAuthController@logout');
    });
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'student'
], function (Router $router) {
    $router->get('profile', 'StudentController@profile');
});
