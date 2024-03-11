<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiKeysToClientProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_providers', function (Blueprint $table) {
            //

            $table->text('api_phone')->nullable();
            $table->text('api_username')->nullable();
            $table->text('api_password')->nullable();
            $table->integer('api_userid')->nullable();
            $table->text('api_payurl')->nullable();
            $table->text('api_checkurl')->nullable();
            $table->text('api_rassedurl')->nullable();
            $table->text('api_type')->default('YemenRopot');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_providers', function (Blueprint $table) {
            //
        });
    }
}
