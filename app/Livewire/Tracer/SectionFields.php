<?php

namespace App\Livewire\Tracer;

use Livewire\Component;
use App\Models\FormSectionField;
use Illuminate\Validation\Rule;

class SectionFields extends Component
{
    public $section_id;
    public $field;
    public $fields = [];
    public $field_label;
    public $type;
    public $choices;
    public $required = false;
    public $editingFieldId = null;
    public $editingField;
    public $field_id;
    public $showChoices = false;

    protected $listeners = [
        'field-added' => 'loadFields',
        'close' => 'resetForm',
    ];

    public function rules()
    {
        return [
            'field_label' => 'required|string',
            'type' => [
                'required',
                'string',
                Rule::in(['text', 'number', 'radio', 'checkbox', 'select', 'textarea', 'file']),
            ],
            'choices' => [
                'nullable',
                'string',
                Rule::requiredIf(function () {
                    return in_array($this->type, ['radio', 'checkbox', 'select']);
                }),
            ],
            'required' => 'boolean',
        ];
    }

    public function mount($section_id)
    {
        $this->section_id = $section_id;
        $this->loadFields();
    }

    public function loadFields()
    {
        $this->fields = FormSectionField::where('section_id', $this->section_id)
            ->orderBy('order')
            ->get();
    }

    public function saveField()
    {
        $validated = $this->validate();

        $validated['section_id'] = $this->section_id;

        FormSectionField::create($validated);

        $this->reset(['field_label', 'type', 'choices', 'required']);
        $this->loadFields();
        $this->dispatch('field-added', ['section' => $this->section_id]);
        $this->dispatch('refreshParent');
        $this->dispatch('close-modal', [
            'detail' => 'modal-section-field-setup-' . $this->section_id
        ]);
    }

    public function editField($fieldId)
    {
        $this->editingField = FormSectionField::find($fieldId);
        $this->field_id = $this->editingField->id;
        $this->field_label = $this->editingField->field_label;
        $this->type = $this->editingField->type;
        $this->choices = $this->editingField->choices;
        $this->required = (bool) $this->editingField->required;

        $this->dispatch('open-modal', ['modal-section-field-setup-' . $this->section_id]);
    }

    public function updateField()
    {
        $this->validate();

        $field = FormSectionField::findOrFail($this->field_id);
        $field->update([
            'field_label' => $this->field_label,
            'type' => $this->type,
            'choices' => $this->choices,
            'required' => $this->required
        ]);

        $this->dispatch('field-updated', ['field' => $this->field_label]);
        $this->resetForm();
        $this->dispatch('refreshParent');
        $this->dispatch('close-modal', [
            'detail' => 'modal-section-field-setup-' . $this->section_id,
        ]);
    }

    public function deleteField($fieldId)
    {
        $field = FormSectionField::findOrFail($fieldId);
        $field->delete();
        $this->loadFields();
        $this->dispatch('field-deleted', ['field' => $fieldId]);
    }

    public function resetForm()
    {
        $this->field_label = null;
        $this->type = null;
        $this->choices = '';
        $this->required = '';
    }

    public function updatedType($value)
    {
        $this->showChoices = in_array($value, ['radio', 'checkbox', 'select']);
    }

    public function render()
    {
        return view('livewire.tracer.section-fields');
    }
}
