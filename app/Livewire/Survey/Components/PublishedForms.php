<?php

namespace App\Livewire\Survey\Components;

use Livewire\Component;
use App\Models\SurveyForm;

class PublishedForms extends Component
{
    public $forms;

    public function mount()
    {
        $this->forms = SurveyForm::where(['is_published' => true])->get();
    }

    public function unPublish($form_id)
    {
        $form = SurveyForm::findOrFail($form_id);
        $form->update(['is_published' => false]);
        $this->dispatch('survey-form-unpublished');
    }

    public function deleteForm($form_id)
    {
        $form = SurveyForm::with(['sections.fields'])->findOrFail($form_id);

        foreach ($form->sections as $section) {
            $section->fields()->delete();
            $section->delete();
        }

        $form->delete();

        session()->flash('form_deleted', true);
        return redirect()->route('tracerMgmt.form-list');
    }

    public function render()
    {
        return view('livewire.survey.components.published-forms');
    }
}
