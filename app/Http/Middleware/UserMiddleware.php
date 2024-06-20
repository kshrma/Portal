<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has a 'user' role
        if (Auth::check() && Auth::user()->role == '1') {
            return $next($request);
        }
    
        // If not a user, redirect to admin dashboard
        return redirect('/admin/dashboard')->with('error', 'You do not have access.');
    }
}