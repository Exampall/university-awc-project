<?php

use Illuminate\Database\Seeder;

class AircraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Aircraft::class, 56)->create();
    }
}
