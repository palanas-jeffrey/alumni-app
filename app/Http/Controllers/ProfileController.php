<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Models\Program;
use App\Models\User;
use App\Models\Admin;
// use App\Models\EmailRegistry;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */  

    public function edit(Request $request): View
    {
        if (Auth::guard('admin')->check()) {
            $user = Admin::where('id', Auth::guard('admin')->id())->first();
            $profilePhoto = $user->profilePhoto ? $user->profilePhoto->photo_path : null;
            $uploadRoute = route('admin-profile.save-photo', ['admin_id' => $user->id]);
            
            return view('profile.edit', [
                'user' => $user,
                'profilePhoto' => $profilePhoto,
                'uploadRoute' => $uploadRoute
            ]);
        } elseif (Auth::guard('web')->check()) {
            $user = User::where('id', Auth::guard('web')->id())->first();
            $programs = Program::all();
            $profilePhoto = $user->profilePhoto ? $user->profilePhoto->photo_path : null;
            $uploadRoute = route('profile.save-photo', ['user_id' => $user->id]);

            return view('profile.edit', [
                'user' => $user,
                'programs' => $programs,
                'profilePhoto' => $profilePhoto,
                'uploadRoute' => $uploadRoute
            ]);
        }
    }

    public function update(Request $request): RedirectResponse
    {
        try {
            if (Auth::guard('admin')->check()) {
                $admin = $request->user('admin');

                $validated = $request->validate([
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name'  => ['required', 'string', 'max:255'],
                    'email'      => [
                        'required',
                        'email',
                        'max:255',
                        Rule::unique('admins', 'email')->ignore($admin->id),
                    ],
                ]);

                $admin->fill($validated);
                $admin->save();
            } else {
                $user = $request->user();
                $validated = $request->validate([
                    'first_name'        => ['required', 'string','max:255'],
                    'last_name'         => ['required', 'string','max:255'],
                    'middle_name'       => ['required', 'string','max:255'],
                    'maiden_name'       => ['nullable', 'string','max:255'],
                    'date_of_birth'     => ['nullable','date'],
                    'gender'            => ['nullable','in:male,female'],
                    'civil_status'      => ['required','in:single,married,widowed,separated'],
                    'program_id'        => ['required', 'integer', 'exists:programs,id'],
                    'batch_year'        => [
                        'required',
                        'regex:/^\d{4}-\d{4}$/',
                        'exists:batch_year,batch_year',
                    ],
                    'permanent_address' => ['required', 'string','max:255'],
                    'mobile_number'     => ['nullable', 'digits:10'],
                    'alumni_id'         => [
                        'required',
                        'string',
                        'regex:/^ALU-\d{4}-\d{4}$/',
                        'max:50',
                        Rule::unique('users', 'alumni_id')->ignore($user->id),
                    ],
                    'email'             => [
                        'required',
                        'email',
                        'max:255',
                        Rule::unique('users', 'email')->ignore($user->id),
                    ],
                ]);

                $user->fill($validated);
                $user->save();
            }

            return Redirect::route('profile.edit')->with('status', 'profile-updated');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return Redirect::back()
                ->withErrors($e->validator)
                ->with('error', 'Something went wrong while updating your profile. Please check your inputs and try again.')
                ->withInput();
        } catch (\Throwable $e) {
            return Redirect::back()
                ->with('error', 'Something went wrong while updating your profile. Please try again.')
                ->withInput();
        }
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password:' . (Auth::guard('admin')->check() ? 'admin' : 'web')],
        ]);

        if (Auth::guard('admin')->check()) {
            $user = $request->user("admin");
        } else {
            $user = $request->user();
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
