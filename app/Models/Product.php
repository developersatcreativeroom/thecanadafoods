<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Helper;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name', 'slug', 'title_h1', 'short_description', 'description', 'image_alt', 'sku', 'image', 'hover_image', 'image_alt', 'product_type', 'affiliate_link', 'licence_name', 'licence_key', 'file_type', 'link', 'file', 'price', 'old_price', 'tax_id', 'is_tax_included', 'brand_id', 'color_id', 'vendor_id', 'group_id', 'is_featured', 'is_sample', 'is_sale', 'is_new', 'is_hot', 'is_best_sell', 'is_variant', 'stock', 'min_quantity', 'threshold', 'total_sales', 'length', 'width', 'height', 'weight', 'shipping_weight', 'tags', 'seo_title', 'seo_description', 'seo_keywords', 'is_imported', 'purchase_note', 'average_rating', 'review_count', 'status'
    ];

    protected $appends = ['average_rating', 'total_rating', 'average_rating_floor', 'average_rating_percentage'];


    public function getAverageRatingAttribute()
    {
        return round($this->ratings()->where('status',1)->avg('rating'), 1);
    }

    public function getTotalRatingAttribute()
    {
        return $this->ratings()->where('status',1)->count();
    }

    public function getAverageRatingFloorAttribute()
    {
        return floor($this->ratings()->where('status',1)->avg('rating'));
    }

    
    public function getAverageRatingPercentageAttribute()
    {
        //return round((($this->ratings()->where('status',1)->avg('rating')) / 5 ) * 100, 2);
        return round((($this->ratings()->where('status',1)->avg('rating')) / 5 ) * 100);
    }

    public function getRatingDistributionAttribute()
    {
        $total = $this->ratings()->where('status', 1)->count();
        $distribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $this->ratings()->where('status', 1)->where('rating', $i)->count();
            $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
            $distribution[$i] = [
                'count' => $count,
                'percentage' => $percentage,
            ];
        }
        return $distribution;
    }

    public function categories()
    {
        return $this->hasMany('App\Models\ProductCategory');
    }
    
    public function CategoriesNew()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id',  'category_id');
    }


    public function image()
    {
        return $this->hasOne('App\Models\ProductImage');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    public function attributes()
    {
        return $this->hasMany('App\Models\ProductAttribute');
    }

    public function attribute()
    {
        return $this->hasOne('App\Models\ProductAttribute');
    }
    
    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }


    public function services()
    {
        return $this->hasMany('App\Models\ProductService');
    }

    public function addons()
    {
        return $this->hasMany('App\Models\ProductAddon');
    }

    public function specifications()
    {
        return $this->hasMany('App\Models\ProductSpecification');
    }
    
    public function accounting()
    {
        return $this->hasMany('App\Models\ProductAccounting');
    }

    public function getPrice()
    {
        $currency = Helper::getCurrency();

        $attributes = $this->attributes()->get();
        if (count($attributes) > 0 && $this->is_variant) {
            
            //print_r($attributes); die;
            $priceArray = [];
            foreach($attributes as $attribute){
                $priceArray[] = $attribute->price;
            }
            $min = min($priceArray);
            $max = max($priceArray);
            $min = Helper::priceFormat($min);
            $max = Helper::priceFormat($max);
            if($min != $max){
                return $currency['sign'].$min.' - '.$currency['sign'].$max;
            }else{
                return $currency['sign'].$min;
            }

        }else{
            return $currency['sign'].Helper::priceFormat($this->price);
        }
    }

    public function getPriceNumeric()
    {

        $attributes = $this->attributes()->get();
        if (count($attributes) > 0 && $this->is_variant) {
            
            //print_r($attributes); die;
            $priceArray = [];
            foreach($attributes as $attribute){
                $priceArray[] = $attribute->price;
            }
            $min = min($priceArray);
            $max = max($priceArray);
            $min = Helper::numberFormat($min);
            $max = Helper::numberFormat($max);
            if($min != $max){
                return $min.' - '.$max;
            }else{
                return $min;
            }

        }else{
            return $this->price;
        }
    }

    public function getOldPrice()
    {
        $currency = Helper::getCurrency();
        $attributes = $this->attributes()->get();
        if (count($attributes) > 0 && $this->is_variant) {
            
            //print_r($attributes); die;
            $priceArray = [];
            foreach($attributes as $attribute){
                if($attribute->old_price){
                    $priceArray[] = $attribute->old_price;
                }
            }
            if(count($priceArray) > 0){
                $min = min($priceArray);
                $max = max($priceArray);
                $min = Helper::priceFormat($min);
                $max = Helper::priceFormat($max);
                if($min != $max){
                    return $currency['sign'].$min.' - '.$currency['sign'].$max;
                }else{
                    return $currency['sign'].$min;
                }
            }

        }else{
            if($this->old_price){
                return $currency['sign'].Helper::priceFormat($this->old_price);
            }
        }
    }

    public function getPercentageDiscount()
    {

        $attributes = $this->attributes()->get();
        if (count($attributes) > 0 && $this->is_variant) {
            return false; 
        }else{
            if($this->old_price){
                return round(100 - ($this->price/$this->old_price) * 100). '% off';
            }
        }
    }

    //protected $dateFormat = 'U';
    //const UPDATED_AT = null;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {

            $model->slug = Helper::createSlug(static::class,$model->name);

            $model->save();
        });
    }

public function faqs()
{
    return $this->hasMany(Faq::class, 'type_id', 'id')
        ->where('type', 'product');
}

}