<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

class guestOrVerified extends EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if(!Auth::check())
        {
            return $next($request);
        }

        return parent::handle($request, $next, $redirectToRoute);
    }
}
