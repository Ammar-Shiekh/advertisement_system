<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeinKeysToUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_devices', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreign('device_id')->references('id')
                ->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_devices', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('device_id');
        });
    }
}
