<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorporateadminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->has('CORPORATEADMIN_LOGIN'))
        {
           
        }
        else{
            $request->session()->flash('error','Acess Denied');
            return redirect('corporateadmin/login');
        }
        return $next($request);
    }
}
