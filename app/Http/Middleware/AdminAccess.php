<?php

namespace App\Http\Middleware;
// use Auth;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $status):Response
    {   
        // dd(Auth::user());
        if(Auth::user()->status==$status){
            return $next($request);
        }
        else{
            return redirect()->route('Home');
        }
    }
}
