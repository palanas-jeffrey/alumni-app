<?php

namespace App\Livewire\Survey\FormBuilder;

use Livewire\Component;
use App\Models\SurveyForm;

class Root extends Component
{
    public $title;
    public $description;
    public $survey_form;

    protected $rules = [
        'title' => 'required|string|min:3|max:1000',
        'description' => 'nullable|string|max:1000',
    ];

    public function mount($form_id)
    {
        $form = SurveyForm::findOrFail($form_id);

        if ($form) {
            $this->survey_form = $form;
            $this->title = $form->title;
            $this->description = $form->description;
        }
    }

    public function updateForm()
    {
        $this->validate();

        $this->survey_form->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $this->dispatch('survey-form-updated');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->title = null;
        $this->description = null;
    }

    public function deleteForm()
    {
        $form = SurveyForm::with(['sections.fields'])->findOrFail($this->survey_form->id);

        foreach ($form->sections as $section) {
            $section->fields()->delete();
            $section->delete();
        }

        $form->delete();

        session()->flash('form_deleted', true);
        return redirect()->route('tracerMgmt.form-list');
    }

    public function publish($form_id)
    {
        $form = SurveyForm::findOrFail($form_id);
        $form->update(['is_published' => true]);
        $this->dispatch('survey-form-published');
    }

    public function unPublish($form_id)
    {
        $form = SurveyForm::findOrFail($form_id);
        $form->update(['is_published' => false]);
        $this->dispatch('survey-form-unpublished');
    }

    public function render()
    {
        return view('livewire.survey.form-builder.root');
    }
}
