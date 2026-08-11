<?php

namespace App\Livewire\Survey\Overview;

use Livewire\Component;
use App\Models\SurveyForm;
use App\Models\SurveyOpenPeriod;
use Carbon\Carbon;

class SurveyFormStatus extends Component
{
    public $is_published = false;
    public $is_active = false;
    public $form;

    public function mount($form_id = null)
    {
        $form = SurveyForm::findOrFail($form_id);
        $this->form = $form;
        $this->is_published = $form->is_published;

        $today = Carbon::today();

        $periods = SurveyOpenPeriod::where('survey_form_id', $form_id)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();

        if (count($periods) > 0 && $this->is_published)
        {
            $this->is_active = true;
        }
    }

    public function publish($form_id)
    {
        $form = SurveyForm::findOrFail($form_id);
        $form->update(['is_published' => true]);
        $this->dispatch('survey-form-published');
    }

    public function render()
    {
        return view('livewire.survey.overview.survey-form-status');
    }
}
