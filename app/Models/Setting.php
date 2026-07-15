<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 'value', 'status'
    ];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('website_settings');
        });

        static::deleted(function () {
            Cache::forget('website_settings');
        });
    }

}
