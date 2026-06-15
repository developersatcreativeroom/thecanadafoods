<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAccounting extends Model
{
    use HasFactory;
    protected $table = 'product_accounting';

    protected $fillable = [
        'product_id', 'product_attribute_id', 'accounting_software', 'product_code', 'is_synchronized', 'message'
    ];
}
