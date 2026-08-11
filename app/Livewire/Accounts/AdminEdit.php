<?php

namespace App\Livewire\Accounts;

use Livewire\Component;
use App\Models\Admin;
use Illuminate\Validation\Rule;
use App\Models\AdminAccessKey;
use Illuminate\Support\Facades\Hash;

class AdminEdit extends Component
{
    public $account;
    public $last_name;
    public $first_name;
    public $email;
    public $password;
    public $password_confirmation;
    public $isVerified = false;
    protected $listeners = ['access-verified' => 'handleAccessVerified'];
    public $admin_access_key;

    public function mount($account_id = null)
    {
        $this->account = Admin::findOrFail($account_id);

        if ($this->account)
        {
            $this->loadAccount();
        }
    }

    public function loadAccount() 
    {
        $this->last_name = $this->account->last_name;
        $this->first_name = $this->account->first_name;
        $this->email = $this->account->email;
    }

    public function submit()
    {
        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],   
            'email' => [
                    'nullable',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    Rule::unique('admins', 'email')->ignore($this->account->id),
                ],
            ]);

        Admin::find($this->account->id)->update($validated);

        $this->dispatch('account-updated');
    }

    public function submitPassword()
    {
        $validated = $this->validate([
            'password' => ['required', 'confirmed', new \App\Rules\StrongPassword()],
        ]);

        Admin::find($this->account->id)->update($validated);

        $this->dispatch('password-updated');
        $this->password = "";
        $this->password_confirmation = "";
    }

    public function handleAccessVerified($isVerified)
    {
        $this->isVerified = $isVerified;
    }

    public function deleteAdminAccount()
    {
        $inputCode = $this->admin_access_key;

        $matched = AdminAccessKey::get()->first(function ($record) use ($inputCode) {
            return Hash::check($inputCode, $record->admin_access_key);
        });

        if ($matched) {
            $this->account->delete();
            return redirect()->route('accounts.administrators')->with('success-account-deletion', 'Admin account deleted successfully.');
        } else {
            $this->addError('admin_key', 'Invalid access key');
            $this->dispatch('access-key-invalid');
        }
    }

    public function render()
    {
        return view('livewire.accounts.admin-edit');
    }
}