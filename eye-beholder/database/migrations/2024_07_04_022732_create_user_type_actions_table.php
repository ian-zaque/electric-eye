<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTypeActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_role_id');
            $table->foreign('user_role_id')->references('id')->on('user_roles');
            $table->string('action', 100);
            $table->string('model', 100);
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
        Schema::dropIfExists('user_role_actions');
    }
}
