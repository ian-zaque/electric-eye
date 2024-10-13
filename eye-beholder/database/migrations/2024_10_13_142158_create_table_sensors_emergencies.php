<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSensorsEmergencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensors_emergencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id');
            $table->foreign('sensor_id')->references('id')->on('sensors');
            $table->foreignId('emergency_id');
            $table->foreign('emergency_id')->references('id')->on('emergencies');
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
        Schema::dropIfExists('sensors_emergencies');
    }
}
