<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
            ->nullable()->constrained('products')
            ->nullOnDelete();
            $table->foreignId('client_provider_id')
            ->nullable()->constrained('client_providers')
            ->nullOnDelete();
            $table->text('name')->nullable();
            $table->text('url')->nullable();
            $table->double('price')->default(0);
            $table->integer('active')->default(0);
            $table->json('reqs')->nullable();
            

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
        Schema::dropIfExists('provider_products');
    }
}
