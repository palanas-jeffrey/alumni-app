<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\StrongPassword;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            $validated = $request->validateWithBag('updatePassword', [
                'current_password' => ['required', 'current_password:admin'],
                'password' => ['required', 'confirmed', new \App\Rules\StrongPassword()],
            ]);

            $request->user('admin')->update([
                'password' => Hash::make($validated['password']),
            ]);
        } else {
            $validated = $request->validateWithBag('updatePassword', [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', new \App\Rules\StrongPassword()],
            ]);
    
            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return back()->with('status', 'password-updated');
    }
}
