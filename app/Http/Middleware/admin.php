<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class admin
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
        $User=Auth::user();
        // dd($User);
        if($User['admin']!="Y"){
            return redirect('/login');
        }
        return $next($request);
    }
}
