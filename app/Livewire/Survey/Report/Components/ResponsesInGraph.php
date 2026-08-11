<?php

namespace App\Livewire\Survey\Report\Components;

use Livewire\Component;
use App\Models\SurveySectionField;
use App\Models\SurveySection;
use App\Models\SurveyResponse;
use App\Models\SurveyResponseField;

class ResponsesInGraph extends Component
{
    public $field;
    public $program_id;
    public $total_responses;
    public $chart_type = '';
    public $chart_id;
    public $choices = [];
    public $isGraphable = false;
    public $batch_year = null;
    public $choiceStats = [];
    public $survey_period_id;

    public function mount($field_id = null, $program_id = null, $batch_year = null, $survey_period_id = null)
    {
        $field = SurveySectionField::findOrFail($field_id);

        if ($program_id)
        {
            $this->program_id = $program_id;
        }

        if ($batch_year)
        {
            $this->batch_year = $batch_year;
        }

        if ($survey_period_id)
        {
            $this->survey_period_id = $survey_period_id;
        }

        if ($field)
        {
            $this->field = $field;

            if ($this->field->type === 'select' || $this->field->type === 'radio' || $this->field->type === 'checkbox' )
            {
                $this->isGraphable = true;
                $this->setGraphDatas();
            }
        }
    }

    public function setGraphDatas ()
    {
        $form_id = null;
        $section = SurveySection::findOrFail($this->field->section_id);
        $response_ids = [];
        $responses = collect();
        $responseFields = collect();

        if ($section) {
            $form_id = $section->survey_form_id;
        }

        if ($form_id && $this->program_id && $this->batch_year) {
            $responses = SurveyResponse::where([
                'program_id' => $this->program_id,
                'survey_form_id' => $form_id,
                'batch_year' => $this->batch_year,
                'survey_period_id' => $this->survey_period_id
            ])->get();

            if ($responses->count() > 0) {
                $response_ids = $responses->pluck('id')->toArray();
            }
        }

       $fieldChoices = array_map('trim', explode('|', $this->field->choices));
       $this->choices = array_fill_keys($fieldChoices, 0);

        if (count($response_ids) > 0) {
            $responseFields = SurveyResponseField::whereIn('response_id', $response_ids)
                ->where('field_id', $this->field->id)
                ->get();
            
            $this->total_responses = $responseFields->count();

            if ($this->field->type === 'select' || 
                $this->field->type === 'radio' ) {

                foreach($responseFields as $responseField) {
                    
                    $value = $responseField->value;

                    if (isset($this->choices[$value])) {
                        $this->choices[$value]++;
                    }
                }
            } else if ($this->field->type === 'checkbox') {
                $this->chart_type = 'vertical-bar';

                foreach ($responseFields as $responseField) {
                    $answer = $responseField->value;

                    if (strpos($answer, '|') !== false) {
                        $votes = explode('|', $answer);
                        foreach ($votes as $vote) {
                            $vote = trim($vote);
                            if (isset($this->choices[$vote])) {
                                $this->choices[$vote]++;
                            }
                        }
                    } else {
                        $answer = trim($answer);
                        if (isset($this->choices[$answer])) {
                            $this->choices[$answer]++;
                        }
                    }
                }

            }

            if (count($this->choices) > 0) {
                foreach ($this->choices as $key => $value) {
                    $this->choiceStats[] = (object)[
                        'choice' => $key,
                        'count' => $value
                    ];
                }
            }
        }
       
        $this->chart_id = "response-chart-" . $this->field->id;
    }

    public function render()
    {
        return view('livewire.survey.report.components.responses-in-graph');
    }
}
