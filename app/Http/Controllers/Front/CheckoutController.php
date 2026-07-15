<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


use App\Models\Order;
use App\Models\Country;
use App\Models\State;
use App\Models\Enquiry;

use Stripe\Stripe;
use Stripe\SetupIntent;
use Stripe\Checkout\Session as StripeCheckoutSession;

use Carbon\Carbon;
use App\Helper;
use App\Models\Category;
use App\Models\Product;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Image;
use Validator;
use Mail;
use Session;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

use Razorpay\Api\Api as RazorpayApi;
use Razorpay\Api\Errors\SignatureVerificationError as RazorpaySignatureVerificationError;


class CheckoutController extends Controller
{
    private $prefix = 'front';
    private $folder = 'checkout';

    public function checkout(Request $request)
    {


        $user = Auth::user();
        $cart = Helper::getCartShowList($user);

        $total_temp_sensitive=$cart->where('temp_sensitive',1)->count();

        // dd($cart,$total_temp_sensitive);
        //print '<pre>'; print_r($cart->toArray()); die;
        if($cart->count() <= 0){
            return to_route('cart', [], 301);
        }

        // If the guest already picked a state (e.g. redirected back here after some
        // other validation error) resolve it now so the first paint shows the real
        // Standard price instead of "Select state" until the client-side AJAX runs.
        $initialState = null;
        if(!$user){
            $oldStateCode = old('shipping.state');
            if($oldStateCode){
                $initialState = State::where('code', $oldStateCode)->first();
            }
        }

        $checkout = Helper::checkout($user, true, $initialState);  // $user, $isShipping, $state
        //print '<pre>'; print_r($checkout); die;

        $allowedPaymentMethods = Helper::getPaymentSettings();
        //print '<pre>'; print_r($allowedPaymentMethods); die;

        $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

        $countries = Helper::getCountries();

        if($request->isMethod('post')){
          try {
            //  dd($request->all());
            //print 'aa'; die;
            // print '<pre>'; print_r($request->all()); die;

            if(!$isEnquiryWebsite){

                $checkout = Helper::checkout($user, true);  // $user, $isShipping, $state
                if(!$checkout['is_min_amount']){
                    Helper::flashMessage(false, 'Minimum items of amount '.$checkout['currency'].''.$checkout['min_cart_amount'].' to be added in cart to place an order');
                    return redirect()->back();
                }
                $billing = $request->input('billing');
                $billingAddress = $request->input('billing_address');
                $shipping = $request->input('shipping');
                $paymentMethod = $request->input('payment_method');
                $orderType = $request->input('order_type');
                $orderNotes = $request->input('order_notes');
                $customerGST = $request->input('customer_gst');
                $localPickup = $request->input('local_pickup');
                $isExpress = Helper::isExpressShippingMethod($request->input('shipping_method'));
                $stripePaymentMethod = $request->filled('stripe_payment_method') ? trim($request->input('stripe_payment_method')) : null;



                $token = $request->input('g-recaptcha-response');



                if($user){
                   $email = $user->email;
                } else{
                    $email = $shipping['email'];
                }

                //if(empty($id)){
                $validationArray=array(
                    //'billing'=>'required|array',
                    //'billing.*'=>'required|min:1',
                    //'shipping'=>'required|array',
                    //'shipping.*'=>'required|min:1',
                    // 'order_type'=>'required|in:Distributor,Commercial,Personal',
                    'order_type'=>'',
                    'payment_method'=>'required|in:instamojo,cash,paypal,stripe_card,razorpay,stripe_checkout,stripe_express_checkout',
                    'customer_gst'=>'',
                    'local_pickup'=>'',
                    'shipping_method'=>'nullable|in:'.config('constants.SHIPPING_STATUS.standard').','.config('constants.SHIPPING_STATUS.express'),
                    // 'stripe_payment_method'=>'required',
                    'stripe_payment_method'=>'',
                );



                if($user){

                }else{
                    $validationArray['shipping'] = 'required|array';
                    $validationArray['shipping.first_name'] = 'required';
                    $validationArray['shipping.last_name'] = 'required';
                    $validationArray['shipping.company_name'] = '';
                    $validationArray['shipping.country'] = 'required';
                    $validationArray['shipping.address_line_1'] = 'required';
                    $validationArray['shipping.address_line_2'] = '';
                    $validationArray['shipping.street'] = '';
                    $validationArray['shipping.city'] = 'required';
                    // Express Shipping is a flat weight-only rate - the destination state/zone
                    // isn't needed to price it, so don't force the customer to pick one.
                    $validationArray['shipping.state'] = $isExpress ? '' : 'required';
                    $validationArray['shipping.postal'] = 'required';
                    $validationArray['shipping.phone'] = 'required|numeric|digits:10';
                    $validationArray['shipping.email'] = 'required|email';

                    if($billingAddress != 'on'){
                        $validationArray['billing'] = 'required|array';
                        $validationArray['billing.first_name'] = 'required';
                        $validationArray['billing.last_name'] = 'required';
                        $validationArray['billing.company_name'] = '';
                        $validationArray['billing.country'] = 'required';
                        $validationArray['billing.address_line_1'] = 'required';
                        $validationArray['billing.address_line_2'] = '';
                        $validationArray['billing.street'] = '';
                        $validationArray['billing.city'] = 'required';
                        $validationArray['billing.state'] = 'required';
                        $validationArray['billing.postal'] = 'required';
                        $validationArray['billing.phone'] = 'required|numeric|digits:10';
                        $validationArray['billing.email'] = 'required|email';
                    }
                }

                $request->validate($validationArray);

                $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret'   => env('RECAPTCHA_SECRET_KEY'),
                    'response' => $token,
                    'remoteip' => $request->ip(),
                ]);

                $result = $response->json();
                // print '<pre>'; print_r($result); die;

                if (!($result['success'] ?? false) || ($result['score'] ?? 0) < 0.5) {
                    return back()->withErrors(['captcha' => 'reCAPTCHA verification failed.']);
                }

                if($paymentMethod == 'stripe_checkout' && isset($request->save_card) && $request->save_card ==1){
                    $isPaymentMehodAllowed = Helper::savePaymentCard($stripePaymentMethod);
                }

               // return 123;
                $validateCoupon = Helper::validateCoupon($user, null, $email);
                $couponError = '';
                $couponCode = '';
                if(!$validateCoupon['result']){
                    $couponError = $validateCoupon['message'];
                    $couponCode = $validateCoupon['code'];
                    // $coupon = Coupon::where('code', $couponCode)->first();
                    // // print '<pre>'; print_r($coupon); die;
                    // if($user){
                    //     $user->coupon()->where('coupon_id', $coupon->id)->delete();
                    // }else{
                    //     $uuid = Helper::getUserUUID();
                    //     UserCoupon::where('coupon_id', $coupon->id)->where('uuid', $uuid)->delete();
                    // }

                    Helper::flashMessage(false, 'Coupon Error: '.$validateCoupon['message']);
                    return to_route('checkout')->withInput();

                }

                DB::beginTransaction();


                $isPaymentMehodAllowed = Helper::isPaymentMethodEnabled($paymentMethod);
                if(!$isPaymentMehodAllowed){
                    return to_route('home');
                }


                $billingAddress = $billingAddress == 'on' ? 1 : 0;
                $localPickup = $localPickup == 'on' ? 1 : 0;
                //die;

                $currency = Helper::getCurrency();

                $shippingType = $isExpress ? config('constants.SHIPPING_STATUS.express') : config('constants.SHIPPING_STATUS.standard');


                $insertOrder = array('order_unique_id'=>Helper::unique_code(30), 'order_status'=> 'Initiated','payment_method'=>$paymentMethod,'order_type'=>$orderType,'order_notes'=>$orderNotes, 'currency' => $currency['sign'], 'currency_iso_code' => $currency['currency_iso_code'], 'discount' => null, 'local_pickup' => $localPickup, 'shipping_type' => $shippingType);

                $coupon = Helper::getCouponDetails($user);
                //print '<pre>'; print_r($coupon); die;
                if($coupon){
                    $insertOrder['coupon_id'] = $coupon->coupon_id;
                    $insertOrder['coupon_code'] = $coupon->code;
                    $insertOrder['coupon_type'] = $coupon->amount_type;
                    $insertOrder['coupon_value'] = $coupon->amount_value;
                    $insertOrder['coupon_discount'] = $coupon->calculated_discount;
                }

                if($customerGST){
                    $insertOrder['customer_gst'] = $customerGST;
                }

                //print '<pre>'; print_r($insertOrder); die;

                $config = Helper::getWebsiteConfig('country_code');

                if($user){
                    $order = $user->orders()->create($insertOrder);
                }else{

                    $insertOrder['first_name'] = $shipping['first_name'];
                    $insertOrder['last_name'] = $shipping['last_name'];
                    $insertOrder['email'] = $shipping['email'];
                    $insertOrder['country_code'] = $config['country_code'];
                    $insertOrder['phone'] = $shipping['phone'];
                    $order = Order::create($insertOrder);
                }

                // $order->order_no = str_pad($order->id, 8, "0", STR_PAD_LEFT);
                $CustOrderId  = $order->id + 10126 ;
                $order->order_no = str_pad($CustOrderId, 8, "0", STR_PAD_LEFT);
                $order->save();
                // DB::commit();
                // die;

                if($coupon){
                    $coupon->delete();
                }

                //print '<pre>'; print_r($cart); die;
                $order->history()->create(['status'=> 'Initiated', 'type'=> 'initiated']);


                if($user){

                    $address = Helper::getDefaultBillingAndShippingAddress($user);
                    //print'<pre>';print_r($address); die;
                    $addressBilling = $address['billing'];
                    $addressShipping = $address['shipping'];

                    if($billingAddress){
                        $order->billing()->create(['first_name' => $addressShipping['first_name'], 'last_name' => $addressShipping['last_name'], 'company_name' => $addressShipping['company_name'], 'email' => $addressShipping['email'], 'country_code' => $addressShipping['country_code'], 'phone' => $addressShipping['phone'], 'address_line_1' => $addressShipping['address_line_1'], 'address_line_2' => $addressShipping['address_line_2'], 'street' => $addressShipping['street'], 'city' => $addressShipping['city'], 'state' => $addressShipping['state'], 'country' => $addressShipping['country'], 'postal' => $addressShipping['postal']]);
                    }else{
                        $order->billing()->create(['first_name' => $addressBilling['first_name'], 'last_name' => $addressBilling['last_name'], 'company_name' => $addressBilling['company_name'], 'email' => $addressBilling['email'], 'country_code' => $addressBilling['country_code'], 'phone' => $addressBilling['phone'], 'address_line_1' => $addressBilling['address_line_1'], 'address_line_2' => $addressBilling['address_line_2'], 'street' => $addressBilling['street'], 'city' => $addressBilling['city'], 'state' => $addressBilling['state'], 'country' => $addressBilling['country'], 'postal' => $addressBilling['postal']]);
                    }


                    if(!$localPickup){

                        $order->shipping()->create(['first_name' => $addressShipping['first_name'], 'last_name' => $addressShipping['last_name'], 'company_name' => $addressShipping['company_name'], 'email' => $addressShipping['email'], 'country_code' => $addressShipping['country_code'], 'phone' => $addressShipping['phone'], 'address_line_1' => $addressShipping['address_line_1'], 'address_line_2' => $addressShipping['address_line_2'], 'street' => $addressShipping['street'], 'city' => $addressShipping['city'], 'state' => $addressShipping['state'], 'country' => $addressShipping['country'], 'postal' => $addressShipping['postal']]);
                    }



                }else{

                    if($billingAddress){
                        $order->billing()->create(['first_name' => $shipping['first_name'], 'last_name' => $shipping['last_name'], 'company_name' => $shipping['company_name'], 'email' => $shipping['email'], 'country_code' => $config['country_code'], 'phone' => $shipping['phone'], 'address_line_1' => $shipping['address_line_1'], 'address_line_2' => $shipping['address_line_2'], 'street' => $shipping['street'], 'city' => $shipping['city'], 'state' => $shipping['state'], 'country' => $shipping['country'], 'postal' => $shipping['postal']]);
                    }else{
                        $order->billing()->create(['first_name' => $billing['first_name'], 'last_name' => $billing['last_name'], 'company_name' => $billing['company_name'], 'email' => $billing['email'], 'country_code' => $config['country_code'], 'phone' => $billing['phone'], 'address_line_1' => $billing['address_line_1'], 'address_line_2' => $billing['address_line_2'], 'street' => $billing['street'], 'city' => $billing['city'], 'state' => $billing['state'], 'country' => $billing['country'], 'postal' => $billing['postal']]);
                    }



                    if(!$localPickup){

                        $order->shipping()->create(['first_name' => $shipping['first_name'], 'last_name' => $shipping['last_name'], 'company_name' => $shipping['company_name'], 'email' => $shipping['email'], 'country_code' => $config['country_code'], 'phone' => $shipping['phone'], 'address_line_1' => $shipping['address_line_1'], 'address_line_2' => $shipping['address_line_2'], 'street' => $shipping['street'], 'city' => $shipping['city'], 'state' => $shipping['state'], 'country' => $shipping['country'], 'postal' => $shipping['postal']]);

                        $shippingState = $order->shipping->state;
                    }
                }


                $sameShippingState = false;

                if(isset($shippingState) && (strtolower($shippingState) == strtolower(config('constants.ADDRESS.state')))){
                    $sameShippingState = true;
                }


                foreach($cart as $cartSingle){
                    //print '<pre>'; print_r($cartSingle); die;
                    //continue;

                    $attributes = null;
                    $attributesArray = [];
                    if($cartSingle->is_variant){
                        foreach($cartSingle->attribute->details as $key => $detail){
                            $attributesArray[$key]['attribute_name'] = $detail->attribute_name;
                            $attributesArray[$key]['attribute_option_name'] = $detail->attribute_option_name;
                        }
                        $attributes = json_encode($attributesArray);
                    }

                    // if($cartSingle->is_variant){
                    //     //print 'a'; die;
                    //     $cartSingle->attribute->quantity;

                    // }else{
                    //     //print 'b'; die;
                    //     $quantityDB = $cartSingle->quantity;
                    // }
                    // print_r($quantityDB);

                    // continue;


                    $orderProduct = Helper::getProductOrderPriceDetails($cartSingle, $sameShippingState);

                    //print '<pre>'; print_r($orderProduct); die;


                    $orderProduct = $order->products()->create([

                        'product_id' => $cartSingle->product_id,
                        'product_attribute_id' => $cartSingle->product_attribute_id,


                        'name' => $cartSingle->name,
                        'short_description' => $cartSingle->short_description,
                        'description' => $cartSingle->description,
                        'sku' => $cartSingle->is_variant ? $cartSingle->attribute->sku : $cartSingle->sku,
                        'image' => $cartSingle->is_variant ? $cartSingle->attribute->image : $cartSingle->image,
                        'hover_image' => $cartSingle->is_variant ? $cartSingle->attribute->hover_image : $cartSingle->hover_image,
                        'product_type' => $cartSingle->product_type,
                        'affiliate_link' => $cartSingle->affiliate_link,
                        'licence_name' => $cartSingle->licence_name,
                        'licence_key' => $cartSingle->licence_key,
                        'file_type' => $cartSingle->file_type,
                        'link' => $cartSingle->link,
                        'file' => $cartSingle->file,

                        'quantity' => $cartSingle->quantity,
                        //'price' => $cartSingle->is_variant ? $cartSingle->attribute->price : $cartSingle->productPrice(),
                        //'old_price' => $cartSingle->is_variant ? $cartSingle->attribute->old_price : $cartSingle->productOldPrice(),
                        'price' => $orderProduct['price'],
                        'old_price' => $orderProduct['old_price'],

                        'sale_price' => $orderProduct['sale_price'],
                        'final_price' => $orderProduct['final_price'],

                        'tax_id' => $orderProduct['id'],
                        'tax_name' => $orderProduct['tax_name'],

                        'state_tax_name' => isset($orderProduct['state_tax_name']) ? $orderProduct['state_tax_name'] : null,
                        'state_tax' => isset($orderProduct['state_tax']) ? $orderProduct['state_tax'] : null,
                        'state_tax_amount' => isset($orderProduct['state_tax_amount']) ? $orderProduct['state_tax_amount'] : null,

                        'central_tax_name' => isset($orderProduct['central_tax_name']) ? $orderProduct['central_tax_name'] : null,
                        'central_tax' => isset($orderProduct['central_tax']) ? $orderProduct['central_tax'] : null,
                        'central_tax_amount' => isset($orderProduct['central_tax_amount']) ? $orderProduct['central_tax_amount'] : null,

                        'integrated_tax_name' => isset($orderProduct['integrated_tax_name']) ? $orderProduct['integrated_tax_name'] : null,
                        'integrated_tax' => isset($orderProduct['integrated_tax']) ? $orderProduct['integrated_tax'] : null,
                        'integrated_tax_amount' => isset($orderProduct['integrated_tax_amount']) ? $orderProduct['integrated_tax_amount'] : null,

                        'tax' => $orderProduct['tax'],
                        'tax_value' => $orderProduct['tax_value'],

                        'is_tax_included' => $cartSingle->is_tax_included,

                        'brand_id' => $cartSingle->brand_id,
                        'brand_name' => Helper::getBrandName($cartSingle->brand_id),
                        'color_id' => $cartSingle->color_id,
                        'color_name' => Helper::getColorName($cartSingle->color_id),
                        'vendor_id' => $cartSingle->vendor_id,
                        'group_id' => $cartSingle->group_id,
                        'is_featured' => $cartSingle->is_featured,
                        'is_sample' => $cartSingle->is_sample,
                        'is_sale' => $cartSingle->is_sale,
                        'is_new' => $cartSingle->is_new,
                        'is_hot' => $cartSingle->is_hot,
                        'is_best_sell' => $cartSingle->is_best_sell,
                        'is_variant' => $cartSingle->is_variant,
                        'min_quantity' => $cartSingle->is_variant ? $cartSingle->attribute->min_quantity : $cartSingle->min_quantity,
                        'length' => $cartSingle->is_variant ? $cartSingle->attribute->length : $cartSingle->length,
                        'width' => $cartSingle->is_variant ? $cartSingle->attribute->width : $cartSingle->width,
                        'height' => $cartSingle->is_variant ? $cartSingle->attribute->height : $cartSingle->height,
                        'weight' => $cartSingle->is_variant ? $cartSingle->attribute->weight : $cartSingle->weight,
                        'shipping_weight' => $cartSingle->is_variant ? $cartSingle->attribute->shipping_weight : $cartSingle->shipping_weight,
                        'attributes' => $attributes,

                        ]);

                        $config = Helper::getWebsiteConfig('product_services');
                        if($config['product_services']){
                            if(count($cartSingle->services) > 0){
                                foreach($cartSingle->services as $service){
                                    $orderProduct->services()->create(['name' => $service->name, 'slug' => $service->slug, 'image' => $service->image, 'summary' => $service->summary, 'description' => $service->description, 'price' => $service->price, 'old_price' => $service->old_price]);
                                }
                            }
                        }
                }
                //die;


                if($order){


                    // add shipment details starts
                    $shipment = Helper::addOrderShipmentDetails($order, $isExpress);
                    // add shipment details ends

                    $payment = Helper::makePayment($order, $paymentMethod, $user, $stripePaymentMethod);
                    // print '<pre>'; print_R($payment); die;
                    if($payment['result'] && $paymentMethod == 'stripe_card'){
                        return to_route('stripe.checkout', ['order_id' => $order->order_unique_id]);
                    }
                    if($payment['result'] && $paymentMethod == 'razorpay'){
                        return to_route('razorpay.checkout', ['order_id' => $order->order_unique_id]);
                    }
                    if($payment['result'] && $paymentMethod == 'stripe_express_checkout'){
                        DB::commit();
                        return redirect($payment['checkout_url']);
                    }
                    if($payment['result']){
                        $config = Helper::getAccountingSettings('is_xero');
                        $isXero = $config['is_xero'];
                        if($isXero){
                            Helper::createXeroInvoice($order);
                        }

                        $cartObj = Helper::getCartObj($user);
                        $cartObj->delete();

                        DB::commit();
                        return to_route('order.placed', ['order' => $order->order_unique_id]);
                    }else{
                        return to_route('order.placed', ['order' => $order->order_unique_id]);
                    }

                }else{
                    return to_route('order.placed', ['order' => $order->order_unique_id]);
                }

            }else{

                // enquiry code starts here

                $billing = $request->input('billing');
                $billingAddress = $request->input('billing_address');
                $shipping = $request->input('shipping');
                $orderType = $request->input('order_type');
                $orderNotes = $request->input('order_notes');
                $customerGST = $request->input('customer_gst');

                //print $id; die;


                $validationArray=array(
                    // 'order_type'=>'required|in:Distributor,Commercial,Personal',
                    'order_type'=>'',
                    'customer_gst'=>'',
                );

                if($user){

                }else{
                    $validationArray['shipping'] = 'required|array';
                    $validationArray['shipping.first_name'] = 'required';
                    $validationArray['shipping.last_name'] = 'required';
                    $validationArray['shipping.company_name'] = '';
                    $validationArray['shipping.country'] = 'required';
                    $validationArray['shipping.address_line_1'] = 'required';
                    $validationArray['shipping.address_line_2'] = '';
                    $validationArray['shipping.street'] = '';
                    $validationArray['shipping.city'] = 'required';
                    $validationArray['shipping.state'] = 'required';
                    $validationArray['shipping.postal'] = 'required|numeric';
                    $validationArray['shipping.phone'] = 'required|numeric|digits:10';
                    $validationArray['shipping.email'] = 'required|email';

                    if($billingAddress != 'on'){
                        $validationArray['billing'] = 'required|array';
                        $validationArray['billing.first_name'] = 'required';
                        $validationArray['billing.last_name'] = 'required';
                        $validationArray['billing.company_name'] = '';
                        $validationArray['billing.country'] = 'required';
                        $validationArray['billing.address_line_1'] = 'required';
                        $validationArray['billing.address_line_2'] = '';
                        $validationArray['billing.street'] = '';
                        $validationArray['billing.city'] = 'required';
                        $validationArray['billing.state'] = 'required';
                        $validationArray['billing.postal'] = 'required|numeric';
                        $validationArray['billing.phone'] = 'required|numeric|digits:10';
                        $validationArray['billing.email'] = 'required|email';
                    }
                }

                $request->validate($validationArray);

                DB::beginTransaction();


                $billingAddress = $billingAddress == 'on' ? 1 : 0;
                //die;

                $currency = Helper::getCurrency();

                $insertEnquiry = array('enquiry_unique_id'=>Helper::unique_code(30), 'enquiry_status'=> 'Initiated', 'order_type'=>$orderType,'order_notes'=>$orderNotes, 'currency' => $currency['sign'], 'currency_iso_code' => $currency['currency_iso_code'], 'discount' => null);


                if($customerGST){
                    $insertEnquiry['customer_gst'] = $customerGST;
                }

                //print '<pre>'; print_r($insertEnquiry); die;

                $config = Helper::getWebsiteConfig('country_code');

                if($user){
                    $enquiry = $user->enquiries()->create($insertEnquiry);
                }else{

                    $insertEnquiry['first_name'] = $billing['first_name'];
                    $insertEnquiry['last_name'] = $billing['last_name'];
                    $insertEnquiry['email'] = $billing['email'];
                    $insertEnquiry['country_code'] = $config['country_code'];
                    $insertEnquiry['phone'] = $billing['phone'];
                    $enquiry = Enquiry::create($insertEnquiry);
                }


                $enquiry->enquiry_no = str_pad($enquiry->id, 8, "0", STR_PAD_LEFT);
                $enquiry->save();
                // DB::commit();
                // die;

                //print '<pre>'; print_r($cart); die;
                $enquiry->history()->create(['status'=> 'Initiated', 'type'=> 'initiated']);


                if($user){

                    $address = Helper::getDefaultBillingAndShippingAddress($user);
                    //print'<pre>';print_r($address); die;
                    $addressBilling = $address['billing'];


                    $enquiry->billing()->create(['first_name' => $addressBilling['first_name'], 'last_name' => $addressBilling['last_name'], 'company_name' => $addressBilling['company_name'], 'email' => $addressBilling['email'], 'country_code' => $addressBilling['country_code'], 'phone' => $addressBilling['phone'], 'address_line_1' => $addressBilling['address_line_1'],  'address_line_2' => $addressBilling['address_line_2'], 'street' => $addressBilling['street'], 'city' => $addressBilling['city'], 'state' => $addressBilling['state'], 'country' => $addressBilling['country'], 'postal' => $addressBilling['postal']]);


                }else{
                    $enquiry->billing()->create(['first_name' => $billing['first_name'], 'last_name' => $billing['last_name'], 'company_name' => $billing['company_name'], 'email' => $billing['email'], 'country_code' => $config['country_code'], 'phone' => $billing['phone'], 'address_line_1' => $billing['address_line_1'], 'address_line_2' => $billing['address_line_2'], 'street' => $billing['street'], 'city' => $billing['city'], 'state' => $billing['state'], 'country' => $billing['country'], 'postal' => $billing['postal']]);

                }


                $sameShippingState = false;

                if(isset($shippingState) && (strtolower($shippingState) == strtolower(config('constants.ADDRESS.state')))){
                    $sameShippingState = true;
                }


                foreach($cart as $cartSingle){
                    //print '<pre>'; print_r($cartSingle); die;
                    //continue;

                    $attributes = null;
                    $attributesArray = [];
                    if($cartSingle->is_variant){
                        foreach($cartSingle->attribute->details as $key => $detail){
                            $attributesArray[$key]['attribute_name'] = $detail->attribute_name;
                            $attributesArray[$key]['attribute_option_name'] = $detail->attribute_option_name;
                        }
                        $attributes = json_encode($attributesArray);
                    }

                    // if($cartSingle->is_variant){
                    //     //print 'a'; die;
                    //     $cartSingle->attribute->quantity;

                    // }else{
                    //     //print 'b'; die;
                    //     $quantityDB = $cartSingle->quantity;
                    // }
                    // print_r($quantityDB);

                    // continue;


                    $enquiryProduct = Helper::getProductOrderPriceDetails($cartSingle, $sameShippingState);

                    //print '<pre>'; print_r($enquiryProduct); die;


                    $enquiryProduct = $enquiry->products()->create([

                        'product_id' => $cartSingle->product_id,
                        'product_attribute_id' => $cartSingle->product_attribute_id,


                        'name' => $cartSingle->name,
                        'short_description' => $cartSingle->short_description,
                        'description' => $cartSingle->description,
                        'sku' => $cartSingle->is_variant ? $cartSingle->attribute->sku : $cartSingle->sku,
                        'image' => $cartSingle->is_variant ? $cartSingle->attribute->image : $cartSingle->image,
                        'hover_image' => $cartSingle->is_variant ? $cartSingle->attribute->hover_image : $cartSingle->hover_image,
                        'product_type' => $cartSingle->product_type,
                        'affiliate_link' => $cartSingle->affiliate_link,
                        'licence_name' => $cartSingle->licence_name,
                        'licence_key' => $cartSingle->licence_key,
                        'file_type' => $cartSingle->file_type,
                        'link' => $cartSingle->link,
                        'file' => $cartSingle->file,

                        'quantity' => $cartSingle->quantity,
                        //'price' => $cartSingle->is_variant ? $cartSingle->attribute->price : $cartSingle->productPrice(),
                        //'old_price' => $cartSingle->is_variant ? $cartSingle->attribute->old_price : $cartSingle->productOldPrice(),
                        'price' => $enquiryProduct['price'],
                        'old_price' => $enquiryProduct['old_price'],

                        'sale_price' => $enquiryProduct['sale_price'],
                        'final_price' => $enquiryProduct['final_price'],

                        'tax_id' => $enquiryProduct['id'],
                        'tax_name' => $enquiryProduct['tax_name'],

                        'state_tax_name' => isset($enquiryProduct['state_tax_name']) ? $enquiryProduct['state_tax_name'] : null,
                        'state_tax' => isset($enquiryProduct['state_tax']) ? $enquiryProduct['state_tax'] : null,
                        'state_tax_amount' => isset($enquiryProduct['state_tax_amount']) ? $enquiryProduct['state_tax_amount'] : null,

                        'central_tax_name' => isset($enquiryProduct['central_tax_name']) ? $enquiryProduct['central_tax_name'] : null,
                        'central_tax' => isset($enquiryProduct['central_tax']) ? $enquiryProduct['central_tax'] : null,
                        'central_tax_amount' => isset($enquiryProduct['central_tax_amount']) ? $enquiryProduct['central_tax_amount'] : null,

                        'integrated_tax_name' => isset($enquiryProduct['integrated_tax_name']) ? $enquiryProduct['integrated_tax_name'] : null,
                        'integrated_tax' => isset($enquiryProduct['integrated_tax']) ? $enquiryProduct['integrated_tax'] : null,
                        'integrated_tax_amount' => isset($enquiryProduct['integrated_tax_amount']) ? $enquiryProduct['integrated_tax_amount'] : null,

                        'tax' => $enquiryProduct['tax'],
                        'tax_value' => $enquiryProduct['tax_value'],

                        'is_tax_included' => $cartSingle->is_tax_included,

                        'brand_id' => $cartSingle->brand_id,
                        'brand_name' => Helper::getBrandName($cartSingle->brand_id),
                        'color_id' => $cartSingle->color_id,
                        'color_name' => Helper::getColorName($cartSingle->color_id),
                        'vendor_id' => $cartSingle->vendor_id,
                        'group_id' => $cartSingle->group_id,
                        'is_featured' => $cartSingle->is_featured,
                        'is_sample' => $cartSingle->is_sample,
                        'is_sale' => $cartSingle->is_sale,
                        'is_new' => $cartSingle->is_new,
                        'is_hot' => $cartSingle->is_hot,
                        'is_best_sell' => $cartSingle->is_best_sell,
                        'is_variant' => $cartSingle->is_variant,
                        'min_quantity' => $cartSingle->is_variant ? $cartSingle->attribute->min_quantity : $cartSingle->min_quantity,
                        'length' => $cartSingle->is_variant ? $cartSingle->attribute->length : $cartSingle->length,
                        'width' => $cartSingle->is_variant ? $cartSingle->attribute->width : $cartSingle->width,
                        'height' => $cartSingle->is_variant ? $cartSingle->attribute->height : $cartSingle->height,
                        'weight' => $cartSingle->is_variant ? $cartSingle->attribute->weight : $cartSingle->weight,
                        'attributes' => $attributes,

                        ]);

                        $config = Helper::getWebsiteConfig('product_services');
                        if($config['product_services']){
                            if(count($cartSingle->services) > 0){
                                foreach($cartSingle->services as $service){
                                    $enquiryProduct->services()->create(['name' => $service->name, 'slug' => $service->slug, 'image' => $service->image, 'summary' => $service->summary, 'description' => $service->description, 'price' => $service->price, 'old_price' => $service->old_price]);
                                }
                            }
                        }
                }
                //die;

                $logo = Helper::getLightLogo();

                if($user){
                    $emailData = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'enquiry_no' => $enquiry->enquiry_no, 'enquiry' => $enquiry, 'to' => $user->email);

                    $emailDataAdmin = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'enquiry_no' => $enquiry->enquiry_no, 'enquiry' => $enquiry, 'to' => config('constants.EMAIL.send'));

                }else{

                    $config = Helper::getWebsiteConfig('country_code');

                    $emailData = array('logo' => $logo, 'name' => $enquiry->first_name.' '.$enquiry->last_name, 'email' => $enquiry->email, 'country_code' => $config['country_code'], 'phone' => $enquiry->phone, 'enquiry_no' => $enquiry->enquiry_no, 'enquiry' => $enquiry, 'to' => $enquiry->email);

                    $emailDataAdmin = array('logo' => $logo, 'name' => $enquiry->first_name.' '.$enquiry->last_name, 'email' => $enquiry->email, 'country_code' => $config['country_code'], 'phone' => $enquiry->phone, 'enquiry_no' => $enquiry->enquiry_no, 'enquiry' => $enquiry, 'to' => config('constants.EMAIL.send'));
                }

                dispatch(new \App\Jobs\EnquiryPlacedQueue($emailData));

                dispatch(new \App\Jobs\EnquiryAdminPlacedQueue($emailDataAdmin));

                if($enquiry){
                    $cartObj = Helper::getCartObj($user);
                    $cartObj->delete();
                    DB::commit();
                    return to_route('enquiry.placed', ['enquiry' => $enquiry->enquiry_unique_id]);
                }else{
                    return to_route('enquiry.placed', ['enquiry' => $enquiry->enquiry_unique_id]);
                }

            }
          } catch (\Illuminate\Validation\ValidationException $e) {
              throw $e;
          } catch (\Throwable $e) {
            // dd($e->getMessage());
              DB::rollBack();
              \Log::error('Checkout failed: '.$e->getMessage(), ['exception' => $e]);

              $message = 'Something went wrong while placing your order. Please try again.';
              if(config('app.debug')){
                  $message .= ' ('.$e->getMessage().' in '.$e->getFile().':'.$e->getLine().')';
              }

              Helper::flashMessage(false, $message);
              return redirect()->back()->withInput();
          }
        }



        if($user){
            $addressesObj = $user->addresses();
            $addressesCount = $addressesObj->count();
        }else{
            $addressesCount = 0;
        }


        $addressBilling = (object)[];
        $addressShipping = (object)[];
        if($addressesCount > 0){
            $address = Helper::getDefaultBillingAndShippingAddress($user);
            $addressBilling = $address['billing'];
            $addressShipping = $address['shipping'];
        }

        if($user){
            $addresses = $addressesObj->get();
        }else{
            $addresses = [];
        }

        //print_r($addresses); die;

        $intent = '';
        $paymentMethods = [];
        if($user){
            //$intent = auth()->user()->createSetupIntent();
            // $intent = $user->createSetupIntent();
            if(array_key_exists('stripe_checkout',$allowedPaymentMethods)){
                $paymentMethods = $user->paymentMethods()->get();
            }
        }else{
            //$orderObj = new Order();
            // $intent = $order->createSetupIntent();
            // print '<pre>'; print_r($intent); die;
        }

        // if (!(isset($paymentMethods) && count($paymentMethods) > 0)) {
        if(array_key_exists('stripe_checkout',$allowedPaymentMethods)){
            if($checkout['is_min_amount']){

                Stripe::setApiKey(env('STRIPE_SECRET'));
                $intent = SetupIntent::create([
                    // 'payment_method_types' => ['card'],
                    // 'payment_method_types' => ['card'],
                    // 'automatic_payment_methods' => ['enabled' => true],
                    // 'capture_method' => 'manual'
                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'always',
                    ],
                    'metadata' => [
                        'ip' => $request->ip(),
                        'user_id'    => $user->id ?? null,
                        'user_agent' => $request->userAgent(),
                        // 'email' => '',
                    ],
                    // 'receipt_email' => '',
                    // 'amount' => $checkout['total_calculate'] * 100,
                ]);

            }

        }


        $coupon = '';
        $couponEnabled = Helper::getWebsiteConfig('coupon');
        if($couponEnabled['coupon'] == true){
            $coupon = Helper::getCouponDetails($user);
        }

   $products = Product::where('status', 1)
    ->whereHas('categories', function ($q) {
        $q->where('category_id', Category::where('slug', 'canadian-ice-packs')->value('id'));
    })
    ->get();



    // dd($products);


        return view($this->prefix.'.'.$this->folder.'.checkout')->with(compact('cart','products','total_temp_sensitive','checkout','addresses','addressBilling','addressShipping','allowedPaymentMethods','countries', 'isEnquiryWebsite', 'intent', 'paymentMethods','couponEnabled','coupon'));

    }



    public function instamojoRedirect(Request $request)
    {

        $uniqueID = Session::get('instamojo');
        //print '<pre>'; print_R($data);

        //print_r($_GET); die;

        DB::beginTransaction();

        $order = Order::where('order_unique_id',$uniqueID)->first();
        //print '<pre>'; print_r($order); die;
        $payment = $order->payments()->where('order_id',$order->id)->where('type','instamojo')->where('payment_id',null)->latest()->first();
        //print '<pre>'; print_r($payment); die;

        $user = Auth::user();

        if($_GET['payment_status'] == 'Credit'){
            $payment->payment_id = $_GET['payment_id'];
            $payment->payment_response = json_encode($_GET);
            $payment->payment_status = 'Paid';
            $payment->status = 1;
            $payment->save();

            $order->order_status = 'Payment Done';
            $order->is_payment_done = 1;
            $order->status = 1;
            $order->save();


            // // $order, $user, $productID, $productAttributeID, $quantity, $productPrice, $event, $type, $remarks, $userLevel, $note
            // Helper::addStockLog($order, $user, null, null, null, null, 'sold', 2, 'Product sold', 1, null);

            // $order, $user, $event, $type, $remarks, $userLevel, $note, $productID, $productAttributeID, $quantity, $productPrice
            Helper::addStockLog($order, $user, 'sold', 2, 'Product sold', 1, null, null, null, null, null);


            if($user){
                $emailData = array('name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $user->email);

                $emailDataAdmin = array('name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }else{
                $config = Helper::getWebsiteConfig('country_code');

                $emailData = array('name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $order->email);

                $emailDataAdmin = array('name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }

            dispatch(new \App\Jobs\OrderPlacedQueue($emailData));

            dispatch(new \App\Jobs\OrderAdminPlacedQueue($emailDataAdmin));

            $order->history()->create(['status'=> 'Payment Done', 'type'=> 'payment_done']);
        }else{

            // $_GET['payment_status'] = Failed     // case

            $payment->payment_id = $_GET['payment_id'];
            $payment->payment_response = json_encode($_GET);
            $payment->payment_status = 'Cancelled';
            //$payment->status = 0;
            $payment->save();

            $order->order_status = 'Payment Cancel';
            $order->is_payment_done = 0;
            $order->save();

            $order->history()->create(['status'=> 'Payment Cancel', 'type'=> 'payment_cancel']);
        }

        Session::forget('instamojo');
        DB::commit();

        if($payment && $_GET['payment_status'] == 'Credit'){
            $config = Helper::getAccountingSettings('is_xero');
            $isXero = $config['is_xero'];
            if($isXero){
                Helper::createXeroInvoice($order);
            }
            return to_route('order.placed', ['order' => $order->order_unique_id]);
        }else{
            return to_route('order.placed', ['order' => $order->order_unique_id]);
        }
    }


    public function paypalRedirect(Request $request){


        //print $request->order_id; die;

        $user = Auth::user();

        $order = Order::where('order_unique_id',$request->order_id)->first();
        //print '<pre>'; print_r($order); die;
        $payment = $order->payments()->where('order_id',$order->id)->where('type','paypal')->where('payment_id',null)->latest()->first();
        //print '<pre>'; print_r($payment); die;


        //print '<pre>';print_r($order); die;

        if($request->payment_status == 'success'){

            //$order = $provider->capturePaymentOrder($order_id);

            //die;

            $provider = new PayPalClient;
            //print '<pre>'; print_r($provider); die;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request->token);

            //print '<pre>'; print_r($response); die;

            if((isset($response['status']) && $response['status'] != 'COMPLETED') || (isset($response['error']) && count($response['error']) > 0)){
                return to_route('order.placed', ['order' => $order->order_unique_id]);
                //print 'Payment Failure'; die;

                //return redirect()->to('order-failure/'.$order->order_unique_id);
            }


            $payment->payment_id = $request->payment_id;
            $payment->payment_response = json_encode($_GET); // review it
            $payment->payment_status = 'Paid';
            $payment->status = 1;
            $payment->save();

            $order->order_status = 'Payment Done';
            $order->is_payment_done = 1;
            $order->status = 1;
            $order->save();


            // // $order, $user, $productID, $productAttributeID, $quantity, $productPrice, $event, $type, $remarks, $userLevel, $note
            // Helper::addStockLog($order, $user, null, null, null, null, 'sold', 2, 'Product sold', 1, null);

            // $order, $user, $event, $type, $remarks, $userLevel, $note, $productID, $productAttributeID, $quantity, $productPrice
            Helper::addStockLog($order, $user, 'sold', 2, 'Product sold', 1, null, null, null, null, null);

            $logo = Helper::getLightLogo();

            if($user){
                $emailData = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $user->email);

                $emailDataAdmin = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }else{
                $config = Helper::getWebsiteConfig('country_code');

                $emailData = array('logo' => $logo, 'name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $order->email);

                $emailDataAdmin = array('logo' => $logo, 'name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }

            dispatch(new \App\Jobs\OrderPlacedQueue($emailData));

            dispatch(new \App\Jobs\OrderAdminPlacedQueue($emailDataAdmin));

            $order->history()->create(['status'=> 'Payment Done', 'type'=> 'payment_done']);

            //return redirect()->to('order-success/'.$order->order_unique_id);

        }else if($request->payment_status == 'failure'){
            return to_route('order.placed', ['order' => $order->order_unique_id]);

            //print 'Payment failed'; die;
            //return redirect()->to('order-failure/'.$order->order_unique_id);
        }

        DB::commit();

        if($payment && $request->payment_status == 'success' && isset($response) && $response['status'] == 'COMPLETED'){
            $config = Helper::getAccountingSettings('is_xero');
            $isXero = $config['is_xero'];
            if($isXero){
                Helper::createXeroInvoice($order);
            }
            return to_route('order.placed', ['order' => $order->order_unique_id]);
        }else{
            return to_route('order.placed', ['order' => $order->order_unique_id]);
        }
    }

    public function razorpayRedirect(Request $request){

        $data = $request->all();
        // print '<pre>'; print_r($data); die;

        // {
        //     "razorpay_payment_id": "pay_29QQoUBi66xm2f",
        //     "razorpay_order_id": "order_9A33XWu170gUtm",
        //     "razorpay_signature": "9ef4dffbfd84f1318f6739a3ce19f9d85851857ae648f114332d8401e0949a3d"
        //   }

        // $api = new RazorpayApi(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        // // Fetch the order by its Razorpay ID
        // $razorData = $api->order->fetch($data['razorpay_order_id']);
        // // print '<pre>'; print_r($razorData); die;
        // $razorpayOrderId = $razorData['id'];

        $razorpayOrderId = $data['razorpay_order_id'];
        $razorpayPaymentId = $data['razorpay_payment_id'];
        $razorpaySignature = $data['razorpay_signature'];


        // print hash_hmac('sha256', 'order_P67OpkdYhidTUf|pay_P67P88JAQ45aZH', 'KXZHMWtbRhSGPJbNcpZ84Zxk');

        $user = Auth::user();

        // $order = Order::where('order_unique_id',$request->order_id)->first();

        // print $razorpayOrderId; die;

        if($user){
            $order = $user->orders()->whereHas('payments', function ($subQuery) use($razorpayOrderId) {
                $subQuery->where('razorpay_order_id', $razorpayOrderId);
            })->first();
        }else{
            $order = Order::whereHas('payments', function ($subQuery) use($razorpayOrderId) {
                $subQuery->where('razorpay_order_id', $razorpayOrderId);
            })
            // ->with('payments', function ($subQuery) use($razorpayOrderId)
            // {
            //     $subQuery->where('razorpay_order_id', $razorpayOrderId);

            // })
            ->first();
        }

        $payment = $order->payments()->where('razorpay_order_id', $razorpayOrderId)->first();
        // print '<pre>'; print_r($payment->toArray()); die;

        // $generated_signature = hmac_sha256($payment->razorpay_order_id + "|" + $razorpayPaymentId, env('RAZORPAY_SECRET'));
        // $generated_signature = hash_hmac('sha256', $payment->razorpay_order_id + "|" + $razorpayPaymentId, env('RAZORPAY_SECRET'));

        // print $generated_signature; die;

        $matchSignature = hash_hmac('sha256', $payment->razorpay_order_id.'|'.$razorpayPaymentId, env('RAZORPAY_SECRET'));

        if($payment && ($matchSignature == $razorpaySignature)){

            $payment->payment_id = $razorpayPaymentId;
            $payment->payment_response = json_encode($data);

            $payment->payment_status = 'Paid';
            $payment->status = 1;
            $payment->save();

            $order->order_status = 'Payment Done';
            $order->is_payment_done = 1;
            $order->status = 1;
            $order->save();

            // // $order, $user, $productID, $productAttributeID, $quantity, $productPrice, $event, $type, $remarks, $userLevel, $note
            // Helper::addStockLog($order, $user, null, null, null, null, 'sold', 2, 'Product sold', 1, null);

            // $order, $user, $event, $type, $remarks, $userLevel, $note, $productID, $productAttributeID, $quantity, $productPrice
            Helper::addStockLog($order, $user, 'sold', 2, 'Product sold', 1, null, null, null, null, null);

            $logo = Helper::getLightLogo();

            if($user){
                $emailData = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $user->email);

                $emailDataAdmin = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }else{
                $config = Helper::getWebsiteConfig('country_code');

                $emailData = array('logo' => $logo, 'name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $order->email);

                $emailDataAdmin = array('logo' => $logo, 'name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }

            dispatch(new \App\Jobs\OrderPlacedQueue($emailData));

            dispatch(new \App\Jobs\OrderAdminPlacedQueue($emailDataAdmin));

            $order->history()->create(['status'=> 'Payment Done', 'type'=> 'payment_done']);

            //return redirect()->to('order-success/'.$order->order_unique_id);

            DB::commit();

            $config = Helper::getAccountingSettings('is_xero');
            $isXero = $config['is_xero'];
            if($isXero){
                Helper::createXeroInvoice($order);
            }

            return to_route('order.placed', ['order' => $order->order_unique_id]);

        }


        // $api = new RazorpayApi(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        // $verify = $api->utility->verifyPaymentSignature(
        //     array(
        //         'razorpay_order_id' => $razorpayOrderId,
        //         'razorpay_payment_id' => $razorpayPaymentId,
        //         'razorpay_signature' => $razorpaySignature
        //     )
        // );
        // if($verify){
        //     print 'a';
        // }else{
        //     print 'b';
        // }
        // die;
        // print_r($verify); die;



    }

    public function stripeRedirect(Request $request){



        $sessionId = $request->query('session_id');
        $status = $request->query('status');

        if (!$sessionId) {
            abort(400, 'Error');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = StripeCheckoutSession::retrieve($sessionId);
        // print '<pre>'; print_r($session); die;


        // payment_intent

        // order_id in the URL / Stripe's client_reference_id is authoritative; the session value
        // is only a fallback since the session cookie isn't guaranteed to survive the redirect to
        // and from Stripe's hosted checkout page.
        $uniqueID = $request->query('order_id') ?: ($session->client_reference_id ?: Session::get('stripe_express'));
        //print '<pre>'; print_R($data);

        //print_r($_GET); die;

        DB::beginTransaction();

        $order = Order::where('order_unique_id',$uniqueID)->first();
        //print '<pre>'; print_r($order); die;

        if (!$order) {
            DB::rollBack();
            return to_route('cart')->with('error', 'We could not find your order. If you were charged, please contact us so we can confirm your payment.');
        }

        $payment = $order->payments()->where('order_id',$order->id)->where('type','stripe_express_checkout')->where('payment_id',null)->latest()->first();
        //print '<pre>'; print_r($payment); die;

        if (!$payment) {
            DB::rollBack();
            return to_route('cart')->with('error', 'We could not find your payment record. If you were charged, please contact us so we can confirm your payment.');
        }

        $user = Auth::user();

        if ($session->payment_status === 'paid') {
            $payment->payment_id = $session->payment_intent;
            $payment->payment_response = json_encode($session);
            $payment->payment_status = 'Paid';
            $payment->status = 1;
            $payment->save();

            $order->order_status = 'Payment Done';
            $order->is_payment_done = 1;
            $order->status = 1;
            $order->save();


            // // $order, $user, $productID, $productAttributeID, $quantity, $productPrice, $event, $type, $remarks, $userLevel, $note
            // Helper::addStockLog($order, $user, null, null, null, null, 'sold', 2, 'Product sold', 1, null);

            // $order, $user, $event, $type, $remarks, $userLevel, $note, $productID, $productAttributeID, $quantity, $productPrice
            Helper::addStockLog($order, $user, 'sold', 2, 'Product sold', 1, null, null, null, null, null);

            $logo = Helper::getLightLogo();

            if($user){
                $emailData = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $user->email);

                $emailDataAdmin = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }else{
                $config = Helper::getWebsiteConfig('country_code');

                $emailData = array('logo' => $logo, 'name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $order->email);

                $emailDataAdmin = array('logo' => $logo, 'name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }

            dispatch(new \App\Jobs\OrderPlacedQueue($emailData));

            dispatch(new \App\Jobs\OrderAdminPlacedQueue($emailDataAdmin));

            $order->history()->create(['status'=> 'Payment Done', 'type'=> 'payment_done']);
        }else{

            // $_GET['payment_status'] = Failed     // case

            $payment->payment_id = $session->payment_intent;
            $payment->payment_response = json_encode($session);
            $payment->payment_status = 'Cancelled';
            //$payment->status = 0;
            $payment->save();

            $order->order_status = 'Payment Cancel';
            $order->is_payment_done = 0;
            $order->save();

            $order->history()->create(['status'=> 'Payment Cancel', 'type'=> 'payment_cancel']);
        }

        Session::forget('stripe_express');
        DB::commit();

        if($payment && $session->payment_status === 'paid'){
            $config = Helper::getAccountingSettings('is_xero');
            $isXero = $config['is_xero'];
            if($isXero){
                Helper::createXeroInvoice($order);
            }

            $cartObj = Helper::getCartObj($user);
            $cartObj->delete();

            return to_route('order.placed', ['order' => $order->order_unique_id]);
        }else{
            return to_route('order.placed', ['order' => $order->order_unique_id]);
        }


        // if ($status === 'cancel') {
        //     // User cancelled manually before paying
        //     // return view('stripe.cancel', ['session' => $session]);
        //     return to_route('order.placed', ['order' => $order->order_unique_id]);
        // }

        // // Otherwise, check the real payment status from Stripe
        // if ($session->payment_status === 'paid') {
        //     // ✅ Payment confirmed
        //     // Example: mark order as paid in DB
        //     // return view('stripe.success', ['session' => $session]);


        // payment_status == 'unpaid'
        // } else {
        //     // Payment failed or pending
        //     // return view('stripe.pending', ['session' => $session]);

        //     return to_route('order.placed', ['order' => $order->order_unique_id]);
        // }


    }


    public function checkoutStripeCard(Request $request){

        $user = Auth::user();

        $order = Order::where('order_unique_id',$request->order_id)->first();
        //print '<pre>'; print_r($order); die;

        // if($order->is_payment_done){
        //     return to_route('order.placed', ['order' => $order->order_unique_id]);
        // }

        $payment = $order->payments()->where('order_id',$order->id)->where('type','stripe_card')->where('payment_id',null)->latest()->first();
        //print '<pre>'; print_r($payment); die;

        if ($request->isMethod('post')){

            $paymentMethod = $request->input('payment_method');
            // print $paymentMethod; die;


            try {

                if($user){

                    $user->createOrGetStripeCustomer();
                    $user->updateDefaultPaymentMethod($paymentMethod);
                    // $stripeCharge = $user->charge(
                    //     100 * $payment->amount, $paymentMethod
                    // );
                    $stripeCharge = $user->safeCharge(
                        100 * $payment->amount, $paymentMethod
                    );

                }else{
                    $order->createOrGetStripeCustomer();
                    $order->updateDefaultPaymentMethod($paymentMethod);
                    // $stripeCharge = $order->charge(
                    //     100 * $payment->amount, $paymentMethod
                    // );
                    $stripeCharge = $order->safeCharge(
                        100 * $payment->amount, $paymentMethod
                    );
                }

                } catch (\Exception $exception) {
                    print $exception->getMessage(); die;
                    Helper::flashMessage(false, $exception->getMessage());
                    return to_route('order.placed', ['order' => $order->order_unique_id]);
                    //return back()->with('error', $exception->getMessage());
                }

                //print '<pre>'; print_r($stripeCharge); die;

                // $options = [

                //         //'off_session' => true,
                //     // 'automatic_payment_methods' => [
                //     //     'enabled' => false,
                //     //   ],
                // ];

                // if($user){
                //     $user->createOrGetStripeCustomer();
                //     $user->updateDefaultPaymentMethod($paymentMethod);
                //     $user->charge(100 * $payment->amount, $paymentMethod, $options);
                // }else{
                //     $order->createOrGetStripeCustomer();
                //     $order->updateDefaultPaymentMethod($paymentMethod);
                //     $order->charge(100 * $payment->amount, $paymentMethod, $options);
                // }
            // } catch (\Exception $exception) {
            //     print 'a'; print $exception->getMessage(); die;
            //     //return back()->with('error', $exception->getMessage());
            // }


            $payment->payment_id = $stripeCharge->latest_charge;
            $payment->payment_response = json_encode($stripeCharge);
            $payment->payment_status = 'Paid';
            $payment->status = 1;
            $payment->save();

            $order->order_status = 'Payment Done';
            $order->is_payment_done = 1;
            $order->status = 1;
            $order->save();


            // // $order, $user, $productID, $productAttributeID, $quantity, $productPrice, $event, $type, $remarks, $userLevel, $note
            // Helper::addStockLog($order, $user, null, null, null, null, 'sold', 2, 'Product sold', 1, null);

            // $order, $user, $event, $type, $remarks, $userLevel, $note, $productID, $productAttributeID, $quantity, $productPrice
            Helper::addStockLog($order, $user, 'sold', 2, 'Product sold', 1, null, null, null, null, null);

            $logo = Helper::getLightLogo();

            if($user){
                $emailData = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $user->email);

                $emailDataAdmin = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => $user->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }else{
                $config = Helper::getWebsiteConfig('country_code');

                $emailData = array('logo' => $logo, 'name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => $order->email);

                $emailDataAdmin = array('logo' => $logo, 'name' => $order->first_name.' '.$order->last_name, 'email' => $order->email, 'country_code' => $config['country_code'], 'phone' => $order->phone, 'order_no' => $order->order_no, 'order' => $order, 'to' => config('constants.EMAIL.send'));
            }

            dispatch(new \App\Jobs\OrderPlacedQueue($emailData));

            dispatch(new \App\Jobs\OrderAdminPlacedQueue($emailDataAdmin));

            $order->history()->create(['status'=> 'Payment Done', 'type'=> 'payment_done']);

            $config = Helper::getAccountingSettings('is_xero');
            $isXero = $config['is_xero'];
            if($isXero){
                Helper::createXeroInvoice($order);
            }

            return to_route('order.placed', ['order' => $order->order_unique_id]);

            //return to_route('order.placed', ['order' => $order->order_unique_id]);


        }else{
            $paymentMethods = [];
            if($user){
                //$intent = auth()->user()->createSetupIntent();
                $intent = $user->createSetupIntent();
                $paymentMethods = $user->paymentMethods()->get();
                // print '<pre>'; print_r($paymentMethods->toArray()); die;
            }else{
                //$orderObj = new Order();
                $intent = $order->createSetupIntent();
            }
            //print '<pre>'; print_r($intent); die;


            return view($this->prefix.'.'.$this->folder.'.stripe-payment')->with(compact('order','payment','intent','paymentMethods'));
        }









        // DB::commit();

        // if($payment && $request->payment_status == 'success' && isset($response) && $response['status'] == 'COMPLETED'){
        //     return to_route('order.placed', ['order' => $order->order_unique_id]);
        // }else{
        //     return to_route('order.placed', ['order' => $order->order_unique_id]);
        // }
    }

    public function checkoutRazorpay(Request $request){

        $user = Auth::user();

        $order = Order::where('order_unique_id',$request->order_id)->first();
        // print '<pre>'; print_r($order); die;
        $payment = $order->payments()->where('order_id',$order->id)->where('type','razorpay')->where('payment_id',null)->latest()->first();
        // print '<pre>'; print_r($payment->toArray()); die;

        // RazorpayApi
        $api = new RazorpayApi(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $razorData  = $api->order->create([
            'receipt' => '111',
            'amount' => $payment->amount * 100,
            'currency' => $payment->currency_iso_code
        ]); // Creates Razorpay order
        // print '<pre>'; print_r($razorData); die;
        $razorOrderID = $razorData['id'];
        $currency = $razorData['currency'];
        $payment->razorpay_order_id = $razorOrderID;
        $payment->save();

        return view($this->prefix.'.'.$this->folder.'.razorpay-payment')->with(compact('order','payment','currency','razorOrderID'));

    }

    public function getStates(Request $request){


        $country = trim($request->country);
        // print $country; die;

        $country = Country::where('code', $country)->first();
        // print_r($country); die;
        if(!$country){
            return array('result' => false, 'html' => '<option value="">Country not found</option>', 'message' => 'Country not found');
        }

        $states = $country->states()->get();
        // print '<pre>'; print_r($states); die;

        $html = '<option value="">--Select state--</option>';
        foreach($states as $state){
            $html .= '<option value="'.$state->code.'">'.$state->name.'</option>';
        }

        return array('result' => true, 'html' => $html);

    }

    public function getStateShipping(Request $request){

        $isExpress = Helper::isExpressShippingMethod($request->input('shipping_method'));

        // Express is a flat weight-only rate - no state/zone needed, so don't require
        // one to be selected. Only the zone-based rate below needs a resolved state.
        $state = null;

        if (!$isExpress) {
            $stateCode = trim($request->state);
            // print $stateCode; die;

            $state = State::where('code', $stateCode)->first();
            // print_r($state); die;
            if(!$state){
                return array('result' => false, 'message' => 'State not found');
            }
        }

        // return Helper::getStateShippingAmount($state);

        $checkout = Helper::checkout(null, true, $state, $isExpress);  // $user, $isShipping, $state, $isExpress
        // print '<pre>'; print_r($checkout); die;

        $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

        return array('checkout' => $checkout, 'html' => (String)View::make('front.checkout.pricing-section')->with(compact('checkout','isEnquiryWebsite')));



    }

    public function refreshPricingSection(Request $request){

        $user = Auth::user();
        $isExpress = Helper::isExpressShippingMethod($request->input('shipping_method'));
        $checkout = Helper::checkout($user, true, null, $isExpress);  // $user, $isShipping, $state, $isExpress
        // print '<pre>'; print_r($checkout); die;

        $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

        return array('checkout' => $checkout, 'html' => (String)View::make('front.checkout.pricing-section')->with(compact('checkout','isEnquiryWebsite')));



    }


    public function checkoutAddress(Request $request){
        // $user = Auth::user();
        $state = trim($request->state);
        // print $postal; die;

        $checkout = Helper::checkout(null, true, $state);  // $user, $isShipping, $state
        // print '<pre>'; print_r($checkout); die;

        $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

        return array('checkout' => $checkout, 'html' => (String)View::make('front.checkout.pricing-section')->with(compact('checkout','isEnquiryWebsite')));

    }





}
