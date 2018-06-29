<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // create aircraft types
        DB::table('aircraft_types')->insert(
            [
                'name' => 'airliner',
                'code' => 'AL',
            ]
        );
        DB::table('aircraft_types')->insert(
            [
                'name' => 'last minute airliner',
                'code' => 'LM',
            ]
        );
        DB::table('aircraft_types')->insert(
            [
                'name' => 'second-class airliner',
                'code' => 'SC',
            ]
        );
        DB::table('aircraft_types')->insert(
            [
                'name' => 'historical airliner',
                'code' => 'HA',
            ]
        );

        // call seeders
        $this->call('CountrySeeder');
        $this->call('AirportSeeder');
        $this->call('AirlineSeeder');
        $this->call('AircraftSeeder');
        $this->call('AirRouteSeeder');
    }
}
