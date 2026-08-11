<?php

namespace App\Livewire\Survey\FormBuilder;

use Livewire\Component;
use App\Models\SurveySection;

class Section extends Component
{
    public $form_id;
    public $sections;

    public function mount(int $form_id = null)
    {
        $this->form_id = $form_id;
        
        if ($this->form_id)
            $this->sections = SurveySection::where('survey_form_id', $this->form_id)->orderBy('order')->get();
    }

    public function render()
    {
        return view('livewire.survey.form-builder.section');
    }
}
