<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirRoutesSlotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('air_routes_slot', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('air_route');
            $table->enum('day', [1, 2, 3, 4, 5, 6, 7]);
            $table->time('schedule');
            $table->unsignedInteger('max_reservations');
            
            $table->timestamps();

            $table->foreign('air_route')
                ->references('id')->on('air_routes')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('air_routes_slot');
    }
}
