<?php

namespace App\Livewire\Survey\Report\Components;

use Livewire\Component;
use App\Models\SurveySectionField;
use App\Models\SurveyResponse;
use App\Models\SurveyResponseField;
use App\Models\SurveySection;
use App\Models\User;

class ResponsesInTable extends Component
{
    public $section_id;
    public $table_header_items;
    public $section;
    public $program_id;
    public $form_id;
    public $table_body_contents = [];
    public $batch_year = null;
    public $survey_period_id;

    public function mount($section_id = null, $program_id = null, $form_id = null, $batch_year = null, $survey_period_id = null)
    {
        $this->section_id = $section_id;

        if ($program_id)
        {
            $this->program_id = $program_id;
            $this->form_id = $form_id;
        }

        if ($batch_year)
        {
            $this->batch_year = $batch_year;
        }

        if ($this->section_id) 
        {
            $this->section = SurveySection::findOrFail($section_id);
            $questions = SurveySectionField::where('section_id', $this->section_id)->orderBy('order')->get();
            $this->table_header_items = $questions;
            $this->setTableBodyContents();
        }
    }

    public function setTableBodyContents()
    {
        $responses = SurveyResponse::with('user')->where([
            'program_id' => $this->program_id,
            'survey_form_id' => $this->form_id,
            'batch_year' => $this->batch_year,
            'survey_period_id' => $this->survey_period_id
        ])->get();

        foreach ($responses as $response) 
        {
            $responseObject = new \stdClass();
            $responseObject->first_name = $response->user->first_name;
            $responseObject->last_name = $response->user->last_name;
            $answer_list = [];

            foreach($this->table_header_items as $header_item)
            {
                $answer = SurveyResponseField::where([
                    'field_id' => $header_item->id,
                    'response_id' => $response->id,
                    'section_id' => $this->section->id,
                    ])->first();

                if ($answer)
                {
                    $value = $answer->value;

                    if (strpos($value, '|') !== false) {
                        $value = str_replace('|', ' , ', $value);
                    }

                    $answer_list[] =  $value;   
                } 
                else
                {
                    $answer_list[] = "";
                }
            }

            $responseObject->answer_list = $answer_list;

            $this->table_body_contents[] = $responseObject;
        }
    }

    public function isValidDocumentPath($path)
    {
        return preg_match('/\.(pdf|doc|docx|rtf|txt|odt|xls|xlsx|csv|ppt|pptx|jpg|jpeg|jfif|png|gif|bmp|tiff|tif|webp|heic|heif)$/i', $path);
    }

    public function render()
    {
        return view('livewire.survey.report.components.responses-in-table');
    }
}
