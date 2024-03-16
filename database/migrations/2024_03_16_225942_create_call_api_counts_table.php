<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallApiCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_api_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paymentinfo_id')->nullable()
            ->constrained('paymentinfos')->nullOnDelete();
            $table->foreignId('client_provider_id')->nullable()
            ->constrained('client_providers')->nullOnDelete();
            //
            $table->integer("count")->default(1);
            $table->text('info')->nullable();

           
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
        Schema::dropIfExists('call_api_counts');
    }
}
