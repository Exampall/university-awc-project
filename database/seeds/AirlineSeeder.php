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
        $airlines = factory(App\Models\Airline::class, 8)->create();

        foreach ($airlines as $airline) {
            $partners = App\Models\Airline::where('id', '<>', $airline->id)->inRandomOrder()->limit(rand(0, 2))->get();
            foreach ($partners as $partner) {
                $airline->partners()->attach(['partner' => $partner->id]);
            }
        }
    }
}
