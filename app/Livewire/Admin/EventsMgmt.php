<?php

namespace App\Livewire\Admin;

use App\Models\UAEvent;
use Carbon\Carbon;
use Livewire\Component;

class EventsMgmt extends Component
{
    public $incomingEvents;

    public function mount()
    {
        $this->incomingEvents = UAEvent::whereBetween('event_date', [Carbon::now(), Carbon::now()->addWeeks(2)])->get();
    }

    public function render()
    {
        return view('livewire.admin.events-mgmt');
    }
}
