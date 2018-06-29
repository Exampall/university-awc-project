<?php

use Illuminate\Database\Seeder;

class AirRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $airRoutes = factory(App\Models\AirRoute::class, 42)->create();

        foreach ($airRoutes as  $airRoute) {
            factory(App\Models\AirRouteSlot::class, rand(1, 15))->create([
                'air_route' => $airRoute->id
            ]);

            $numberOfAircraftTypes = rand(1, 4);
            $aircraftTypes = App\Models\AircraftType::limit($numberOfAircraftTypes)->get();
            foreach ($aircraftTypes as $aircraftType) {
                $airRoute->aircraftTypes()->attach(['aircraft_type' => $aircraftType->id]);
            }
        }
    }
}
