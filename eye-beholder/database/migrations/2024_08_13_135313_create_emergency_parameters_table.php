<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emergency_id');
            $table->foreign('emergency_id')->references('id')->on('emergencies');
            $table->string('name', 100);
            $table->double('value', 8, 2);
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergency_parameters');
    }
}
