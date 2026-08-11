<?php

namespace App\Livewire\Survey;

use Livewire\Component;
use App\Models\SurveyForm;
use App\Models\SurveySection;
use App\Models\SurveySectionField;
use Illuminate\Support\Facades\DB;

class CloneForm extends Component
{
    public $form_id;
    public $new_form_id;
    public $isModalOnly = false;

    public function mount($form_id = null, $isModalOnly = false)
    {
        if ($form_id)
        {
            $this->form_id = $form_id;
        }

        $this->isModalOnly = $isModalOnly;
    }

    public function cloneForm()
    {
        if (!$this->form_id) return;

        DB::beginTransaction();

        try {
            $form = SurveyForm::findOrFail($this->form_id);
            $sections = SurveySection::where('survey_form_id', $this->form_id)->get();

            $newForm = SurveyForm::create([
                'title' => $form->title,
                'description' => $form->description,
            ]);

            $this->new_form_id = $newForm->id;

            foreach ($sections as $section) {
                $newSection = SurveySection::create([
                    'survey_section_title' => $section->survey_section_title,
                    'description' => $section->description,
                    'order' => $section->order,
                    'survey_form_id' => $newForm->id,
                ]);

                $fields = SurveySectionField::where('section_id', $section->id)->get();

                foreach ($fields as $field) {
                    SurveySectionField::create([
                        'field_label' => $field->field_label,
                        'type' => $field->type,
                        'choices' => $field->choices,
                        'required' => $field->required,
                        'order' => $field->order,
                        'section_id' => $newSection->id,
                    ]);
                }
            }

            DB::commit();
            $this->dispatch('form-cloned');
        } catch (\Exception $e) {
            DB::rollBack();
            // Optionally log the error or show a message
            logger()->error('Form cloning failed: ' . $e->getMessage());
            $this->dispatch('form-cloning-failed');
        }
    }


    public function render()
    {
        return view('livewire.survey.clone-form');
    }
}
