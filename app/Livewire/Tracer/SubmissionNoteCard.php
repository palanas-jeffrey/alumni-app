<?php

namespace App\Livewire\Tracer;

use Livewire\Component;
use App\Models\SubmissionSchedule;
use Carbon\Carbon;

class SubmissionNoteCard extends Component
{
    public $incomingSchedule;
    public $showSetSchedule = false;
    public $isHeightExtend = false;
    public $isWarningBg = false;
    
    public function mount($showSetSchedule = true, $isHeightExtend = true)
    {
        $this->loadSchedule();
        $this->showSetSchedule = $showSetSchedule;
        $this->isHeightExtend = $isHeightExtend;
        $this->changeBackground();
    }

    public function loadSchedule()
    {
        $this->incomingSchedule = SubmissionSchedule::where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->first();
    }

    public function toggleStatus($id, $isDone = true)
    {
        $schedule = SubmissionSchedule::find($id);
        if ($schedule) {
            $schedule->isDone = $isDone;
            $schedule->save();
        }

        $this->loadSchedule();
        $this->dispatch('schedule-status-updated');
    }

    public function changeBackground()
    {
        if ($this->incomingSchedule)
        {
            $targetDate = Carbon::parse($this->incomingSchedule->date);
            $oneDayBefore = $targetDate->copy()->subDay();
            $today = Carbon::today();
    
            if ($today->equalTo($targetDate) || $today->equalTo($oneDayBefore)) 
            {
                $this->isWarningBg = true;
            }
        }

    } 

    public function render()
    {
        return view('livewire.tracer.submission-note-card');
    }
}
