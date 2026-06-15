<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Helper;

class AuthController extends Controller implements HasMiddleware
{
    // public function  __construct(){
    //     $this->middleware('guest:admin', ['except' => ['index']]);
    // }

    public static function middleware()
    {  
        // return ['guest:admin'];
        return [
            new Middleware('guest:admin', except: ['index'])
        ];
        
    }

    public function login(Request $request)
    {
    	if($request->isMethod('post'))
    	{
  
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
    
            $credentials['status'] = 1;
    
            if ( Auth::guard('admin')->attempt( $credentials ) ) {
                    $request->session()->regenerate();
                    if( Auth::guard('admin')->user()->status == config('constants.STATUS.inactive') ){
                        Auth::guard('admin')->logout();
                        Helper::flashMessage(false,'Account deactivated');
                        return redirect()->back();
                    }else{
                        Helper::flashMessage(true,'Logged in successfully!');
                        return to_route('admin.dashboard');
                    }             
            }            
            Helper::flashMessage(false,'Invalid Credentials');
            return back()->withInput();
    	}
    	return view('admin.auth.login');

    }


    
}
