<?php

namespace App\Livewire\Tracer\Components;

use Livewire\Component;

class DynamicField extends Component
{
    public $order;
    public $orderInLetter;
    public $field;
    public $section_id;

    public function mount(int $order = null, $field = null, $section_id = null)
    {
        if ($order) {
            $this->order = $this->numberToLetters($order);
        }

        if ($field) {
            $this->field = $field;
        }

        if ($section_id) {
            $this->section_id = $section_id;
        }
    }

    public function numberToLetters($number) {
        $result = '';
        while ($number > 0) {
            $number--;
            $result = chr(65 + ($number % 26)) . $result;
            $number = intval($number / 26);
        }
        return strtolower($result);
    }

    public function render()
    {
        return view('livewire.tracer.components.dynamic-field');
    }
}
