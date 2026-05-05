<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApi
{
    /**
     * Handle an incoming request.
     * Redirect to login if no JWT token in session.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('jwt_token')) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        return $next($request);
    }
}
