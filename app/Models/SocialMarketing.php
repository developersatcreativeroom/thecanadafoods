<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMarketing extends Model
{
    use HasFactory;

    protected $table = 'social_marketing';
    protected $fillable = [
        'type', 'script', 'status'
    ];

}
