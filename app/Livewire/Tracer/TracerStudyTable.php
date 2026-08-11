<?php

namespace App\Livewire\Tracer;

use Livewire\Component;
use App\Models\Form;
use App\Models\Response;

class TracerStudyTable extends Component
{
    public $forms = [];

    public function mount()
    {
        $this->loadForms();
    }

    public function loadForms()
    {
        $tracerSudyForms = Form::all();

        if (count($tracerSudyForms) > 0)
        {
            foreach ($tracerSudyForms as $form) 
            {
                $obj = new \stdClass();
                $obj->id = $form->id;
                $obj->title = $form->title;
                $obj->description = $form->description;
                $obj->isPublished = $form->isPublished;
                $obj->created_at = $form->created_at;
                $obj->response_count = Response::where(['form_id' => $form->id])->count();
                $this->forms[] = $obj; 
            }
        }
    }

    public function render()
    {
        return view('livewire.tracer.tracer-study-table');
    }
}
