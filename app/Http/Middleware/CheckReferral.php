<?php

namespace App\Http\Middleware;

use Closure;

class CheckReferral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasCookie('referral')) {
            return $next($request);
        } else {
            if ($request->query('ref')) {
                return redirect($request->fullUrl())->withCookie(cookie('referral', $request->query('ref'), 86400));
            }
        }
        return $next($request);
    }
}
