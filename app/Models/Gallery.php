<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gallery';
    protected $fillable = [
        'image', 'title', 'is_default', 'image_alt', 'is_featured', 'order', 'status'
    ];

}
