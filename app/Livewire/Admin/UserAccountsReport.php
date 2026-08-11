<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\AccountActivation;
use Livewire\Component;

class UserAccountsReport extends Component
{
    public $activatedUsers;
    public $nonActivatedUsers;

    public function mount()
    {
        $this->activatedUsers = AccountActivation::where('is_activated', true)->count();
        $this->nonActivatedUsers = AccountActivation::where('is_activated', false)->count();
    }


    // public function mount()
    // {
    //     $this->$userAccounts = User::select('id', 'name', 'email', 'created_at')->get();
    // }

    public function render()
    {
        return view('livewire.admin.user-accounts-report');
    }
}
