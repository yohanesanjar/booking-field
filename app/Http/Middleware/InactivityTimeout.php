<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class InactivityTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $timeout = 1800) // 1800 seconds (30 minutes) by default
    {
        if (Auth::check()) {
            $lastActivity = Session::get('last_activity');
            $currentTime = time();

            if ($lastActivity && ($currentTime - $lastActivity > $timeout)) {
                Auth::logout(); // Log the user out
                Session::flush(); // Clear the session data
                return redirect('/')->with('message', 'Anda telah keluar karena tidak aktif');
            }

            // Update the last activity timestamp
            Session::put('last_activity', $currentTime);
        }

        return $next($request);
    }
}
