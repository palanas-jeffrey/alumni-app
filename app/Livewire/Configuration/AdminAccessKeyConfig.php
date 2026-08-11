<?php

namespace App\Livewire\Configuration;

use Livewire\Component;
use App\Models\AdminAccessKey;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminAccessKeyConfig extends Component
{
    public $isVerified = false;
    public $admin_access_key;
    protected $listeners = ['access-verified' => 'handleAccessVerified'];

    public function submitNewPasscode()
    {
        $validated = $this->validate([
            'admin_access_key' => ['required', new \App\Rules\StrongPassword()],
        ]);

        $passCode = AdminAccessKey::first();

        if ($passCode) {
            $passCode->update($validated);
        } else {
            AdminAccessKey::create($validated);
        }

        $this->dispatch('admin-key-updated');   
    }

    public function handleAccessVerified($isVerified)
    {
        $this->isVerified = $isVerified;
    }

    public function render()
    {
        return view('livewire.configuration.admin-access-key-config');
    }
}
