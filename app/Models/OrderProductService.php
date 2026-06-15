<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductService extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_product_id', 'name', 'slug', 'image', 'summary', 'description', 'price', 'old_price'
    ];
}
