<?php

use Illuminate\Database\Seeder;

class AirlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Airline::class, 8)->create();
    }
}
