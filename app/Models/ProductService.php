<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Helper;

class ProductService extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name', 'product_id', 'slug', 'image', 'summary', 'description', 'price', 'old_price', 'status'
    ];

    public function getPrice()
    {
        $currency = Helper::getCurrency();
        return $currency['sign'].$this->price;
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {

            $model->slug = Helper::createSlug(static::class,$model->name);

            $model->save();
        });
    }

}
