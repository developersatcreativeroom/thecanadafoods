<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Helper;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';

    protected $fillable = [
        'product_id', 'product_attribute_id', 'user_id', 'uuid', 'quantity'
    ];

    public function attribute()
    {
        return $this->hasOne('App\Models\ProductAttribute','id','product_attribute_id');
    }

    public function services()
    {
        return $this->hasMany('App\Models\CartService');
    }

    public function productServices()
    {
        return $this->hasMany('App\Models\ProductService','product_id', 'product_row_id');
    }

    // public function cartServices()
    // {
    //     return $this->hasMany('App\Models\CartService','cart_id','cart_id');
    // }

    public function productPrice()
    {
        $product = Product::find($this->product_id);
        //print '<pre>'; print_r($product); die;
        if($product->is_variant){
            $attribute = $product->attributes()->find($this->product_attribute_id);
            //print '<pre>'; print_R($attribute); die;
            return Helper::numberFormat($attribute->price);
        }
        return Helper::numberFormat($product->price);
    }

    public function productOldPrice()
    {
        $product = Product::find($this->product_id);
        //print '<pre>'; print_r($product); die;
        if($product->is_variant){
            $attribute = $product->attributes()->find($this->product_attribute_id);
            //print '<pre>'; print_R($attribute); die;
            if($attribute->old_price){
                return Helper::numberFormat($attribute->old_price);
            }
        }
        if($product->old_price){
            return Helper::numberFormat($product->old_price);
        }
    }

    public function productPriceShow()
    {
        $currency = Helper::getCurrency();
        $product = Product::find($this->product_id);
        //print '<pre>'; print_r($product); die;
        if($product->is_variant){
            $attribute = $product->attributes()->find($this->product_attribute_id);
            //print '<pre>'; print_R($attribute); die;
            return $currency['sign'].Helper::priceFormat($attribute->price);
        }
        return $currency['sign'].Helper::priceFormat($product->price);
    }

    public function productQuantityPriceShow()
    {
        $currency = Helper::getCurrency();
        $product = Product::find($this->product_id);
        //print '<pre>'; print_r($product); die;
        //print $this->quantity; die;
        //print $product->price*$this->quantity; die;
        if($product->is_variant){
            $attribute = $product->attributes()->find($this->product_attribute_id);
            return $currency['sign'].Helper::priceFormat($attribute->price*$this->quantity);
        }
        return $currency['sign'].Helper::priceFormat($product->price*$this->quantity);
    }

    public function productOldPriceShow()
    {
        $currency = Helper::getCurrency();
        $product = Product::find($this->product_id);
        //print '<pre>'; print_r($product); die;
        if($product->is_variant){
            $attribute = $product->attributes()->find($this->product_attribute_id);
            //print '<pre>'; print_R($attribute); die;
            if($attribute->old_price){
                return $currency['sign'].Helper::priceFormat($attribute->old_price);
            }
        }
        if($product->old_price){
            return $currency['sign'].Helper::priceFormat($product->old_price);
        }
    }

}
