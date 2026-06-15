<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLogProduct extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'product_attribute_id', 'quantity', 'product_price'];

    public function product()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public function attribute()
    {
        return $this->hasOne('App\Models\ProductAttribute','id','product_attribute_id');
    }
    
}
