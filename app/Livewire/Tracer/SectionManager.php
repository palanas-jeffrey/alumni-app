<?php

namespace App\Livewire\Tracer;

use Livewire\Component;
use App\Models\FormSection;
use Livewire\Attributes\On;

class SectionManager extends Component
{
    public $sections = [];
    public $newSection;
    public $question_section_title;
    public $description;
    public $order;
    public $form_id;
    public $editingSectionId = null;
    public $tempSectionOrder = [];
    public $hasSectionOrderUpdate = false;
    public string $componentId;

    protected $listeners = [
        'section-added' => 'loadSections',
        'section-updated' => 'loadSections',
        'close' => 'resetForm',
    ];

    protected $rules = [
        'question_section_title' => 'required|string|min:3|max:1000',
        'description' => 'nullable|string|max:1000',
    ];

    public function mount($form_id)
    {
        $this->form_id = $form_id;
        $this->loadSections();
        $this->tempSectionOrder = $this->sections->pluck('id')->toArray();
        $this->componentId = 'section-manager-' . uniqid();
    }

    public function addSection()
    {
        $this->validate();

        $section = FormSection::create([
            'question_section_title' => $this->question_section_title,
            'description' => $this->description,
            'form_id' => $this->form_id,
        ]);
        $this->sections[] = $section;
        $this->dispatch('section-added', ['section' => $this->question_section_title]);

        $this->resetForm();
    }

    public function editSection($sectionId)
    {
        $section = FormSection::findOrFail($sectionId);
        $this->editingSectionId = $section->id;
        $this->question_section_title = $section->question_section_title;
        $this->description = $section->description;
    }

    public function updateSection()
    {
        $this->validate();

        $section = FormSection::findOrFail($this->editingSectionId);
        $section->update([
            'question_section_title' => $this->question_section_title,
            'description' => $this->description,
        ]);

        $this->dispatch('section-updated', ['section' => $this->question_section_title]);

        $this->resetForm();
    }

    public function deleteSection($sectionId)
    {
        $section = FormSection::with('fields')->findOrFail($sectionId);
        $section->fields()->delete();
        $section->delete();
        $this->loadSections();
        $this->dispatch('section-deleted', ['section' => $sectionId]);
    }

    public function resetForm()
    {
        $this->editingSectionId = null;
        $this->question_section_title = '';
        $this->description = '';
        $this->order = '';
    }

    public function loadSections()
    {
        $this->sections = FormSection::where('form_id', $this->form_id)->orderBy('order')->get();
    }

    #[On('refreshParent')]
    public function refresh()
    {
        $this->loadSections();
    }

    public function updateTempOrder($order)
    {
        $this->tempSectionOrder = array_column($order, 'value');
        $this->hasSectionOrderUpdate = true;
    }

    public function saveSectionOrder()
    {
        foreach ($this->tempSectionOrder as $index => $id) {
            FormSection::where('id', $id)->update(['order' => $index + 1]);
        }

        $this->loadSections();
        $this->tempSectionOrder = $this->sections->pluck('id')->toArray();
        $this->dispatch('section-order-saved');
    }

    public function render()
    {
        return view('livewire.tracer.section-manager');
    }
}
