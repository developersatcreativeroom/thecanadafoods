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
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable()->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('event')->comment('sold, added, update etc');
            $table->integer('type')->comment('1=added, 2=subtracted etc');
            $table->text('remarks')->comment('For user timeline')->nullable();
            $table->integer('user_level')->comment('0=admin, 1=front user');
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
        Schema::dropIfExists('inventory_logs');
    }
};
