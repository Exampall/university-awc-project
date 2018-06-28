<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('air_routes', function (Blueprint $table) {
            $table->increments('id');
            $table->char('type', 1);
            $table->unsignedBigInteger('airport_departure');
            $table->unsignedBigInteger('airport_arrival');
            $table->unsignedInteger('max_slot_reservations');

            $table->timestamps();

            $table->foreign('airport_departure')
                ->references('id')->on('airport')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('airport_arrival')
                ->references('id')->on('airport')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement('ALTER TABLE air_routes ADD CONSTRAINT chk_type CHECK (type = \'I\' OR type = \'N\');');
        DB::statement('ALTER TABLE air_routes ADD CONSTRAINT chk_not_same_airport CHECK (airport_departure != airport_arrival);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('air_routes');
    }
}
