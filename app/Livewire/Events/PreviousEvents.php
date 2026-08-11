<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\UAEvent;
use App\Models\EventPhoto;
use App\Models\EventDate;
use Carbon\Carbon;

class PreviousEvents extends Component
{
    public $prevEvents;

    public function mount()
    {
        $this->loadContent();
    }

    public function loadContent()
    {    
        $this->prevEvents = UAEvent::whereHas('eventDates', function ($query) {
                $query->where('event_date', '<', Carbon::today());
            })
            ->with(['photo', 'eventDates' => function ($query) {
                $query->where('event_date', '<', Carbon::today())
                    ->orderBy('event_date', 'desc');
            }])
            ->withMax(['eventDates as latest_past_date' => function ($query) {
                $query->where('event_date', '<', Carbon::today());
            }], 'event_date')
            ->orderByDesc('latest_past_date')
            ->get();
    }

    public function render()
    {
        return view('livewire.events.previous-events');
    }
}
