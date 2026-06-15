<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('state_tax_name')->nullable();
            $table->decimal('state_tax', 8, 2)->nullable();
            $table->string('central_tax_name')->nullable();
            $table->decimal('central_tax', 8, 2)->nullable();
            $table->string('integrated_tax_name')->nullable();
            $table->decimal('integrated_tax', 8, 2)->nullable();
            $table->decimal('tax', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('taxes');
    }
};
