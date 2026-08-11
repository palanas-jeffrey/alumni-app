<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Program;
use App\Rules\StrongPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $programs = Program::select('id', 'program_name')->get();

        return view('accounts.registration', compact('programs'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {  
        $request->validate([
            'first_name' => ['required', 'string','max:255'],
            'last_name' => ['required', 'string','max:255'],
            'middle_name' => ['required', 'string','max:255'],
            'maiden_name' => ['nullable', 'string','max:255'],
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'civil_status' => ['required','in:single,married,widowed,seperated'],
            'program_id' => ['required', 'integer', 'exists:programs,id'],
            'permanent_address' => ['required', 'string','max:255'],
            'current_address' => ['required', 'string','max:255'],
            'mobile_number' => ['nullable', 'string', 'regex:/^[0-9]{10}$/', 'size:10'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'alumni_id' => ['required', 'string', 'regex:/^ALU-\d{4}-\d{4}$/', 'max:50', 'unique:users,alumni_id'],
            'password' => ['required', 'confirmed', new \App\Rules\StrongPassword()],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'maiden_name' => $request->maiden_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'civil_status' => $request->civil_status,
            'program_id' => $request->program_id,
            'mobile_number' => $request -> mobile_number,
            'email' => $request->email,
            'current_address' => $request->current_address,
            'permanent_address' => $request->permanent_address,
            'alumni_id' => $request->alumni_id,
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));

        return Redirect::route('accounts.programs')->with('status', 'account-registered');
    }
}
