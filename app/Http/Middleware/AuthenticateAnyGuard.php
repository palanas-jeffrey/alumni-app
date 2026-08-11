<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAnyGuard
{
    public function handle($request, Closure $next)
    {
        if (!auth()->guard('admin')->check() || !auth()->guard('web')->check()) {
            return $next($request);
        }

        return redirect('/login');
    }
}

