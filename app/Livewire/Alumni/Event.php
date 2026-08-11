<?php

namespace App\Livewire\Alumni;

use App\Models\UAEvent;
use App\Models\EventDate;
use Carbon\Carbon;
use Livewire\Component;

class Event extends Component
{
    public $incomingEvents;

    public function mount()
    {
        // $subQuery = EventDate::selectRaw('MIN(event_date) as event_date, event_id')
        //     ->where('event_date', '>=', Carbon::now())
        //     ->groupBy('event_id');

        // $this->incomingEvents = EventDate::joinSub($subQuery, 'earliest', function ($join) {
        //         $join->on('event_dates.event_id', '=', 'earliest.event_id')
        //             ->on('event_dates.event_date', '=', 'earliest.event_date');
        //     })
        //     ->with(['event.photo'])
        //     ->orderBy('event_dates.event_date', 'asc')
        //     ->limit(5)
        //     ->get();

        $this->incomingEvents = UAEvent::whereHas('eventDates', function ($query) {
            $query->where('event_date', '>=', Carbon::today());
        })->with(['photo', 'eventDates' => function ($query) {
            $query->where('event_date', '>=', Carbon::today())
                ->orderBy('event_date', 'asc');
        }])->limit(15)->get();
    }

    public function render()
    {
        return view('livewire.alumni.event');
    }
}
