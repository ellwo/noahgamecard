<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoinIdToRassedActevities extends Migration
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
            $table->foreignId('coin_id')->nullable()->constrained('coins')->nullOnDelete();
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
            $table->dropConstrainedForeignId('coin_id');
        });
    }
}
