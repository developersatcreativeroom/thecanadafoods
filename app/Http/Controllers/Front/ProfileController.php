<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Models\Order;
use App\Models\PaymentMethod;

use Carbon\Carbon;
use App\Helper;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Image;
use Validator;
use Mail;


class ProfileController extends Controller implements HasMiddleware
{   
    private $prefix = 'front';
    private $folder = 'profile';

    // public function  __construct(){
    //     $this->middleware('auth');
    // }

    public static function middleware()
    {
        return ['auth'];
    }

    public function profile(Request $request)
    {  
        return view($this->prefix.'.'.$this->folder.'.profile');
    }

    public function addresses(Request $request)
    {  
        
        $user = Auth::user();

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

        return view($this->prefix.'.'.$this->folder.'.addresses')->with(compact('addresses','addressBilling','addressShipping'));
        
    }

    public function address(Request $request)
    {   
        $user = Auth::user();
        $countries = Helper::getCountries();

        if ($request->isMethod('post')){

            // if($request->ajax()){
            //     print 'ajax';
            // }else{
            //     print 'no ajax';
            // }
            // die;
      
            $id = trim($request->id);
            $firstName = trim($request->first_name);
            $lastName = trim($request->last_name);
            $companyName = trim($request->company_name);
            $email = trim($request->email);
            $phone = trim($request->phone);
            $addressLine1 = trim($request->address_line_1);
            $addressLine2 = trim($request->address_line_2);
            $street = trim($request->street);
            $city = trim($request->city);
            $state = trim($request->state);
            $country = trim($request->country);
            $postal = trim($request->postal);
            

            $validationArray = array(
                'first_name'=>'required',
                'last_name'=>'required',
                'company_name'=>'',
                'email' => 'required|email',
                'phone' => 'required|numeric|digits:10',
                'street'=>'',
                'address_line_1'=>'required',
                'address_line_2'=>'',
                'city'=>'required',
                'state'=>'required',
                'country'=>'required',
                'postal'=>'required|numeric',
            );

            $request->validate($validationArray);
            // $this->validate(request(), );

            $user=Auth::user();

            DB::beginTransaction();

            $address = $user->addresses();
            $address->update(['is_default' => 0]);
            if($id == null){
                $config = Helper::getWebsiteConfig('country_code');
                $query = $address->create(['first_name'=>$firstName, 'last_name'=>$lastName, 'is_default'=>1,  'company_name'=> $companyName, 'email'=>$email, 'country_code'=>$config['country_code'], 'phone'=>$phone, 'street'=>$street, 'address_line_1'=>$addressLine1, 'address_line_2'=>$addressLine2, 'city'=>$city, 'state'=>$state, 'country'=>$country, 'postal'=>$postal]);
            }else{
                $addressUpdate = $address->find($id);
                
                $addressUpdate->first_name = $firstName;
                $addressUpdate->last_name = $lastName;
                $addressUpdate->is_default = 1;
                $addressUpdate->company_name = $companyName;
                $addressUpdate->email = $email;
                $addressUpdate->phone = $phone;
                $addressUpdate->street = $street;
                $addressUpdate->address_line_1 = $addressLine1;
                $addressUpdate->address_line_2 = $addressLine2;
                $addressUpdate->city = $city;
                $addressUpdate->state = $state;
                $addressUpdate->country = $country;
                $addressUpdate->postal = $postal;
                $query = $addressUpdate->save();
            }
            
            if($query){
                DB::commit();
                $message = 'Address added/updated successfully';
                if($request->ajax()){
                    $address = Helper::getDefaultBillingAndShippingAddress($user);
                    $addressBilling = $address['billing'];
                    $addressShipping = $address['shipping'];
                    if($user){
                        $addressesObj = $user->addresses();
                        $addresses = $addressesObj->get();
                        $paymentMethods = $user->paymentMethods()->get();
                    }else{
                        $addresses = [];
                        $paymentMethods = [];
                    }

                    $checkout = Helper::checkout($user, true);  // $user, $isShipping, $state
                    // print '<pre>'; print_r($checkout); die;
                    $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
                    $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

                    $allowedPaymentMethods = Helper::getPaymentSettings();

                    // print (String)View::make('front.checkout.place-order-section')->with(compact('addresses','checkout','isEnquiryWebsite','allowedPaymentMethods')); die;


                    return array('result' => true, 'message' => $message, 'address_html' => (String)View::make('front.checkout.address-section')->with(compact('addresses','addressBilling','addressShipping')), 'price_html' => (String)View::make('front.checkout.pricing-section')->with(compact('checkout','isEnquiryWebsite')), 'place_order_html' => (String)View::make('front.checkout.place-order-section')->with(compact('addresses','checkout','isEnquiryWebsite','paymentMethods','allowedPaymentMethods')));
                    
                }else{
                    Helper::flashMessage(true, $message);
                    return to_route('addresses');
                }
            }else{
                $message = 'Something went wrong';
                if($request->ajax()){
                    return array('result' => false, 'message' => $message);
                }else{
                    Helper::flashMessage(false, $message);
                    return to_route('addresses');
                }    
            }
        
        
        }


        //print_r($addresses); die;
        
        return view($this->prefix.'.'.$this->folder.'.address')->with(compact('countries'));
        
    }

    public function addressEdit(Request $request, $id)
    {   
        $user=Auth::user();
        $address = $user->addresses()->find($id);
        if(!$address){
            return to_route('addresses');
        }
        $countries = Helper::getCountries();
        if($request->ajax()){
            return array('result' => true, 'address' => $address);
        }else{
            return view($this->prefix.'.'.$this->folder.'.address')->with(compact('address','countries'));
        }
        
    }

    public function setDefaultAddress(Request $request)
    {   
        $key = $request->key;

        $user=Auth::user();
        $addressesObj = $user->addresses();
        $address = $user->addresses()->find($key);
        if(!$address){
            return array('result'=>false);
        }

        //print_r($addresses); die;

        $addressesObj->update(['is_billing' => 0, 'is_shipping' => 0, 'is_default' => 0]);

        $address->is_default = 1;
        $address->save();
        


        return array('result'=>true, 'message' => 'Default address selected successfully');
    }

    public function fetchAddresses(Request $request)
    {   
        $user=Auth::user();
        $addresses = $user->addresses()->get();

        $type = $request->type;

        if($type == 'billing'){
            $defaultAddress = Helper::getDefaultBillingAddress($user);
        }
        if($type == 'shipping'){
            $defaultAddress = Helper::getDefaultShippingAddress($user);
        }

        $html = '<div class="row g-5">';
        foreach($addresses as $address){

            $html .= '<div class="col-md-6 align-self-end">
                        <div class="address-book-content ps-md-4">
                            
                            <div class="address">';

                            $html .='<a class="btn-small edit-address-modal" data-key="'.$address->id.'">Edit</a><br>';

                            if($defaultAddress->id != $address->id){
                                $html .='<a class="btn-small select-address" data-type="'.$type.'" data-key="'.$address->id.'" >Select '.ucfirst($type).'</a>';
                            }

                            

                            if($address->company_name != null){
                                $html .= '<p class="mb-2"><span class="text-dark fw-bold mb-1">Company:</span> '.$address->company_name.'</p>';
                            }else{
                                $html .='<br>';
                            }


                            $html .='<p class="text-dark fw-bold mb-1">'.$address->first_name.' '.$address->last_name.'</p>

                            <p class="mb-0"><span class="text-dark fw-bold mb-1">Email:</span> '.$address->email.'</p>

                            <p><span class="text-dark fw-bold mb-1">Phone:</span> +'.$address->country_code.'-'.$address->phone.'</p>

                            <p class="mb-0">
                                '.$address->address_line_1.' '.$address->address_line_2.' '.$address->street.'<br> 
                                '.$address->city.', '.$address->state.', '.$address->postal.'</br>
                            '.$address->country.'</p>
                            
                        </div>
                    </div>
                </div>
            
            ';


        //     $html .= '<div class="col-6">
        //         <div class="card mb-3">
        //         <div class="card-header">

        //         <div class="d-flex justify-content-between">
        //             <h5 class="mb-0">'.$address->first_name.' '.$address->last_name.'</h5>';
        //             if($defaultAddress->id != $address->id){
        //                 $html .='<a class="btn btn-sm btn-fill-out select-address" data-type="'.$type.'" data-key="'.$address->id.'" >Select '.ucfirst($type).'</a>';
        //             }

        //             $html .='</div>
        //     </div>
        //     <div class="card-body">
        //         <address>';
        //         if($address->company_name != null){
        //             $html .= '<strong>Company:</strong> '.$address->company_name.',<br>';
        //         }
        //         $html .= '<strong>Email:</strong> '.$address->email.' <br>
        //         <strong>Phone:</strong> +'.$address->country_code.'-'.$address->phone.' <br>    
        //         '.$address->apartment.' '.$address->street.'<br> 
        //             '.$address->city.', '.$address->state.', '.$address->postal.'</address>
        //         <p>'.$address->country.'</p>
                
        //         <div class="d-flex justify-content-end">
        //             <a class="btn-small edit-address-modal" data-key="'.$address->id.'">Edit</a>
        //         </div>
        //     </div>
        //     </div>
        // </div>';
        }
 
        $html .= '<div class="row">
                    <div class="col">
                    <div class="add-new-address">
                        <a class="btn btn-primary mt-10 ms-5" id="add-address-modal">Add Address</a>
                    </div>
                    </div>
                </div>';

        // $html .= '</div>';
        
        if($addresses){
            return array('result'=>true, 'html' => $html);
        }else{
            return array('result'=>false);
        }
        
    }


    public function selectAddress(Request $request)
    {   
        $type = $request->type;
        $key = $request->key;

        $user=Auth::user();
        $addressesObj = $user->addresses();
        $address = $user->addresses()->find($key);
        if(!$address){
            return array('result'=>false);
        }

        //print_r($addresses); die;

        if($type == 'billing'){
            $addressesObj->update(['is_billing' => 0]);
            $address->update(['is_billing' => 1]);
        }
        
        if($type == 'shipping'){
            $addressesObj->update(['is_shipping' => 0]);
            $address->update(['is_shipping' => 1]);
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

        $checkout = Helper::checkout($user, true);  // $user, $isShipping, $state
        // print '<pre>'; print_r($checkout); die;
        $isEnquiryWebsite = Helper::getWebsiteConfig('is_enquiry_website');
        $isEnquiryWebsite = $isEnquiryWebsite['is_enquiry_website'];

        $allowedPaymentMethods = Helper::getPaymentSettings();

        
        return array('result' => true, 'address_html' => (String)View::make('front.checkout.address-section')->with(compact('addresses','addressBilling','addressShipping')), 'price_html' => (String)View::make('front.checkout.pricing-section')->with(compact('checkout','isEnquiryWebsite')), 'place_order_html' => (String)View::make('front.checkout.place-order-section')->with(compact('addresses','checkout','isEnquiryWebsite','allowedPaymentMethods')), 'message' => 'Address selected successfully');

        // return array('result'=>true, 'html' => (String)View::make('front.checkout.address-section')->with(compact('addresses','addressBilling','addressShipping')), 'message' => 'Address selected successfully');
    }

    
    
    

    public function orders(Request $request)
    {   
        $user=Auth::user();
        $orders = $user->orders()->get();
        //print '<pre>'; print_R($orders); die;
        return view($this->prefix.'.'.$this->folder.'.orders')->with(compact('orders'));
    }

    public function order(Request $request, $order_unique_id)
    {   
        $user=Auth::user();
        $order = $user->orders()->where('order_unique_id', $order_unique_id)->first();
        if(!$order){
            return to_route('orders');
        }
        //print '<pre>'; print_R($order); die;
        if(!$order){
            return to_route('home');
        }
        if($user){
            $order->first_name = $user->first_name;
            $order->last_name = $user->last_name;
            $order->email = $user->email;
            $order->country_code = $user->country_code;
            $order->phone = $user->phone;
        }
        return view($this->prefix.'.'.$this->folder.'.order')->with(compact('order'));
    }

    public function orderInvoice(Request $request,$order_unique_id){
        $user=Auth::user();
        $order = $user->orders()->select('orders.*','users.first_name','users.last_name','users.email','users.phone')->leftjoin('users','users.id','=','orders.user_id')->with([
            'products', 'billing','shipping','history','payment' => function($query){
            $query->where('status',1);
        }])->where('order_unique_id', $order_unique_id)->first();
        // print '<pre>'; print_R($order); die;
        if($order == null){
            return to_route('orders');
        }
        if(!$order){
            return to_route('home');
        } 
        if($user){
            $order->first_name = $user->first_name;
            $order->last_name = $user->last_name;
            $order->email = $user->email;
            $order->country_code = $user->country_code;
            $order->phone = $user->phone;
        }
        return view($this->prefix.'.'.$this->folder.'.order-invoice')->with(compact('order'));
    }
    
    public function enquiries(Request $request)
    {   
        $user=Auth::user();
        $enquiries = $user->enquiries()->get();
        //print '<pre>'; print_R($enquiries); die;
        return view($this->prefix.'.'.$this->folder.'.enquiries')->with(compact('enquiries'));
    }

    public function enquiry(Request $request, $enquiry_unique_id)
    {   
        $user=Auth::user();
        $enquiry = $user->enquiries()->where('enquiry_unique_id', $enquiry_unique_id)->first();
        if(!$enquiry){
            return to_route('enquiries');
        }
        //print '<pre>'; print_R($enquiry); die;
        if(!$enquiry){
            return to_route('home');
        }
        if($user){
            $enquiry->first_name = $user->first_name;
            $enquiry->last_name = $user->last_name;
            $enquiry->email = $user->email;
            $enquiry->country_code = $user->country_code;
            $enquiry->phone = $user->phone;
        }
        return view($this->prefix.'.'.$this->folder.'.enquiry')->with(compact('enquiry'));
    }


    public function changePassword(Request $request)
    {   
        if ($request->isMethod('post')) {
            $old = $request->old_password;
            $new = $request->new_password;
            $confirm = $request->confirm_password;
                
            $validator=array(
                'old_password'=>'required',
                'new_password'=>'required|min:6',
                'confirm_password'=>'required|same:new_password|min:6',
            );
            $request->validate($validator);
            $user = Auth::user();
    
            if ((Hash::check($old , $user->password)) == false) {
                Helper::flashMessage(false,'Old password mismatch!');
                return to_route('change.password');
    
            } else if ((Hash::check($new, $user->password)) == true) {
                Helper::flashMessage(false,'Please enter a password different from current');
                return to_route('change.password');
            } 
    
            $user->password = Hash::make($new);
            $query = $user->save();
    
            if($query){
                Helper::flashMessage(true,'Password updated successfully!');
            }else{
                Helper::flashMessage(false,'Something went wrong');
            }
            
            return to_route('change.password');
        }

        return view($this->prefix.'.'.$this->folder.'.change-password');
    }


    function verificationNotification(Request $request) {
        $user=Auth::user();
        if($user->email_verified_at != null){
            return array('result' => true, 'message' => 'Email is already verified');
        }

        try{
            $result = $request->user()->sendEmailVerificationNotification();
            // print '<pre>'; print_r($result); die;
            // if($result){
                return array('result' => true, 'message' => 'Verification link sent!', 'html_message' => 'The verification link is sent to your email address, please check your email.');
            // }else{
            //     return array('result' => false, 'message' => 'Something went wrong');
            // }
            
        }
        catch(\Exception $e){
            // print '<pre>'; print_r($e->getMessage()); die;
            return array('result' => false, 'message' => 'Something went wrong');
        }

        // Helper::flashMessage(true,'Verification link sent!');
        // return back();
    }

    function verificationVerify(EmailVerificationRequest $request) {
        $request->fulfill();
        Helper::flashMessage(true,'Email verified successfully!');
        // return back();
        return to_route('home');
    }

    function savePaymentMethod(Request $request) {

        $validationArray = array(
            'payment_method'=>'required'
        );

        $request->validate($validationArray);

        $user = Auth::user();

        $paymentMethod = $request->payment_method;
        // print $paymentMethod; die;

        // Create Stripe customer if not exists
        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        // Add method to Stripe
        $user->addPaymentMethod($paymentMethod);

        // Set as default
        $user->updateDefaultPaymentMethod($paymentMethod);

        // Get the Stripe payment method details
        $stripePM = $user->findPaymentMethod($paymentMethod);
        // print '<pre>'; print_r($stripePM); die;

        // Optionally set all others as non-default
        $user->paymentMethods()->where('user_id', $user->id)->update(['is_default' => false]);

        // Save locally
        $paymentMethod = $user->paymentMethods()->create([
            'user_id' => $user->id,
            'type' => $stripePM->type,
            'payment_method' => $stripePM->id,
            'provider' => $stripePM->card->brand,
            'last_four' => $stripePM->card->last4,
            'is_default' => true,
        ]);

        if($paymentMethod){
            return array('result' => true);
        }else{
            return array('result' => false);
        }
        
        
    }

}
