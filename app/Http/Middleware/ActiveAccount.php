<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ActiveAccount
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
        if(Auth::check() && Auth::user()->is_active) {
            return $next($request);
        } else {
            return redirect('/login')->with('error', 'Your account has been disabled, please contact the management to resolve this issue.');
        }
    }
}
