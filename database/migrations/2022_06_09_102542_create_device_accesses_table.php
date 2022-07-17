<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_accesses', function (Blueprint $table) {
            $table->id('device_access_id');

            $table->unsignedBigInteger('device_id');
            $table->foreign('device_id')->references('device_id')->on('devices')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('group_role_id');
            $table->foreign('group_role_id')->references('group_role_id')->on('group_roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');


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
        Schema::dropIfExists('device_accesses');
    }
}
