<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     * Redirect to dashboard if already authenticated.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('jwt_token')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
