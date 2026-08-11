<?php

namespace App\Livewire\Alumni;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Rules\StrongPassword;

use Livewire\Component;

class ChangePasswordModal extends Component
{
    public $isShowing;
    public $password;
    public $password_confirmation;

    public function mount($isShowing = false)
    {
        $this->isShowing = true;
    }

    public function submit()
    {
        $this->validate([
            'password' => ['required', 'confirmed', new \App\Rules\StrongPassword()],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($this->password),
            'first_login' => false,
        ]);

        session()->flash('message', 'Password updated successfully.');
        $this->reset(['password', 'password_confirmation']);

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login')->with('password_changed', true);
    }

    public function updateFirstLogin()
    {
        $user = Auth::user();
        $user->update([
            'first_login' => false,
        ]);
    }

    public function render()
    {
        return view('livewire.alumni.change-password-modal');
    }
}
