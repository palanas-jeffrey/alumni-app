<?php

namespace App\Livewire\Survey\Overview;

use Livewire\Component;
use App\Models\Program;
use App\Models\BatchYear;
use App\Models\SurveyForm;

class ParticipantSettings extends Component
{
    public $programs;
    public $batches;
    public $form_id;
    public $form;
    public $is_published;

    public function mount($form_id = null)
    {
        $this->programs = Program::get();
        $this->batches = BatchYear::orderBy('batch_year', 'desc')->get();
        $this->form_id = $form_id;
        $this->form = SurveyForm::findOrFail($form_id);
        $this->is_published = $this->form->is_published;
    }

    public function render()
    {
        return view('livewire.survey.overview.participant-settings');
    }
}
