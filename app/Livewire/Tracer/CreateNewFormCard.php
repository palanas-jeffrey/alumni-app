<?php

namespace App\Livewire\Tracer;

use Livewire\Component;
use App\Models\Form;

class CreateNewFormCard extends Component
{
    public $title;
    public $description;
    public $target_programs;
    public $target_batches;
    public $newFormAdded = false;
    public $newForm_id;

    protected $rules = [
        'title' => 'required|string|min:3|max:1000',
        'description' => 'nullable|string|max:1000',
    ];

    public function addForm()
    {
        $this->validate();

        $form = Form::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $this->newForm_id = $form->id;

        $this->dispatch('tracer-study-form-added');
        $this->resetForm();
        $this->newFormAdded = true;
    }

    public function resetForm()
    {
        $this->title = null;
        $this->description = null;
    }

    public function render()
    {
        return view('livewire.tracer.create-new-form-card');
    }
}
