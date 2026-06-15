<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Carbon\Carbon;
use App\Helper;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\View;
use Illuminate\Auth\Events\PasswordReset;
use Image;
use Validator;
use Mail;
use Str;

use Laravel\Socialite\Facades\Socialite;


class GoogleLoginController extends Controller
{   
    private $prefix = 'front';
    private $folder = 'front';
    private $pagerecords;

    public function  __construct(){
        $this->pagerecords = config('constants.FRONT_PAGE_RECORDS');
    }

    
    public function googleLogin(){
        // print 'a'; die;

        return Socialite::driver('google')->redirect();

        // $data = array('categories' => $categories, 'banners' => $banners, 'brands' => $brands, 'videos' => $videos);
        // return view($this->prefix.'.index')->with($data);
    }
    
    public function googleLoginRedirect(){
        //  print 'b'; die;
        
        $googleUser = Socialite::driver('google')->stateless()->user();
        // print '<pre>'; print_r($googleUser); die;
        // $googleUser->user['given_name'];
        // $googleUser->user['family_name'];
        // $googleUser->user['picture'];
        
        $user = User::where('email', $googleUser->email)->first();

        $register = false;

        if(!$user){
            $config = Helper::getWebsiteConfig('country_code');
            $user = User::create(['first_name' => $googleUser->user['given_name'], 'last_name' => $googleUser->user['family_name'], 'country_code' => $config['country_code'], 'email' => $googleUser->email, 'password' => \Hash::make(rand(100000,999999))]);

            $register = true;

            

        }

        Auth::login($user);

        if($register){
            $logo = Helper::getLightLogo();
            $emailData = array('logo' => $logo, 'name' => $user->first_name.' '.$user->last_name, 'email' => $user->email, 'country_code' => $user->country_code, 'phone' => '', 'to' => $user->email);

            dispatch(new \App\Jobs\RegistrationQueue($emailData));
        }

        if($register){
            Helper::flashMessage(true, 'Registered and Logged in successfully');
        }else{
            Helper::flashMessage(true, 'Logged in successfully');
        }
        return to_route('home');
    }


    public function demo(Request $request){

        //$data=array('email'=>'singhashu95@gmail.com');
        //$data=array('email'=>'amardeep0602@hotmail.com'); 
        $data=array('email'=>config('constants.EMAIL.send')); 
        //$data=array('email'=>'admin@milduratrading.com');
        Mail::send('emails.demo', $data, function($message) use ($data)
        {
            $message->from('amardeep0602@hotmail.com', "Demo testing");
            $message->subject("Demo testing");
            $message->to($data['email']);
        });
        // if(Mail::flushMacros()){
        //     print 'sent';
        // }else{
        //     print ' not sent';
        // }
        die;
      
        
    }


}
