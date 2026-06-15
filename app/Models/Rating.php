<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'user_id', 'name', 'email', 'rating', 'review', 'is_approved', 'status'
    ];


    protected $appends = ['rating_percentage'];


    public function getRatingPercentageAttribute()
    {
        return round(($this->rating / 5 ) * 100, 2);
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
    
}
