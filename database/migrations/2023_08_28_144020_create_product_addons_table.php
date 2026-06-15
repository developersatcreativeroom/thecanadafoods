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
        Schema::create('product_addons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('old_price', 8, 2)->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('product_addons');
    }
};
