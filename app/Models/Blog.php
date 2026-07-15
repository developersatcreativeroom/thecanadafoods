<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helper;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'read_time',
        'blog_category_id',
        'short_description',
        'description',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'status'
    ];


    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {

            $model->slug = Helper::createSlug(static::class, $model->title);

            $model->save();
        });
    }

   public function galleries()
{
    return $this->hasMany(Gallery::class, 'type_id')
        ->where('type', 'blog')
        ->withAttributes([
            'type' => 'blog',
        ]);
}

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'type_id', 'id')->where('type', 'blog')->where('status', 1);
    }
}
