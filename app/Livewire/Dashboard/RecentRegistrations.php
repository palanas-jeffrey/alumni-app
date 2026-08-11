<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;

class RecentRegistrations extends Component
{
    public $users = [];

    public function mount()
    {
        $this->users = User::with('accountActivation', 'programTaken')
        ->where('created_at', '>=', now()->subDays(7))
        ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.recent-registrations');
    }
}
