<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'top_title', 'title', 'sub_title', 'image', 'description', 'button_name', 'button_link', 'serial', 'status'
    ];
}
