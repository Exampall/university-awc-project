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

$router->group(['prefix' => App\Models\Airport::$path], function () use ($router) {
    $router->get('/', 'AirportController@getAll');
    $router->get('/{id}', 'AirportController@getOne');
    $router->post('/', 'AirportController@postOne');
    $router->delete('/{id}', 'AirportController@deleteOne');
    $router->put('/{id}', 'AirportController@putOne');
    $router->patch('/{id}', 'AirportController@patchOne');
});

$router->group(['prefix' => App\Models\Airline::$path], function () use ($router) {
    $router->get('/', 'AirlineController@getAll');
    $router->get('/{id}', 'AirlineController@getOne');
    $router->post('/', 'AirlineController@postOne');
    $router->delete('/{id}', 'AirlineController@deleteOne');
    $router->put('/{id}', 'AirlineController@putOne');
    $router->patch('/{id}', 'AirlineController@patchOne');
    $router->group(['prefix' => '{airline}/partner'], function () use ($router) {
        $router->get('/', 'AirlineController@getPartners');
        $router->post('/', 'AirlineController@postPartner');
        $router->delete('/{id}', 'AirlineController@deletePartner');
    });
});

$router->group(['prefix' => 'aircraft'], function () use ($router) {
    $router->get('/', 'AircraftController@getAll');
    $router->get('/{id}', 'AircraftController@getOne');
    $router->post('/', 'AircraftController@postOne');
    $router->delete('/{id}', 'AircraftController@deleteOne');
    $router->put('/{id}', 'AircraftController@putOne');
    $router->patch('/{id}', 'AircraftController@patchOne');
});

$router->group(['prefix' => App\Models\AirRoute::$path], function () use ($router) {
    $router->get('/', 'AirRouteController@getAll');
    $router->get('/{id}', 'AirRouteController@getOne');
    $router->post('/', 'AirRouteController@postOne');
    $router->delete('/{id}', 'AirRouteController@deleteOne');
    $router->put('/{id}', 'AirRouteController@putOne');
    $router->patch('/{id}', 'AirRouteController@patchOne');
    $router->group(['prefix' => '{airRoute}/' . App\Models\AircraftType::$path], function () use ($router) {
        $router->get('/', 'AirRouteController@getAircraftTypes');
        $router->post('/', 'AirRouteController@postAircraftType');
        $router->delete('/{id}', 'AirRouteController@deleteAircraftType');
    });
});
$router->group(['prefix' => App\Models\AirRouteSlot::$path], function () use ($router) {
    $router->get('/', 'AirRouteSlotController@getAll');
    $router->get('/{id}', 'AirRouteSlotController@getOne');
    $router->post('/', 'AirRouteSlotController@postOne');
    $router->put('/{id}', 'AirRouteSlotController@putOne');
    $router->patch('/{id}', 'AirRouteSlotController@patchOne');
    $router->delete('/{id}', 'AirRouteSlotController@deleteOne');
});

$router->group(['prefix' => App\Models\AircraftType::$path], function () use ($router) {
    $router->get('/', 'AircraftTypeController@getAll');
    $router->get('/{id}', 'AircraftTypeController@getOne');
    $router->group(['prefix' => '{aircraftType}/' . App\Models\AirRoute::$path], function () use ($router) {
        $router->get('/', 'AircraftTypeController@getAirRoutes');
    });
});