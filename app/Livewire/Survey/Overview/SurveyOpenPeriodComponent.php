<?php

namespace App\Livewire\Survey\Overview;

use Livewire\Component;
use App\Models\SurveyForm;
use App\Models\SurveyOpenPeriod;
use Illuminate\Support\Facades\Validator;

class SurveyOpenPeriodComponent extends Component
{
    public $start_date;
    public $end_date;
    public $form_id;
    public $periods;
    public $period_id;
    public $is_published;

    public function mount($form_id = null)
    {
        $form = SurveyForm::findOrFail($form_id);

        if ($form) {
            $this->form_id = $form->id;
            $this->is_published = $form->is_published;
            $this->loadPeriods();
        }
    }

    public function addPeriod()
    {
        $validator = Validator::make([
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ], [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ], [
                'end_date.after' => 'The end date must be after the start date.',
            ]);

            $validator->after(function ($validator) {
                $overlap = \App\Models\SurveyOpenPeriod::where('survey_form_id', $this->form_id)
                    ->where(function ($query) {
                        $query->whereDate('start_date', '<=', $this->end_date)
                        ->whereDate('end_date', '>=', $this->start_date);
                })->exists();

                if ($overlap) {
                    $validator->errors()->add('start_date', 'The selected date range overlaps with an existing survey open period.');
                }
            });

        $validator->validate();

        SurveyOpenPeriod::create([
            'survey_form_id' => $this->form_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $this->dispatch('survey-period-added');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->start_date = null;
        $this->end_date = null;
        $this->period_id = null;
    }

    public function loadPeriods()
    {
        $this->periods = SurveyOpenPeriod::where('survey_form_id', $this->form_id)->get();
    }

    public function editPeriod($start, $end)
    {
        $this->start_date = $start;
        $this->end_date = $end;
    }

    public function updatePeriod($period_id)
    {
        $this->period_id = $period_id;

        $validator = Validator::make([
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ], [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ], [
            'end_date.after' => 'The end date must be after the start date.',
        ]);

        $validator->after(function ($validator) use ($period_id) {
            $overlap = \App\Models\SurveyOpenPeriod::where(function ($query) {
                $query->whereDate('start_date', '<=', $this->end_date)
                    ->whereDate('end_date', '>=', $this->start_date);
            })
            ->where('id', '!=', (int) $period_id) // Exclude current record properly
            ->where('survey_form_id', $this->form_id)
            ->exists();

            if ($overlap) {
                $validator->errors()->add('start_date', 'The selected date range overlaps with an existing survey open period.');
            }
        });

        $validator->validate();

        SurveyOpenPeriod::where('id', $this->period_id)->update([
            'survey_form_id' => $this->form_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $this->dispatch('survey-period-updated');
        $this->resetForm();
    }

    public function deletePeriod($id)
    {
        $period = SurveyOpenPeriod::findOrFail($id);
        $period->delete();
        $this->dispatch('survey-period-deleted');
    }

    public function render()
    {
        return view('livewire.survey.overview.survey-open-period-component');
    }
}
