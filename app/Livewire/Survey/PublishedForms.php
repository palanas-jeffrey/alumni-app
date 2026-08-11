<?php

namespace App\Livewire\Survey;

use Livewire\Component;
use App\Models\SurveyForm;
use App\Models\Program;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PublishedForms extends Component
{
    public $published_forms;
    public $formObjects;

    public function mount()
    {
        $user = Auth::guard('web')->user();
        $program = Program::findOrFail($user->program_id);
        $program_id = $program->program_abbreviation;
        $year = $user->batch_year;

        $today = Carbon::today()->toDateString();

        $this->published_forms = SurveyForm::with(['openPeriods' => function ($query) use ($today) {
                $query->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today);
            }])
            ->where('is_published', true)
            ->whereHas('openPeriods', function ($query) use ($today) {
                $query->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today);
            })
            ->whereJsonContains("target_participants->{$program_id}", (string) $year)
            ->get();

        $this->formObjects = [];

        foreach ($this->published_forms as $form) {
            $formObject = new \stdClass();
            $formObject->id = $form->id;
            $formObject->title = $form->title;
            $formObject->description = $form->description;
            $formObject->openPeriods = [];

            foreach ($form->openPeriods as $period) {
                $start = \Carbon\Carbon::parse($period->start_date);
                $end = \Carbon\Carbon::parse($period->end_date);

                $periodObject = new \stdClass();
                $periodObject->start = $start;
                $periodObject->end = $end;
                $periodObject->hasResponded = false;
                $periodObject->survey_period_id = $period->id;

                $response = SurveyResponse::where([
                    'user_id' => $user->id,
                    'survey_form_id' => $form->id,
                    'survey_period_id' => $period->id
                ])->first();

                if ($response)
                {
                    $periodObject->hasResponded = true;
                    $periodObject->response_id = $response->id; 
                }

                $formObject->openPeriods[] = $periodObject;
            }

            $this->formObjects[] = $formObject;
        }
    }

    public function render()
    {
        return view('livewire.survey.published-forms');
    }
}
