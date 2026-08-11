<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use App\Models\AdminAccessKey;
use Illuminate\Support\Facades\Hash;

class AdminAccessLock extends Component
{
    public $isVerified = false;
    public $admin_access_key;

    public function submitPasscode()
    {
        $inputCode = $this->admin_access_key;

        $matched = AdminAccessKey::get()->first(function ($record) use ($inputCode) {
            return Hash::check($inputCode, $record->admin_access_key);
        });

        if ($matched) {
            $this->isVerified = true;
            $this->dispatch('access-verified', isVerified: true);
        } else {
            $this->addError('admin_key', 'Invalid access key');
            $this->dispatch('access-refused');
        }

        $this->admin_access_key = null;
    }

    public function render()
    {
        return view('livewire.shared.admin-access-lock');
    }
}