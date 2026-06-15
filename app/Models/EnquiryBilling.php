<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryBilling extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_id', 'first_name', 'last_name', 'company_name', 'email', 'country_code', 'phone', 'address_line_1', 'address_line_2', 'street', 'city', 'state', 'country', 'postal'
    ];
}
