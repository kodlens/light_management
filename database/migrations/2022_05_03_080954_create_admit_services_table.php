<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmitServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admit_services', function (Blueprint $table) {
            $table->id('admit_service_id');

            $table->unsignedBigInteger('admit_id');
            $table->foreign('admit_id')->references('admit_id')->on('admits')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('service_id')->on('services')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('tooth_id');
            $table->foreign('tooth_id')->references('tooth_id')->on('teeth')
                ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('admit_services');
    }
}
