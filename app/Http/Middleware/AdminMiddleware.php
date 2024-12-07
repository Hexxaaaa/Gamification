<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            // Redirect to dashboard with error message if not admin
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
            }
            return redirect()->route('user.dashboard')
                           ->with('error', 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
}