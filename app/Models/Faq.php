<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question', 'answer', 'type', 'type_id', 'status', 'serial'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'type_id', 'id');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'type_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'type_id', 'id');
    }

    public function getTypeNameAttribute()
    {
        return ucfirst($this->type);
    }
}
