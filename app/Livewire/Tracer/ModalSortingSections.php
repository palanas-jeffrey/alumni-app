<?php

namespace App\Livewire\Tracer;

use Livewire\Component;
use App\Models\FormSection;

class ModalSortingSections extends Component
{
    public $items;
    public $stagedOrder = [];
    public $form_id;
    public $hasUpdated = false;

    public function mount( int $section_id = null, int $form_id = null)
    {
        $this->form_id = $form_id;
        $this->items = FormSection::where('form_id', $this->form_id)->orderBy('order')->get();
        $this->stagedOrder = $this->items->pluck('id')->toArray();
    }

    public function reorder($orderedIds)
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
            FormSection::where('id', (int)$order['value'])->update(['order' => $order['order'] + 1]);
        }

        $this->items = FormSection::where('form_id', $this->form_id)->orderBy('order')->get();

        session()->flash('message', 'Order successfully updated!');
        $this->dispatch('order-saved');
    }

    public function render()
    {
        return view('livewire.tracer.modal-sorting-sections');
    }
}
