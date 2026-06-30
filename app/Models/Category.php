<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helper;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'title_h1',
        'parent_category_id',
        'description',
        'short_description',
        'image_alt',
        'level',
        'is_requested',
        'is_requested',
        'is_requested',
        'status'
    ];


    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {

            $model->slug = Helper::createSlug(static::class, $model->name);

            $model->save();
        });
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'type_id', 'id')->where('type', 'category')->where('status', 1);
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_category_id', 'id')
            ->where('status', 1)
            ->orderBy('name', 'ASC');
    }
}
