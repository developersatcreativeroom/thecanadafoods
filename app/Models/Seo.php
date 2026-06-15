<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;

    protected $table = 'seo';
    protected $fillable = [
        'page', 'seo_title', 'seo_description', 'seo_keywords'
    ];
}
