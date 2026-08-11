<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;

class EmploymentStatusChart extends Component
{
    public $employedCount = 0;
    public $unEmployedCount = 0;

    public function mount()
    {
        $employed = User::where('is_employed', 1)->get();
        $unEmployed = User::where('is_employed', 0)->get();

        $this->employedCount = count($employed);
        $this->unEmployedCount = count($unEmployed);
    }

    public function render()
    {
        return view('livewire.dashboard.employment-status-chart');
    }
}
