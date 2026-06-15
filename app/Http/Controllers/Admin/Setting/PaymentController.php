<?php

namespace App\Http\Controllers\Admin\setting;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

use App\Models\Setting;

use Carbon\Carbon;
use App\Helper;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Image;
use Validator;
use Mail;


class PaymentController extends Controller implements HasMiddleware
{   
    private $pagerecords;
    private $prefix = 'admin';
    private $folder = 'setting.payment';

    public function  __construct(){
        // $this->middleware('auth:admin');
        $this->pagerecords = config('constants.ADMIN_PAGE_RECORDS');
    }

    public static function middleware()
    {
        return ['admin'];
    }

    
    public function payments(Request $request){ 

        $cashOnDelivery = Setting::where('key','cash_on_delivery')->first();
        $cashOnDeliveryDB = $cashOnDelivery ? $cashOnDelivery->value : null;
        
        $instamojo = Setting::where('key','instamojo')->first();
        $instamojoDB = $instamojo ? $instamojo->value : null;

        $paypal = Setting::where('key','paypal')->first();
        $paypalDB = $paypal ? $paypal->value : null;

        $stripeCard = Setting::where('key','stripe_card')->first();
        $stripeCardDB = $stripeCard ? $stripeCard->value : null;

        $razorpay = Setting::where('key','razorpay')->first();
        $razorpayDB = $razorpay ? $razorpay->value : null;


        if ($request->isMethod('post')) {

            $cashOnDeliveryForm = trim($request->input('cash_on_delivery'));
            $instamojoForm = trim($request->input('instamojo'));
            $paypalForm = trim($request->input('paypal'));
            $stripeCardForm = trim($request->input('stripe_card'));
            $razorpayForm = trim($request->input('razorpay'));

            $validationArray=array(
                'cash_on_delivery'=>'',
                'instamojo'=>'',
                'paypal'=>'',
                'stripe_card'=>'',
                'razorpay'=>'',
            );

            $request->validate($validationArray);

            $cashOnDeliveryFormDB = ($cashOnDeliveryForm == 'on') ? 1 : 0;
            $instamojoFormDB = ($instamojoForm == 'on') ? 1 : 0;
            $paypalFormDB = ($paypalForm == 'on') ? 1 : 0;
            $stripeCardFormDB = ($stripeCardForm == 'on') ? 1 : 0;
            $razorpayFormDB = ($razorpayForm == 'on') ? 1 : 0;
    
            if($cashOnDeliveryDB != $cashOnDeliveryFormDB){
                if($cashOnDelivery){
                    $cashOnDelivery->update(['value' => $cashOnDeliveryFormDB]);
                }else{
                    Setting::create(['key' => 'cash_on_delivery', 'value' => $cashOnDeliveryFormDB]);
                }
            }

            if($paypalDB != $paypalFormDB){
                if($paypal){
                    $paypal->update(['value' => $paypalFormDB]);
                }else{
                    Setting::create(['key' => 'paypal', 'value' => $paypalFormDB]);
                }
            }

            if($instamojoDB != $instamojoFormDB){
                if($instamojo){
                    $instamojo->update(['value' => $instamojoFormDB]);
                }else{
                    Setting::create(['key' => 'instamojo', 'value' => $instamojoFormDB]);
                }
            }
            
            if($stripeCardDB != $stripeCardFormDB){
                if($stripeCard){
                    $stripeCard->update(['value' => $stripeCardFormDB]);
                }else{
                    Setting::create(['key' => 'stripe_card', 'value' => $stripeCardFormDB]);
                }
            }
            
            if($razorpayDB != $razorpayFormDB){
                if($razorpay){
                    $razorpay->update(['value' => $razorpayFormDB]);
                }else{
                    Setting::create(['key' => 'razorpay', 'value' => $razorpayFormDB]);
                }
            }
            
            Helper::flashMessage(true, 'Payment settings added/updated successfully!');
            return redirect()->back();

        }

        $data = array('cashOnDeliveryDB' => $cashOnDeliveryDB, 'instamojoDB' => $instamojoDB, 'paypalDB' => $paypalDB, 'stripeCardDB' => $stripeCardDB, 'razorpayDB' => $razorpayDB);
        return view($this->prefix.'.'.$this->folder.'.payments')->with($data);
    }



}
