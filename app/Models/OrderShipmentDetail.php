<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShipmentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'shipment_carrier', 'postal_from', 'postal_to', 'service_code', 'service_name', 'currency', 'currency_iso_code', 'price_response', 'price', 'response'
    ];

}
