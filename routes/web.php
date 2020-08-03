<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return view('app');
});
$router->group(['prefix' => 'api'], function() use ($router) {
    $router->get('category', [
        'uses' => 'Api\CategoryController@index',
    ]);
    $router->post('category', [
        'uses' => 'Api\CategoryController@store',
    ]);
    $router->put('category/{id}', [
        'uses' => 'Api\CategoryController@update',
    ]);
    $router->delete('category/{id}', [
        'uses' => 'Api\CategoryController@delete',
    ]);
    $router->get('category/{id}', [
        'uses' => 'Api\CategoryController@show',
    ]);
});
