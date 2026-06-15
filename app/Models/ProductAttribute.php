<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id', 'price', 'old_price', 'sku', 'image', 'stock', 'min_quantity', 'threshold', 'total_sales', 'length', 'width', 'height', 'weight'
    ];

    public function details()
    {
        return $this->hasMany('App\Models\ProductAttributeDetail');
    }
}
