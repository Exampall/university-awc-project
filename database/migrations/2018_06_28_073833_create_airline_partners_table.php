<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirlinePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airline_partners', function (Blueprint $table) {
            $table->unsignedBigInteger('airline');
            $table->unsignedBigInteger('partner');

            $table->timestamps();

            $table->primary(['airline', 'partner']);
            $table->foreign('airline')
                ->references('id')->on('airline')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('partner')
                ->references('id')->on('airline')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement('ALTER TABLE airline_partners ADD CONSTRAINT chk_not_self_partner CHECK (airline != partner);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airline_partners');
    }
}
