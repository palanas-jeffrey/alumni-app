<?php

namespace App\Livewire\Alumni;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Program;

class Greetings extends Component
{
    public $first_name;
    public $program_name;

    public function mount ()
    {
        if (Auth::guard('web')->check()) 
        {
            $user = Auth::guard('web')->user();

            $this->first_name = $user->first_name;

            $program_id = $user->program_id;
            $program = Program::where("id", $program_id)->first();

            if ($program)
            {
                $this->program_name = $program->program_name;
            }
        }
    }
    public function render()
    {
        return view('livewire.alumni.greetings');
    }
}
