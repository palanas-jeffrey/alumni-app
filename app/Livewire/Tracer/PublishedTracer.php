<?php

namespace App\Livewire\Tracer;

use Livewire\Component;
use App\Models\Form;

class PublishedTracer extends Component
{
    public $formId;
    public $version;

    public function mount(){

        $published = Form::where('isPublished', 1)->first();

        if ($published) {
            $this->formId = $published->id;
            $this->version = $published->title;
        }
    }
    public function render()
    {
        return view('livewire.tracer.published-tracer');
    }
}
