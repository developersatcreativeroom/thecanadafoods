<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryProductService extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_product_id', 'name', 'slug', 'image', 'summary', 'description', 'price', 'old_price'
    ];
}
