<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirlineReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airline_reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('airline');
            $table->unsignedBigInteger('slot');

            $table->timestamps();

            $table->primary(['airline', 'slot']);
            $table->foreign('airline')
                ->references('id')->on('airline')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('slot')
                ->references('id')->on('air_routes_slot')
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
        Schema::dropIfExists('airline_reservations');
    }
}
