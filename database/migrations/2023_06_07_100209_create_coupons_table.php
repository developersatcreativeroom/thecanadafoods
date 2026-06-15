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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->text('type')->comment('single or multiple');
            $table->string('image')->nullable();
            $table->integer('no_of_times')->nullable()->comment('if multiple');
            $table->enum('amount_type', ['percentage', 'numeric']);
            $table->integer('amount_value');
            $table->text('applicable_on_products')->nullable()->comment('product IDs on which coupon applies');
            $table->integer('min_quantity')->nullable();
            $table->integer('min_price')->nullable();
            $table->bigInteger('vendor_id')->nullable()->unsigned()->comment('In case of multi-vendor');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');
            $table->string('valid_from')->nullable();
            $table->string('valid_to')->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('coupons');
    }
};
