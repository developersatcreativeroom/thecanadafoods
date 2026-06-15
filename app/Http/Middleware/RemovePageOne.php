<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemovePageOne
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->query('page') == 1) {
            // Remove 'page' query
            $query = $request->except('page');
            $url = $request->url();

            if (!empty($query)) {
                $url .= '?' . http_build_query($query);
            }

            return redirect($url, 301);
        }
        return $next($request);
    }
}
