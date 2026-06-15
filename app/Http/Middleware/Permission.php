<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helper;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, $data): Response
    {
        //print '<pre>'; print_R(Auth::guard('admin')->user()); die;
        //print '<pre>'; print_R($data); die;
        if (Auth::guard('admin')->check()) {
            if(Auth::guard('admin')->user()->level  == 0){
                return $next($request);
            }
            
            Auth::guard('admin')->user()->sectionCheck($data);
            if (Auth::guard('admin')->user()->level == 1 && Auth::guard('admin')->user()->sectionCheck($data)){
                //print 'aa'; die;
                return $next($request);
            }
            if(Auth::guard('admin')->user()->level == 1){
                Helper::flashMessage(true, 'You don\'t have access to that section');
                return to_route('admin.dashboard'); 
            }
        }
        //return to_route('admin.dashboard')->with('success',"You don't have access to that section"); 
        Helper::flashMessage(true, 'You don\'t have access to that section');
        return to_route('admin.dashboard');
    }

}
