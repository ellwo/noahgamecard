<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDispatchAtToProviderProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_products', function (Blueprint $table) {
            //
            $table->text('dispatch_at')->default('now');
            $table->text('dispatch_on')->default('default');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_products', function (Blueprint $table) {
            //
            $table->dropColumn('dispatch_at');
            $table->dropColumn('dispatch_on');
        });
    }
}
