<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admits', function (Blueprint $table) {

            $table->id('admit_id');
            $table->unsignedBigInteger('appointment_id')->default(0);
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('user_id')->on('users')
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
        Schema::dropIfExists('admits');
    }
}
