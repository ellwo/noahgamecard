<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaountToRassedActevities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rassed_actevities', function (Blueprint $table) {
            //
            $table->double('camount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rassed_actevities', function (Blueprint $table) {
            //
            $table->dropColumn('camount');
        });
    }
}
