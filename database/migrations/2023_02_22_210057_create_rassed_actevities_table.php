<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRassedActevitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rassed_actevities', function (Blueprint $table) {
            $table->id();
            $table->foreignId("rassed_id")->nullable()->constrained('rasseds')->nullOnDelete();
            $table->text('code');
            $table->float('amount');
            $table->foreignId('paymentinfo_id')->nullable()->constrained('paymentinfos')->nullOnDelete();

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
        Schema::dropIfExists('rassed_actevities');
    }
}
