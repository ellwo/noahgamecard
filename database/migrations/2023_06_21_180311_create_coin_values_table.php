
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_values', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_coin_id')->nullable();
            $table->bigInteger('to_coin_id')->nullable();
            $table->double('value')->default(0.0);
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
        Schema::dropIfExists('coin_values');
    }
}
