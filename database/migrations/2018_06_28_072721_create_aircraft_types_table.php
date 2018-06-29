<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAircraftTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aircraft_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->char('code', 2);

            $table->timestamps();

            $table->unique('code');
        });

        DB::statement('ALTER TABLE aircraft_types ADD CONSTRAINT chk_valid_type_code CHECK (code IN (\'AL\', \'LM\', \'SC\', \'HA\'));');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aircraft_types');
    }
}
