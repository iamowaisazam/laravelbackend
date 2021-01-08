<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckApi
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
      
        return $next($request);
       // ->header('Access-Control-Allow-Origin', '*');
    
    }
}
