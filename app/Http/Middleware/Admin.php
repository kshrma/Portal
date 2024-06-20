<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has an 'admin' role
        if (Auth::check() && Auth::user()->role == '0') {
            return $next($request);
        }

        // If not an admin, redirect to user dashboard
        return redirect('/dashboard')->with('error', 'You do not have admin access.');
    }
}