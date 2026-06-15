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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->integer('rating');
            $table->string('review')->nullable();
            $table->boolean('is_approved')->default(0);
            $table->boolean('status')->nullable()->default(1);
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
        Schema::dropIfExists('ratings');
    }
};
