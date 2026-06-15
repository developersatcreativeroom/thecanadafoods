<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'order_id', 'user_id', 'total', 'discount', 'coupon_discount', 'shipping', 'products_service', 'is_state_tax', 'is_central_tax', 'is_integrated_tax', 'tax', 'currency', 'currency_iso_code', 'amount', 'type', 'payment_status', 'razorpay_order_id', 'payment_id', 'payment_response', 'status'
    ];


    //  protected $appends = ['sales'];

    //  public function getSalesAttribute()
    //  {
    //      return $this->sum('amount');
    //  }
}
