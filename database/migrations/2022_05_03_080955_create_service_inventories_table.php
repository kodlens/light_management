<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_inventories', function (Blueprint $table) {
            $table->id('service_inventory_id');

            $table->unsignedBigInteger('admit_service_id');
            $table->foreign('admit_service_id')->references('admit_service_id')->on('admit_services')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('item_id')->on('items')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('tooth_id')->default(0);
            $table->double('use_qty')->default(0);
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('service_inventories');
    }
}
