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

$router->group(['prefix' => 'country'], function () use ($router) {
    $router->get('/', 'CountryController@getAll');
    $router->get('/{id}', 'CountryController@getOne');
});

$router->group(['prefix' => 'airport'], function () use ($router) {
    $router->get('/', 'AirportController@getAll');
    $router->get('/{id}', 'AirportController@getOne');
});

$router->group(['prefix' => App\Models\Airline::$path], function () use ($router) {
    $router->get('/', 'AirlineController@getAll');
    $router->get('/{id}', 'AirlineController@getOne');
});

$router->group(['prefix' => 'aircraft'], function () use ($router) {
    $router->get('/', 'AircraftController@getAll');
    $router->get('/{id}', 'AircraftController@getOne');
});

$router->group(['prefix' => 'air-route'], function () use ($router) {
    $router->get('/', 'AirRouteController@getAll');
    $router->get('/{id}', 'AirRouteController@getOne');
});