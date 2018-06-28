<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirlineTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('airline', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('nationality');
            $table->integer('share_price');

            $table->timestamps();

            $table->foreign('nationality')
                ->references('id')->on('country')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('airline');
    }
}
