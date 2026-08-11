<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;

class AlumniStatistics extends Component
{
    public $alumniCount = 0;
    public $bsit = 0;
    public $bscs = 0;
    public $bsis = 0;

    public function mount()
    {
        $this->alumniCount = User::get()->count();

        $this->bsit = User::where(['program_id' => 1])->get()->count();
        $this->bscs = User::where(['program_id' => 3])->get()->count();
        $this->bsis = User::where(['program_id' => 2])->get()->count();
    }

    public function render()
    {
        return view('livewire.dashboard.alumni-statistics');
    }
}
