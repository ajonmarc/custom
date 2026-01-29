<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            abort(401, 'Please log in to continue.');
        }

        // Check if user has required role
        if (!$request->user()->hasAnyRole($roles)) {
            abort(403, 'You do not have the required permissions to access this resource.');
        }

        return $next($request);
    }
}