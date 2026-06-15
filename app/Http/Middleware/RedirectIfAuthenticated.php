<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {

            if ($guard === 'admin' && Auth::guard($guard)->check()) {
                // print 'a'; die;
                // return redirect('admin/dashboard');
                return to_route('admin.dashboard');
            }

            if (Auth::guard($guard)->check()) {
                return to_route('home');
            }
        }

        return $next($request);
    }
}
