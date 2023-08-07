<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReqsToDepartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            //

            /**
             *
             * default = [
             *     0=>[
             *      "label"=>"name",
             *       "type"=>"text",
             *      "req"=>false,true,
             *      ]
             * ]
             *
             */
            $table->json('reqs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            //
            $table->dropColumn('reqs');
        });
    }
}
