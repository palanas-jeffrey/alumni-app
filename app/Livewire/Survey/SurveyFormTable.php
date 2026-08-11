<?php

namespace App\Livewire\Survey;

use Livewire\Component;
use App\Models\SurveyForm;

class SurveyFormTable extends Component
{
    public function render()
    {
        return view('livewire.survey.survey-form-table');
    }
}
