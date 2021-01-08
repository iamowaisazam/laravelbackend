<?php

namespace App\Http\Middleware;
use Session;
use Closure;
use Config;
use App;

class LanguageChange
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
        if(!Session::has('locale')){
            Session::put('locale',Config::get('app.locale'));
        }

        
       App::setlocale(Session::get('locale'));
         
        return $next($request);
    }
}
