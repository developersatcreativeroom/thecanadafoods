<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helper;

class BlogCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'status'
    ];

    public function blogs()
    {
        return $this->hasMany('App\Models\Blog');
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
