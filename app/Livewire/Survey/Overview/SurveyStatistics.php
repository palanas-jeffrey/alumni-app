<?php

namespace App\Livewire\Survey\Overview;

use Livewire\Component;
use App\Models\SurveyResponse;

class SurveyStatistics extends Component
{
    public $form_id;
    public $participation_count = 0;

    public function mount($form_id= null)
    {
        $this->form_id = $form_id;

        $this->participation_count = SurveyResponse::where([
            'survey_form_id' => $this->form_id,
        ])->count();
    }

    public function render()
    {
        return view('livewire.survey.overview.survey-statistics');
    }
}
