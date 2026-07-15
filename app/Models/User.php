<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Sanctum\HasApiTokens;

use Laravel\Cashier\Billable;

use Stripe\Stripe;
use Stripe\PaymentIntent;

use App\Helper;

class User extends Authenticatable implements CanResetPasswordContract, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'country_code',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cart()
    {
        return $this->hasMany('App\Models\Cart');
    }
    
    public function wishlist()
    {
        return $this->hasMany('App\Models\Wishlist');
    }
    public function coupon()
    {
        return $this->hasOne('App\Models\UserCoupon','user_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\UserAddress');
    }
    public function addressBilling()
    {
        return $this->hasOne('App\Models\UserAddress')->where('is_billing', 1);
    }

    public function addressShipping()
    {
        return $this->hasOne('App\Models\UserAddress')->where('is_shipping', 1);
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
    
    public function enquiries()
    {
        return $this->hasMany('App\Models\Enquiry');
    }

    public function paymentMethods()
    {
        return $this->hasMany('App\Models\PaymentMethod');
    }

    public function scopeFullName($query, string $name, $joinTable = null)
    {
        $names = explode(" ", $name);
        return $query->where(function($query) use ($names, $joinTable) {

            $query->whereIn('first_name', $names);
            $query->whereIn('last_name', $names);
            // $query->orWhereIn('last_name', $names);
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
        Stripe::setApiKey(config('services.stripe.secret')); // Your Stripe secret

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
