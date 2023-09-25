<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and their status is 'Enabled'
        if (Auth::check() && Auth::user()->status === 'Enabled') {
            return $next($request);
        }
        // If the user is not enabled, redirect or respond with an error
        return redirect()->route('login')->with('error', 'Your account is disabled.');
    }

}
