<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

// When no router matches
$router->addRoute(['GET','POST', 'PUT', 'PATCH', 'DELETE','OPTIONS'], '', 'Controller@badRequest');

$router->group(['prefix' => ''], function () use ($router) {

    $controller = 'MyModelController@whateverMethod';

    $router->get('/{route:.*}/', $controller);
    $router->post('/{route:.*}/', $controller);
    $router->put('/{route:.*}/', $controller);
    $router->patch('/{route:.*}/', $controller);
    $router->delete('/{route:.*}/', $controller);

});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

    $router->post('refresh', [
        'middleware' => 'auth',
        'uses' => 'AuthController@refresh'
    ]);
});

