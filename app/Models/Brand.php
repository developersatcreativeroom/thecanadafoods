<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'image', 'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {

            $model->slug = Helper::createSlug(static::class,$model->name);

            $model->save();
        });
    }

}
