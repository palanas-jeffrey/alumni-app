<?php

namespace App\Livewire\Tracer;

use Livewire\Component;
use App\Models\Form;
use App\Models\Program;
use App\Models\Response;

class TracerResponsesStats extends Component
{
    public $formId;
    public $programsAbbrevList = [];
    public $responsePerProgram = [];
    public $totalResponseCount = 0;

    public function mount()
    {
        $published = Form::where('isPublished', 1)->first();

        if ($published) {
            $this->formId = $published->id;
            $this->version = $published->title;

            $programs = Program::all();

            $this->programsAbbrevList = [];
            $this->responsePerProgram = [];

            foreach ($programs as $program) {
                $this->programsAbbrevList[] = $program->program_abbreviation;
                $count = Response::where([
                    'program_id' => $program->id,
                    'form_id' => $this->formId
                ])->count();
                $this->responsePerProgram[] = $count;
            }

            $this->totalResponseCount = Response::where([
                    'form_id' => $this->formId
                ])->count();

            $this->dispatch('renderChart');
        }
    }

    public function render()
    {
        return view('livewire.tracer.tracer-responses-stats');
    }
}
