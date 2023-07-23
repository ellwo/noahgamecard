<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiviceIdToFTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('firebase_tokens', function (Blueprint $table) {
            //
            $table->text('device_id')->nullable();
            $table->text('device_name')->nullable();
            $table->text('device_ip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('firebase_tokens', function (Blueprint $table) {
            //
            $table->dropColumn('device_id');
            $table->dropColumn('device_name');
            $table->dropColumn('device_ip');
        });
    }
}
