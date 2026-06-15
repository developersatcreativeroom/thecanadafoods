<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBilling extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'first_name', 'last_name', 'company_name', 'email', 'country_code', 'phone', 'address_line_1', 'address_line_2', 'street', 'city', 'state', 'country', 'postal'
    ];
}
