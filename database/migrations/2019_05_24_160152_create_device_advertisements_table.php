<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_advertisements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('duration')->default(5);
            $table->timestamps();
            $table->integer('device_id')->unsigned();
            $table->integer('advertisement_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_advertisements');
    }
}
