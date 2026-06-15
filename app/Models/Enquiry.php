<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Cashier\Billable;

use App\Helper;

class Enquiry extends Model
{
    use HasFactory, Billable;

    protected $fillable = [
        'enquiry_no', 'enquiry_unique_id', 'user_id', 'first_name', 'last_name', 'email', 'country_code', 'phone', 'stripe_id', 'pm_type', 'pm_last_four', 'enquiry_status', 'currency', 'currency_iso_code', 'coupon_id', 'order_type', 'customer_gst', 'order_notes', 'status', 'discount'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\EnquiryProduct');
    }

    public function billing()
    {
        return $this->hasOne('App\Models\EnquiryBilling');
    }

    public function shipping()
    {
        return $this->hasOne('App\Models\EnquiryShipping');
    }

    public function history()
    {
        return $this->hasMany('App\Models\EnquiryStatusHistory');
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
        // print $join; die;
        $names = explode(" ", $name);
        return $query->where(function($query) use ($names, $joinTable) {
            $query->whereIn('enquiries.first_name', $names);
            $query->whereIn('enquiries.last_name', $names);
            // $query->orWhereIn('users.last_name', $names);
            if($joinTable){
                $query->orWhere(function($query) use ($names,$joinTable) {
                    $query->whereIn($joinTable.'.first_name', $names);
                    $query->whereIn($joinTable.'.last_name', $names);
                });
            }
            
        });
    }
}
