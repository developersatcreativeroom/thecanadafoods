<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'product_attribute_id', 'quantity', 'price', 'old_price', 'sale_price', 'final_price',
        
        'name', 'short_description', 'description', 'sku', 'image', 'hover_image', 'product_type', 'affiliate_link', 'licence_name', 'licence_key', 'file_type', 'link', 'file', 'tax_id', 'tax_name', 'state_tax_name', 'state_tax', 'state_tax_amount', 'central_tax_name', 'central_tax', 'central_tax_amount', 'integrated_tax_name', 'integrated_tax', 'integrated_tax_amount', 'tax', 'tax_value', 'is_tax_included', 'brand_id', 'brand_name', 'color_id', 'color_name', 'vendor_id', 'group_id', 'is_featured', 'is_sample', 'is_sale', 'is_new', 'is_hot', 'is_best_sell', 'is_variant', 'min_quantity', 'length', 'width', 'height', 'weight', 'shipping_weight', 'attributes',
        
    ];

    public function services()
    {
        return $this->hasMany('App\Models\OrderProductService');
    }
    
    public function accounting()
    {
        return $this->hasMany('App\Models\ProductAccounting','product_id','product_id');
    }    
    
}
