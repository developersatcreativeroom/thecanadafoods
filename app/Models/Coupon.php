<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'type', 'image', 'no_of_times', 'amount_type', 'amount_value', 'applicable_on_products', 'min_product_quantity', 'min_price', 'valid_from', 'valid_to', 'status'
    ];

    public function ForUsers()
    {
        //return $this->hasMany('App\Models\CoupanForUser');
        return $this->belongsToMany(User::class, 'user_coupons', 'coupon_id', 'user_id')->withTimestamps();
    }
}
