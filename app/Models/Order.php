<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Cashier\Billable;

use Stripe\Stripe;
use Stripe\PaymentIntent;

use App\Helper;

class Order extends Model
{
    use HasFactory, Billable;

    protected $fillable = [
        'order_no', 'order_unique_id', 'user_id', 'first_name', 'last_name', 'email', 'country_code', 'phone', 'stripe_id', 'pm_type', 'pm_last_four', 'order_status', 'is_payment_done', 'payment_method', 'currency', 'currency_iso_code', 'coupon_id', 'order_type', 'customer_gst', 'order_notes', 'status', 'discount', 'local_pickup', 'coupon_code', 'coupon_type', 'coupon_value', 'coupon_discount'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\OrderProduct');
    }

    public function billing()
    {
        return $this->hasOne('App\Models\OrderBilling');
    }

    public function shipping()
    {
        return $this->hasOne('App\Models\OrderShipping');
    }

    public function history()
    {
        return $this->hasMany('App\Models\OrderStatusHistory');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\Payment')->where('payments.status',1);
    }

    public function accounting()
    {
        return $this->hasOne('App\Models\OrderAccounting');
    }

    public function shipment()
    {
        return $this->hasOne('App\Models\OrderShipmentDetail');
    }

    public function amount()
    {
        $currency = Helper::getCurrency();

        $products = $this->products()->get();
        
        $price = 0;

        if (count($products) > 0 ) {
            
            //print_r($attributes); die;
            
            foreach($products as $product){
                $price += $product->price * $product->quantity;
            }
            $price = Helper::numberFormat($price);
            return $currency['sign'].$price;

        }else{
            return $currency['sign'].$price;
        }
    }

    public function amountWithItems()
    {
        $count = $this->products()->count();
        return $this->amount().' for '.$count.' product(s)';
        
    }

    public function scopeFullName($query, string $name, $joinTable = null)
    {
        $names = explode(" ", $name);
        return $query->where(function($query) use ($names, $joinTable) {

            $query->whereIn('orders.first_name', $names);
            $query->whereIn('orders.last_name', $names);
            // $query->orWhereIn('users.last_name', $names);
            if($joinTable){
                $query->orWhere(function($query) use ($names,$joinTable) {
                    $query->whereIn($joinTable.'.first_name', $names);
                    $query->whereIn($joinTable.'.last_name', $names);
                });
            }
            
        });
    }

    public function safeCharge(int $amountInCents, string $paymentMethodId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET')); // Your Stripe secret

        $currency = Helper::getCurrency();
        
        return PaymentIntent::create([
            'amount' => $amountInCents,
            'currency' => $currency['currency_iso_code'],
            'customer' => $this->stripe_id, // Provided by Cashier
            'payment_method' => $paymentMethodId,
            'off_session' => true,
            'confirm' => true,
            'automatic_payment_methods' => [
                'enabled' => true,
                'allow_redirects' => 'never', // <== this fixes your issue
            ],
        ]);
    }
    
}
