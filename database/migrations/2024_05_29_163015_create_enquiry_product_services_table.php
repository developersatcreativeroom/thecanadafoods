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
        Schema::create('enquiry_product_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('enquiry_product_id')->nullable()->unsigned();
            $table->foreign('enquiry_product_id')->references('id')->on('enquiry_products')->onDelete('set null');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('old_price', 8, 2)->nullable();
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
        Schema::dropIfExists('enquiry_product_services');
    }
};
