<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only check if user is logged in
        if (auth()->check()) {

            // If user is deactivated
            if (!auth()->user()->is_active) {

                // Log them out
                auth()->logout();

                // Invalidate session
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Redirect to login with message
                return redirect()->route('login')
                    ->with('error', 'Your account has been deactivated. Please contact admin.');
            }
        }

        return $next($request);
    }
}