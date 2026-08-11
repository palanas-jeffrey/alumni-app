<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Response;

class ResponseBubbleBox extends Component
{
    public $field_id;
    public $program_id;
    public $total_respondents = 0;
    public $responses = [];
    public $total_reponses = 0;

    public function mount($field_id, $program_id, $total_respondents)
    {
        $this->field_id = $field_id;
        $this->program_id = $program_id;
        $this->$total_respondents = $total_respondents;
        
        $this->responses = Response::with(['responseFields' => function ($query) {
            $query->where('field_id', $this->field_id);
            $query->with(['field']);
        }])
        ->where('program_id', $this->program_id)
        ->get()
        ->map(function ($response) {
            if (is_string($response->response_fields)) {
                $response->response_fields = json_decode($response->response_fields, true);
            }
            return $response;
        })
        ->toArray();
        
        $this->total_reponses = count($this->responses);
    }

    public function render()
    {
        return view('livewire.response-bubble-box', [
            'responses' => $this->responses ?? [],
        ]);
    }
}
