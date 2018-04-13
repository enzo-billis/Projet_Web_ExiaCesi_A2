<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckIfEmployee
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
        if(Auth::user()->rang == 2)
            return $next($request);
        else {
            return redirect('home');
        }
    }
}
