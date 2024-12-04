<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $previousActivity = $user->last_activity;
            
            // Update last activity timestamp
            $user->update(['last_activity' => now()]);

            // Log activity if more than 5 minutes have passed since last activity
            if (!$previousActivity || now()->diffInMinutes($previousActivity) > 5) {
                activity()
                    ->causedBy($user)
                    ->withProperties([
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'route' => $request->route()->getName() ?? 'unnamed-route',
                    ])
                    ->log('User activity detected');
            }
        }

        return $next($request);
    }
}