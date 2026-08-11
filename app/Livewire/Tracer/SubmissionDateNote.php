<?php

namespace App\Livewire\Tracer;

use Livewire\Component;
use App\Models\SubmissionSchedule;
use Illuminate\Validation\Rule;

class SubmissionDateNote extends Component
{
    public $date;
    public $note;
    public $status;
    public $updateDate;
    public $updateNote;
    public $incomingSchedules;
    public $previousSchedules;

    public function mount()
    {
        $this->loadSchedules();
    }

    public function loadSchedules()
    {
        $this->incomingSchedules = SubmissionSchedule::where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->get();

        $this->previousSchedules = SubmissionSchedule::where('date', '<', now()->toDateString())
            ->orderBy('date', 'desc')
            ->get();
    }

    public function submit()
    {
        $this->validate([
            'date' => [
                'required',
                'date',
                'after_or_equal:today',
                Rule::unique('submission_schedule', 'date'),
            ],
            'note' => ['nullable', 'string'],
        ]);


        SubmissionSchedule::create([
            'date' => $this->date,
            'note' => $this->note,
        ]);

        $this->loadSchedules();
        $this->dispatch('schedule-added');
        $this->date = null;
        $this->note = null;
    }

    public function setEditValues($id)
    {
        $schedule = SubmissionSchedule::find($id);
        if ($schedule) {
            $this->updateDate = $schedule->date;
            $this->updateNote = $schedule->note;
        }
    }

    public function submitUpdates($id)
    {
        $this->validate([                       
                'updateDate' => [
                        'required',
                        'date',
                        'after_or_equal:today',
                        Rule::unique('submission_schedule', 'date')->ignore($id),
                    ],
                'updateNote' => ['nullable', 'string'],
            ]);

        $schedule = SubmissionSchedule::find($id);
        
        if ($schedule) {
            $schedule->date = $this->updateDate;
            $schedule->note = $this->updateNote;
            $schedule->save();
        }

        $this->loadSchedules();
        $this->dispatch('schedule-updated');
        $this->updateDate = null;
        $this->updateNote = null;
    }

    public function clearUpdates()
    {
        $this->updateDate = null;
        $this->updateNote = null;
        $this->resetErrorBag();
    }

    public function toggleStatus($id, $isDone = true)
    {
        $schedule = SubmissionSchedule::find($id);
        if ($schedule) {
            $schedule->isDone = $isDone;
            $schedule->save();
        }

        $this->loadSchedules();
        $this->dispatch('schedule-status-updated');
    }

    public function deleteSchedule($id)
    {
        $schedule = SubmissionSchedule::find($id);
        if ($schedule) {
            $schedule->delete();
        }

        $this->loadSchedules();
        $this->dispatch('schedule-deleted');
    }


    public function render()
    {
        return view('livewire.tracer.submission-date-note');
    }
}
