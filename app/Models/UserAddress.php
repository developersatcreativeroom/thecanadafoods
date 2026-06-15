<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_default',
        'is_billing',
        'is_shipping',
        'first_name',
        'last_name',
        'company_name',
        'email',
        'country_code',
        'phone',
        'address_line_1',
        'address_line_2',
        'street',
        'city',
        'state',
        'country',
        'postal'
    ];
}
