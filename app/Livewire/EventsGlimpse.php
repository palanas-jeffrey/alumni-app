<?php

namespace App\Livewire;

use App\Models\UAEvent;
use Carbon\Carbon;
use Livewire\Component;

class EventsGlimpse extends Component
{
    public $incomingEvents;

    public function mount()
    {
        $this->incomingEvents = UAEvent::with('eventDates')
            ->whereHas('eventDates', function ($query) {
                $query->whereBetween('event_date', [Carbon::now(), Carbon::now()->addWeeks(3)]);
            })
            ->orderBy('event_date', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.events-glimpse');
    }
}
