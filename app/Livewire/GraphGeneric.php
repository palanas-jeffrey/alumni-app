<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Response;
use App\Models\Field;
use App\Models\ResponseField;

class GraphGeneric extends Component
{
    public $chart_id = "";
    public $choices = [];
    public $total_respondents = 0;
    public $chart_type = "";

    public function mount($chart_id = null, $choices = null, $total_respondents = null, $chart_type = null)
    {
        if ($chart_id)
        {
           $this->chart_id = $chart_id;
        }

        if ($choices)
        {
            $this->choices = $choices;
        }

        if ($total_respondents)
        {
            $this->total_respondents = $total_respondents;
        }

        if ($chart_type)
        {
            $this->chart_type = $chart_type;
        }
    }

    public function render()
    {
        return view('livewire.graph-generic');
    }
}