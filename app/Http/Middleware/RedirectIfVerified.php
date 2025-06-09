<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if a user is logged in and if they have already verified their email.
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            // If they are verified, redirect them to the 'home' route.
            return Redirect::route('home');
        }

        // Otherwise, allow them to proceed to the verification notice page.
        return $next($request);
    }
}