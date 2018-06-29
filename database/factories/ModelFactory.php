<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

// ------------------------------------------------------------------------
// AIRCRAFTS

$factory->define(App\Aircraft::class, function (Faker\Generator $faker) {
    $wingspan = $faker->numberBetween(80, 340);
    return [
        'type' => App\AircraftType::inRandomOrder()->first()->id,
        'seats' => $faker->numberBetween(10, 450),
        'max_speed' => $faker->numberBetween(140, 1230),
        'wingspan' => $wingspan,
        'radius' => floor($wingspan / 2),
        'engine_type' => $faker->randomElement(['D', 'B']),
        'airline' => App\Airline::inRandomOrder()->first()->id,
    ];
});

// ------------------------------------------------------------------------
// AIRLINE

$factory->define(App\Airline::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->company,
        'nationality' => App\Country::inRandomOrder()->first()->id,
        'share_price' => $faker->numberBetween(-2000, 2000),
    ];
});

// ------------------------------------------------------------------------
// AIRPORT

$factory->define(App\Airport::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->city,
        'country' => App\Country::inRandomOrder()->first()->id,
    ];
});

// ------------------------------------------------------------------------
// COUNTRY

$factory->define(App\Country::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->country,
    ];
});

// ------------------------------------------------------------------------
// AIRROUTE

$factory->define(App\AirRoute::class, function (Faker\Generator $faker) {
    $airport_departure = App\Airport::inRandomOrder()->first()->id;
    $airport_arrival = App\Airport::inRandomOrder()->first()->id;
    while ($airport_arrival == $airport_departure) {
        $airport_arrival = App\Airport::inRandomOrder()->first()->id;
    }

    return [
        'type' => $faker->randomElement(['I', 'N']),
        'airport_departure' => $airport_departure,
        'airport_arrival' => $airport_arrival,
        'max_slot_reservations' => $faker->numberBetween(1, 15),
    ];
});

// ------------------------------------------------------------------------
// AIRROUTE SLOT

$factory->define(App\AirRouteSlot::class, function (Faker\Generator $faker) {
    return [
        'day' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7]),
        'schedule' => $faker->unique()->time('H:i'),
    ];
});