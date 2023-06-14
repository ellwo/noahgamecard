<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPaymentInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paymentinfos', function (Blueprint $table) {
            //
            $table->double('orginal_total')->default(0.0);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
          //  $table->
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paymentinfos', function (Blueprint $table) {
            //
        });
    }
}
