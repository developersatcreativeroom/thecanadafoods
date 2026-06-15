<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'image', 'is_default'
    ];

    public function Products()
    {
        return $this->belongsTo('App\Model\Products');
    }


}