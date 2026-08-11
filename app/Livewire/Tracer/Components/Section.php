<?php

namespace App\Livewire\Tracer\Components;

use Livewire\Component;
use App\Models\FormSection;

class Section extends Component
{
    public $form_id;
    public $sections;

    public function mount(int $form_id = null)
    {
        $this->form_id = $form_id;
        
        if ($this->form_id) {
            $this->sections = FormSection::where('form_id', $this->form_id)->orderBy('order')->get();
        }
    }

    public function render()
    {
        return view('livewire.tracer.components.section');
    }
}
