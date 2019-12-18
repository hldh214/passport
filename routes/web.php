<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Routing\Router;

Route::group([
    'prefix' => 'oauth'
], function (Router $router) {
    $router->get('line', 'LineAuthController@redirectToProvider');
    $router->get('line/callback', 'LineAuthController@handleProviderCallback');
});

Route::get('/{vue}', 'SPAController@index')->where('vue', '.*');
