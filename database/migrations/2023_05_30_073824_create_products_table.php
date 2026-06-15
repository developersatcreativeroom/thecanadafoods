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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('title_h1')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('sku')->nullable();
            $table->string('image')->nullable();
            $table->string('hover_image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('product_type')->nullable()->comment('physical,digital,license,affiliate');
            $table->text('affiliate_link')->nullable()->comment('In case of affiliate product');
            $table->string('licence_name')->nullable()->comment('In case of licence product');
            $table->text('licence_key')->nullable()->comment('In case of licence product');
            $table->string('file_type')->nullable()->comment('In case of digital product');
            $table->text('link')->nullable()->comment('In case of digital product');
            $table->text('file')->nullable()->comment('In case of digital product');
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('old_price', 8, 2)->nullable();
            $table->bigInteger('tax_id')->nullable()->unsigned();
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('set null');
            $table->boolean('is_tax_included')->nullable()->default(0);
            $table->bigInteger('brand_id')->nullable()->unsigned();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->bigInteger('color_id')->nullable()->unsigned();
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('set null');
            $table->bigInteger('vendor_id')->nullable()->unsigned()->comment('In case of multi-vendor');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');
            $table->integer('group_id')->nullable();
            $table->boolean('is_featured')->nullable()->default(0);
            $table->boolean('is_sample')->nullable()->default(0);
            $table->boolean('is_sale')->nullable()->default(0);
            $table->boolean('is_new')->nullable()->default(0);
            $table->boolean('is_hot')->nullable()->default(0);
            $table->boolean('is_best_sell')->nullable()->default(0);
            $table->boolean('is_variant')->nullable()->default(0);
            $table->integer('stock')->nullable()->default(0);
            $table->integer('min_quantity')->nullable()->default(1);
            $table->integer('threshold')->nullable();
            $table->integer('total_sales')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('shipping_weight')->nullable();
            $table->text('tags')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->boolean('is_imported')->default(0);
            $table->text('purchase_note')->nullable();
            $table->float('average_rating', 8, 2)->nullable();
            $table->string('review_count')->nullable();
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
        Schema::dropIfExists('products');
    }
};
