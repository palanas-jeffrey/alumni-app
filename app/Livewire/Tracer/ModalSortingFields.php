<?php

namespace App\Livewire\Tracer;

use Livewire\Component;
use App\Models\FormSectionField;

class ModalSortingFields extends Component
{
    public $items;
    public $stagedOrder = [];
    public $section_id;
    public $hasUpdated = false;

    public function mount( int $section_id = null)
    {
        $this->section_id = $section_id;
        $this->items = FormSectionField::where('section_id', $this->section_id)->orderBy('order')->get();
        $this->stagedOrder = $this->items->pluck('id')->toArray();
    }

    public function reorderQuestions($orderedIds)
    {  
        $this->stagedOrder = $orderedIds;
        $this->items = collect($orderedIds)
            ->map(function ($order) {
                return $this->items->firstWhere('id', $order["value"]);
            });
        $this->hasUpdated = true;
    }


    public function saveOrder()
    {
        foreach ($this->stagedOrder as $order) {
            FormSectionField::where('id', (int)$order['value'])->update(['order' => $order['order'] + 1]);
        }

        $this->items = FormSectionField::where('section_id', $this->section_id)->orderBy('order')->get();

        session()->flash('message', 'Order successfully updated!');
        $this->dispatch('order-field-saved');
    }

    public function render()
    {
        return view('livewire.tracer.modal-sorting-fields');
    }
}
