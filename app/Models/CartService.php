<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProductService;

use App\Helper;

class CartService extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id', 'product_service_id'
    ];

    public function getPriceNumeric()
    {
        $currency = Helper::getCurrency();
        $productService = ProductService::find($this->product_service_id);
        return $productService->price;
    }
}
