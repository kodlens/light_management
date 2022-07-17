<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('room_id');

            $table->unsignedBigInteger('building_id');
            $table->foreign('building_id')->references('building_id')->on('buildings')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('floor_id');
            $table->foreign('floor_id')->references('floor_id')->on('floors')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('room')->nullable();
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
        Schema::dropIfExists('rooms');
    }
}
