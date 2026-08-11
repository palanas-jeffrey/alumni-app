<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAdminRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedAdminSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login-admin');
    }

    public function store(LoginAdminRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'Invalid credentials.'
            ]);
        }

        $request->session()->regenerate();

        $admin = Auth::guard('admin')->user();

        return redirect()->intended(route('admin-dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/welcome');
    }
}
