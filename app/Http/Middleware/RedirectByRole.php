<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (auth()->user()->hasRole('superadmin')) {
                return redirect()->route('superadmin.dashboard');
            }

            if (auth()->user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            if (auth()->user()->hasRole('user')) {
                return redirect()->route('user.dashboard');
            }
        }

        return $next($request);
    }
}
