<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('service_id')->on('services')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('qr_code')->nullable();
            $table->date('appoint_date')->nullable();
            $table->time('appoint_time')->nullable();
            $table->unsignedBigInteger('dentist_id');
            $table->foreign('dentist_id')->references('user_id')->on('users');
            $table->tinyInteger('appoint_status')->default(0);
            $table->tinyInteger('is_notify')->default(0);
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
        Schema::dropIfExists('appointments');
    }
}
