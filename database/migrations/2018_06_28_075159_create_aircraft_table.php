<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAircraftTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('aircraft', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('type');
            $table->unsignedInteger('seats');
            $table->unsignedInteger('max_speed');
            $table->unsignedInteger('wingspan');
            $table->unsignedInteger('radius');
            $table->char('engine_type', 1);

            $table->timestamps();

            $table->foreign('type')
                ->references('id')->on('aircraft_types')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement('ALTER TABLE aircraft ADD CONSTRAINT chk_engine_type CHECK (engine_type = \'D\' OR engine_type = \'B\');');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('aircraft');
    }
}
