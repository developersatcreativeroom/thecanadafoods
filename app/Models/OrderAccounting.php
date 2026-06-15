<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAccounting extends Model
{
    use HasFactory;
    protected $table = 'order_accounting';

    protected $fillable = [
        'order_id', 'accounting_software', 'invoice_id', 'invoice_number', 'contact_id', 'is_synchronized', 'message'
    ];
}
