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
    // fixme: aio???
    $router->post('student/login', 'StudentAuthController@login');
    $router->post('student/signup', 'StudentAuthController@signup');

    $router->post('teacher/login', 'TeacherAuthController@login');
    $router->post('teacher/signup', 'TeacherAuthController@signup');

    Route::group([
        'middleware' => 'auth:student'
    ], function (Router $router) {
        $router->get('student/logout', 'StudentAuthController@logout');
    });

    Route::group([
        'middleware' => 'auth:teacher'
    ], function (Router $router) {
        $router->get('teacher/logout', 'TeacherAuthController@logout');
    });
});

Route::group([
    'middleware' => 'auth:student',
    'prefix' => 'student'
], function (Router $router) {
    $router->get('profile', 'StudentController@profile');
    $router->post('follow/{teacher}', 'StudentController@follow');
    $router->delete('unlink/{binding}', 'StudentController@unlink');
});

Route::group([
    'middleware' => 'auth:teacher',
    'prefix' => 'teacher'
], function (Router $router) {
    $router->get('profile', 'TeacherController@profile');
    $router->delete('unlink/{binding}', 'TeacherController@unlink');
});
