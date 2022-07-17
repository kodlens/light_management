<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id('device_id');

            // $table->unsignedBigInteger('building_id');
            // $table->foreign('building_id')->references('building_id')->on('buildings');

            // $table->unsignedBigInteger('floor_id');
            // $table->foreign('floor_id')->references('floor_id')->on('floors');

            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('room_id')->on('rooms')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('device_name')->nullable();
            $table->string('device_ip')->nullable();
            $table->string('device_token_on')->nullable();
            $table->string('device_token_off')->nullable();
            $table->string('ntuser')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
