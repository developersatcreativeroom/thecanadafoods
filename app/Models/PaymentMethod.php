<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    //
    protected $fillable = [
        'user_id', 'payment_method', 'type', 'provider', 'last_four', 'is_default'
    ];
}
