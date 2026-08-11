<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class CheckAccountActivation
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        // Check the account_activations table for activation
        $isActivated = DB::table('account_activations')
            ->where('user_id', $user->id)
            ->where('is_activated', true)
            ->exists();

        if (!$isActivated) {
            return redirect()->route('getting-ready');
        }

        return $next($request);
    }
}