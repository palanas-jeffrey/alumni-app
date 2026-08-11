<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public $options;
    public $selected;
    public $hasBlank;

    public function __construct($options = [], $selected = null, $hasBlank = false)
    {
        $this->options = $options;
        $this->selected = $selected;
        $this->hasBlank = $hasBlank;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}
