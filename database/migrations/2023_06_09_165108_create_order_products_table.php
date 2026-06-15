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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable()->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->bigInteger('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->bigInteger('product_attribute_id')->nullable()->unsigned();
            $table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('set null');

            $table->integer('quantity');
            
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('old_price', 8, 2)->nullable();
            $table->decimal('sale_price', 8, 2)->nullable();
            $table->decimal('final_price', 8, 2)->nullable();

            $table->bigInteger('tax_id')->nullable();
            $table->string('tax_name')->nullable();
            $table->string('state_tax_name')->nullable();
            $table->decimal('state_tax', 8, 2)->nullable();
            $table->decimal('state_tax_amount', 8, 2)->nullable();
            $table->string('central_tax_name')->nullable();
            $table->decimal('central_tax', 8, 2)->nullable();
            $table->decimal('central_tax_amount', 8, 2)->nullable();
            $table->string('integrated_tax_name')->nullable();
            $table->decimal('integrated_tax', 8, 2)->nullable();
            $table->decimal('integrated_tax_amount', 8, 2)->nullable();
            $table->decimal('tax', 8, 2)->nullable();
            
            $table->string('tax_value')->nullable();
            $table->boolean('is_tax_included')->nullable()->default(0);
            
            $table->string('name')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('sku')->nullable();
            $table->string('image')->nullable();
            $table->string('hover_image')->nullable();
            $table->string('product_type')->nullable();
            $table->string('affiliate_link')->nullable();
            $table->string('licence_name')->nullable();
            $table->string('licence_key')->nullable();
            $table->string('file_type')->nullable();
            $table->string('link')->nullable();
            $table->string('file')->nullable();
            
            $table->bigInteger('brand_id')->nullable();
            $table->string('brand_name')->nullable();
            $table->bigInteger('color_id')->nullable();
            $table->string('color_name')->nullable();
            $table->bigInteger('vendor_id')->nullable()->unsigned()->comment('In case of multi-vendor');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');
            $table->bigInteger('group_id')->nullable();
            $table->boolean('is_featured')->nullable();
            $table->boolean('is_sample')->nullable();
            $table->boolean('is_sale')->nullable();
            $table->boolean('is_new')->nullable();
            $table->boolean('is_hot')->nullable();
            $table->boolean('is_best_sell')->nullable();
            $table->boolean('is_variant')->nullable();
            $table->string('min_quantity')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->text('attributes')->nullable();



            // $table->integer('quantity');
            // $table->decimal('price', 8, 2)->nullable();
            // $table->decimal('old_price', 8, 2)->nullable();
            // $table->string('sku')->nullable();
            // $table->string('image')->nullable();
            // $table->integer('min_quantity')->nullable()->default(1);
            // $table->string('length')->nullable();
            // $table->string('width')->nullable();
            // $table->string('height')->nullable();
            // $table->string('weight')->nullable();
            
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
        Schema::dropIfExists('order_products');
    }
};
