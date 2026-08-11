<?php

namespace App\Livewire\Alumni;

use Livewire\Component;
use App\Models\Form;
use App\Models\User;
use App\Models\Response;
use App\Models\ResponseField;
use App\Models\FormPublish;
use Illuminate\Support\Facades\Auth;

class Tracer extends Component
{
    public $has_response = false;
    public $response_id;
    public $questionaire;
    public $program;
    public $form;
    public $user_id;
    public $totalFields = 0;
    public $noResponses = 0;

    public function mount()
    {    
        $published = Form::with('sections.fields')->where('isPublished', 1)->first();

        if ($published) {
            $formId = $published->id;
            $this->form = $published;
        }

        if ($this->form) {
            if (Auth::guard('web')->check()) {
                $user = Auth::guard('web')->user();
                $this->user_id = $user->id;
                $response = Response::where(['user_id' => $this->user_id, 'form_id' => $this->form->id])->first();
                $this->has_response = $response ? true : false;
                $this->response_id = $response ? $response->id : null;

                if($response) {
                    $this->getUserPaticipationDetails();
                }
            }
        }
    }

    function getUserPaticipationDetails()
    {
        $fieldCount = $this->form->sections->flatMap(function ($section) {
            return $section->fields;
        })->count();

        $this->totalFields = $fieldCount;
        
        $userId = $this->user_id;
        $formId = $this->form->id;

        $responseFieldsCount = ResponseField::whereHas('response', function ($query) use ($userId, $formId) {
            $query->where('user_id', $userId)
                ->where('form_id', $formId);
        })->with('field')->count();

        $this->noResponses = $this->totalFields - $responseFieldsCount;
    }

    public function render()
    {
        return view('livewire.alumni.tracer');
    }
}
