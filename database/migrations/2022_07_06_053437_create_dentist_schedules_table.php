<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDentistSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dentist_schedules', function (Blueprint $table) {
            $table->id('dentist_schedule_id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->time('from')->nullable();
            $table->time('to')->nullable();

            $table->tinyInteger('mon')->default(0);
            $table->tinyInteger('tue')->default(0);
            $table->tinyInteger('wed')->default(0);
            $table->tinyInteger('thur')->default(0);
            $table->tinyInteger('fri')->default(0);
            $table->tinyInteger('sat')->default(0);
            $table->tinyInteger('sun')->default(0);
            

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
        Schema::dropIfExists('dentist_schedules');
    }
}
