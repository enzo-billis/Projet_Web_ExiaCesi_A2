<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckIfMemberBDE
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
        if(Auth::user()->rang == 1)
        return $next($request);
        else {
            return redirect('home');
        }
    }

}
