<?php

namespace App\Livewire\Tracer\Report;

use Livewire\Component;
use App\Models\FormSectionField;
use App\Models\ResponseField;

class SectionResponseAnalysis extends Component
{
    public $section_id;
    public $form_id;
    public $fields;
    public $program_id;
    public $batch_year = null;
    
    public function mount($section_id = null, $program_id = null, $form_id = null, $batch_year = null)
    {
        $this->section_id = $section_id;

        if ($this->section_id) 
        {
            $this->fields = FormSectionField::with('fieldResponse')->where('section_id', $this->section_id)->orderBy('order')->get();
        }

        if ($program_id)
        {
            $this->program_id = $program_id;
        }

        if ($form_id)
        {
            $this->form_id = $form_id;
        }

        if ($batch_year)
        {
            $this->batch_year = $batch_year;
        }
    }

    public function render()
    {
        return view('livewire.tracer.report.section-response-analysis');
    }
}
