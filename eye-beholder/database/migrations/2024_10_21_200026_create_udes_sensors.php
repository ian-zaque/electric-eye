<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUdesSensors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('udes_sensors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ude_id');
            $table->foreign('ude_id')->references('id')->on('udes');
            $table->foreignId('sensor_id');
            $table->foreign('sensor_id')->references('id')->on('sensors');
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
        Schema::dropIfExists('udes_sensors');
    }
}
