<?php

namespace App\Http\Middleware;

// use Auth;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserLoginRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) { // Ensure the user is authenticated
            if (Auth::user()->status == 'admin') {
                return redirect()->route('dashborad'); // Correct route name
            } else {
                return redirect()->route('Home');
            }
        }
    
        return $next($request); // Continue to the intended route if not authenticated
    }
}
