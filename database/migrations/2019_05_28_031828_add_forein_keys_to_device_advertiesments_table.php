<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeinKeysToDeviceAdvertiesmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_advertisements', function (Blueprint $table) {
            $table->foreign('device_id')->references('id')
                ->on('devices')->onDelete('cascade');
            $table->foreign('advertisement_id')->references('id')
                ->on('advertisements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_advertisements', function (Blueprint $table) {
            $table->dropForeign('device_id');
            $table->dropForeign('advertisement_id');
        });
    }
}
