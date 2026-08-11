<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserSessionController extends Controller
{
    public function logout(Request $request)
    {
        // Logout the user
        Auth::logout();

        // Invalidate the user's session
        $request->session()->invalidate();

        // Regenerate the CSRF token to prevent session fixation attacks
        $request->session()->regenerateToken();

        // Redirect to the login or home page
        return redirect('/login');
    }
}
