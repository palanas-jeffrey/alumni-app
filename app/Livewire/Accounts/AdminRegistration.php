<?php

namespace App\Livewire\Accounts;

use Livewire\Component;
use App\Models\Admin;
use App\Models\AdminAccessKey;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminRegistration extends Component
{
    public $last_name;
    public $first_name;
    public $email;
    public $password;
    public $password_confirmation;
    public $admin_access_key;
    public $isVerified = false;
    protected $listeners = ['access-verified' => 'handleAccessVerified'];

    public function mount()
    {
        $activeAdmin = Auth::guard('admin')->user();
    }

    public function submit()
    {
        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'confirmed', new \App\Rules\StrongPassword()],
        ]);


        Admin::create($validated);

        $this->resetForm();
        $this->dispatch('admin-registered');
    }

     public function handleAccessVerified($isVerified)
    {
        $this->isVerified = $isVerified;
    }

    public function resetForm()
    {
        $this->reset(
            'last_name',
            'first_name',
            'email',
            'password'
        );
    }

    public function render()
    {
        return view('livewire.accounts.admin-registration');
    }
}
