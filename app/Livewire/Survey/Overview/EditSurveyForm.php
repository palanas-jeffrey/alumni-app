<?php

namespace App\Livewire\Survey\Overview;

use Livewire\Component;
use App\Models\SurveyForm;

class EditSurveyForm extends Component
{
    public $form_id;
    public $form;
    public $is_published;

    public function mount($form_id = null)
    {
        $this->form_id = $form_id;
        $form = SurveyForm::findOrFail($form_id);
        $this->form = $form;
        $this->is_published = $form->is_published;
    }

    public function render()
    {
        return view('livewire.survey.overview.edit-survey-form');
    }
}
