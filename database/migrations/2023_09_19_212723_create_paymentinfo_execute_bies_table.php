<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentinfoExecuteBiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentinfo_execute_bies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paymentinfo_id')->nullable()
            ->constrained('paymentinfos')->nullOnDelete();
            $table->morphs('execute');
            $table->integer('state');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paymentinfo_execute_bies');
    }
}
