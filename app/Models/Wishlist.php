<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Helper;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'wishlist';

    protected $fillable = [
        'product_id', 'product_attribute_id', 'user_id', 'uuid'
    ];

    public function attribute()
    {
        return $this->hasOne('App\Models\ProductAttribute','id','product_attribute_id');
    }

    public function productPriceShow()
    {
        $currency = Helper::getCurrency();
        $product = Product::find($this->product_id);
        //print '<pre>'; print_r($product); die;
        if($product->is_variant){
            if($this->product_attribute_id != null){
                $attribute = $product->attributes()->find($this->product_attribute_id);
                //print '<pre>'; print_R($attribute); die;
                return $currency['sign'].Helper::numberFormat($attribute->price);
            }else{
                $attributes = $product->attributes()->get();
                if (count($attributes) > 0 && $product->is_variant) {
                    
                    //print_r($attributes); die;
                    $priceArray = [];
                    foreach($attributes as $attribute){
                        $priceArray[] = $attribute->old_price;
                    }
                    $min = min($priceArray);
                    $max = max($priceArray);
                    $min = Helper::numberFormat($min);
                    $max = Helper::numberFormat($max);
                    if($min != $max){
                        return $currency['sign'].$min.' - '.$currency['sign'].$max;
                    }else{
                        return $currency['sign'].$min;
                    }

                }
            }
            
        }



        

        return $currency['sign'].Helper::numberFormat($product->price);
    }
}
