<?php

namespace App\Livewire\Survey\Questionaire;

use Livewire\Component;
use App\Models\SurveySectionField;

class Field extends Component
{
    public $section_id;
    public $fields;

    public function mount($section_id)
    {
        $this->section_id = $section_id;
        $this->loadFields();
    }

    public function loadFields()
    {
        $this->fields = SurveySectionField::where('section_id', $this->section_id)
            ->orderBy('order')
            ->get();
    }

    public function render()
    {
        return view('livewire.survey.questionaire.field');
    }
}
