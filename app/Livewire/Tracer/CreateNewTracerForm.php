<?php

namespace App\Livewire\Tracer;

use Livewire\Component;
use App\Models\Form;
use App\Models\SurveyForm;

class CreateNewTracerForm extends Component
{
    public $title;
    public $description;
    public $target_programs;
    public $target_batches;
    public $newForm_id;
    // public $formTypes = ['Study', 'Survey'];
    // public ?string $selectedType = null;
    public $formTypeSet = false;
    public $isNewFormCreated = false;
    public $newFormRoute;

    protected $rules = [
        'title' => 'required|string|min:3|max:1000',
        'description' => 'nullable|string|max:1000',
    ];

    // public function saveFormType()
    // {
    //     if ($this->selectedType == null) 
    //     {
    //         $this->dispatch('tracer-form-type-not-selected');
    //         return;
    //     }

    //     if (!in_array($this->selectedType, $this->formTypes, true))
    //     {
    //         return;
    //     };

    //     $this->formTypeSet = true;

    //     $this->dispatch('tracer-form-type-selected');
    // }

    public function cancelFormFillUp()
    {
        $this->formTypeSet = false;
    }

    public function addForm()
    {
        // if (strtolower($this->selectedType) === "study") 
        // {
        //     $this->saveTracerStudyForm();
        // }
        // else if (strtolower($this->selectedType) === "survey")
        // {
        //     $this->saveTracerSurveyForm();
        // }

        $this->saveTracerSurveyForm();
    }

    // public function saveTracerStudyForm()
    // {
    //     $this->validate();

    //     $form = Form::create([
    //         'title' => $this->title,
    //         'description' => $this->description,
    //     ]);

    //     $this->newForm_id = $form->id;
    //     $this->newFormRoute = route('tracer.form-edit', ['form_id' => $this->newForm_id]);
    //     $this->dispatch('tracer-study-form-added');
    //     $this->resetForm();
    //     $this->isNewFormCreated = true;
    // }

    public function saveTracerSurveyForm()
    {
        $this->validate();

        $form = SurveyForm::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $this->newForm_id = $form->id;
        $this->newFormRoute = route('survey.form-edit', ['form_id' => $this->newForm_id]);
        $this->dispatch('survey-form-added');
        $this->resetForm();
        $this->isNewFormCreated = true;
    }

    public function resetForm()
    {
        $this->title = null;
        $this->description = null;
    }

    public function render()
    {
        return view('livewire.tracer.create-new-tracer-form');
    }
}
