<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\UAEvent;
use App\Models\EventPhoto;
use App\Models\EventDate;
use Carbon\Carbon;

class UpcomingEvents extends Component
{
    public $upcomingEvents;

    public function mount()
    {
        $this->loadContent();
    }

    public function loadContent()
    {    
        $this->upcomingEvents = UAEvent::whereHas('eventDates', function ($query) {
                $query->where('event_date', '>=', Carbon::today());
            })
            ->with([
                'photo',
                'eventDates' => function ($query) {
                    $query->where('event_date', '>=', Carbon::today())
                        ->orderBy('event_date', 'asc');
                }
            ])
            ->withMin(['eventDates as upcoming_date' => function ($query) {
                $query->where('event_date', '>=', Carbon::today());
            }], 'event_date')
            ->orderBy('upcoming_date', 'asc')
            ->get();

    }

    public function render()
    {
        return view('livewire.events.upcoming-events');
    }
}
