<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirRoutesTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('air_routes_types', function (Blueprint $table) {
            $table->unsignedBigInteger('air_route');
            $table->unsignedBigInteger('aircraft_type');

            $table->timestamps();

            $table->primary(['air_route', 'aircraft_type']);
            $table->foreign('air_route')
                ->references('id')->on('air_routes')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('aircraft_type')
                ->references('id')->on('aircraft_types')
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
        Schema::dropIfExists('air_routes_types');
    }
}
