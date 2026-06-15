<?php

namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\User;

use Illuminate\Support\Facades\DB;

//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Hash;
use Auth;
use Session;
use Validator;
use Mail;
use App\Helper;

class AuthController extends Controller implements HasMiddleware
{
    private $prefix = 'front';
    private $folder = 'auth';

    // public function __construct()
    // {
    //     $this->middleware(['guest'])->except('logout');
    // }

    public static function middleware()
    {
        // return ['guest'];
        return [
            new Middleware('guest', except: ['logout'])
        ];
    }

    public function login(Request $request){
       
        
        if ($request->isMethod('post')){

            $validationArray = array(
                //'email'=>'required|regex:/^.+@.+$/i',
                'email'=>'required|email',
                'password'=>'required|min:5'
            );
            
            $request->validate($validationArray);
            //print 'a'; die;
            //print $request->user_type; die;

            $credentials=['email'=>$request->email,'password'=>$request->password];        
            $remember=isset($request->remember) ? true : false;

            $cartObj = Helper::getCartObj(null);
            $cartWithoutLogin = $cartObj->get();
            //print '<pre>'; print_r($cartWithoutLogin); die;

                $login = Auth::attempt($credentials, $remember);
                if($login){
                    Helper::flashMessage(true, 'Logged in successfully');
                    
                    Helper::saveCartToUser($cartWithoutLogin);

                }else{
                    Helper::flashMessage(false, 'Something went wrong');
                    return to_route('login');
                }
                return to_route('home');
                  
        }        

        return view($this->prefix.'.'.$this->folder.'.login-register');
    }

    public function register(Request $request){

        if ($request->isMethod('post')){

            $firstName = trim($request->first_name);
            $lastName = trim($request->last_name);
            $email = trim($request->email);
            $phone = trim($request->phone);
            $password = trim($request->password);
            $confirmPassword = trim($request->confirm_password);

            

            $validationArray = array(
                //'email'=>'required|regex:/^.+@.+$/i',
                'email'=>'required|email|unique:users,email',
                'password' => 'required|min:6|required|same:confirm_password',
                'confirm_password' => 'required|same:password|min:6',
                'first_name'=>'required',
                'last_name'=>'required',
                'phone'=>'required|numeric|digits:10',
                'privacy'=>'required'
            );

            $request->validate($validationArray);
            //print 'a'; die;

            //print $request->last_name; die;

            if($request->password != $request->confirm_password){
                Helper::flashMessage(false, 'Passsword and confirm password do not match');
                return redirect()->back()->withInput($request->only('email','privacy'));
            }

            $hashed = Hash::make($request->password);

            DB::beginTransaction();

            $config = Helper::getWebsiteConfig('country_code');

            $user=User::create([
                'email' => $email,            
                'first_name' => $firstName,
                'last_name' => $lastName,
                'country_code' => $config['country_code'],
                'phone' => $phone,
                'password' => $hashed,            
            ]);

            if(!$user){
                Helper::flashMessage(false, 'Something went wrong');
                return redirect()->back()->withInput($request->only('email','privacy'));
            }

            $cartObj = Helper::getCartObj(null);
            $cartWithoutLogin = $cartObj->get();
            //print '<pre>'; print_r($cartWithoutLogin); die;

            $credentials=['email'=>$user->email,'password'=>$password];
            //print '<pre>'; print_r($credentials); die;

            $remember=false;
            $login = Auth::attempt($credentials, $remember);
         
            $logo = Helper::getLightLogo();
            $emailData = array('logo' => $logo, 'name' => $firstName.' '.$lastName, 'email' => $email, 'country_code' => $config['country_code'], 'phone' => $phone, 'to' => $email);

            dispatch(new \App\Jobs\RegistrationQueue($emailData));

            //print 'a'; die;

            DB::commit();


            if($login){
                Helper::saveCartToUser($cartWithoutLogin);
                
                Helper::flashMessage(true, 'Registered and Logged in successfully');
            }else{
                Helper::flashMessage(false, 'Something went wrong');
            }
            return to_route('home');

        }

        return view($this->prefix.'.'.$this->folder.'.login-register');
        
    }


    public function logout(Request $request)
    {
        Auth::logout();
        Helper::flashMessage(true, 'Logged out successfully');
        return to_route('home');
    }

}
