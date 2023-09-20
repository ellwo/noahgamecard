<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderDepartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_department', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->nullable()
            ->constrained('departments')->nullOnDelete();
            $table->foreignId('client_provider_id')->nullable()
            ->constrained('client_providers')->nullOnDelete();
            $table->integer('active')->default(0);
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
        Schema::dropIfExists('provider_department');
    }
}
