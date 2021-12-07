<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkToggle extends Migration
{
    public function up()
    {
        Schema::create('work_toggles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->dateTime('date_time');
        });
    }

    public function down()
    {
        Schema::dropIfExists('work_toggles');
    }
}
