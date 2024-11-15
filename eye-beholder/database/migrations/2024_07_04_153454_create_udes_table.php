<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUdesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('udes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id');
            $table->foreign('class_id')->references('id')->on('ude_classes');
            $table->foreignId('interest_zone_id');
            $table->foreign('interest_zone_id')->references('id')->on('interest_zones');
            $table->string('name', 100);
            $table->string('mac_id', 100);
            $table->double('latitude', 8, 5);
            $table->double('longitude', 8, 5);
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
        Schema::dropIfExists('udes');
    }
}
