<?php

namespace App\Livewire\Tracer\Components;

use Livewire\Component;
use App\Models\FormPublish;
use App\Models\Form;

class FormPublishForm extends Component
{
    public $form_id;
    public $response_collection_start;
    public $response_collection_end;
    public $form_publish_id;
    public $isEdit = false;

    protected $rules = [
        'form_id' => 'required|exists:forms,id',
        'response_collection_start' => 'required|date',
        'response_collection_end' => 'required|date|after:response_collection_start',
    ];

    public function mount(int $form_id = null, int $form_publish_id = null, $isEdit = false)
    {
        $this->form_id = $form_id;
        $this->form_publish_id = $form_publish_id;
        $this->isEdit = $isEdit;

        if ($form_publish_id) {
            $publish = FormPublish::findOrFail($form_publish_id);
            $this->form_id = $publish->form_id;
            $this->response_collection_start = $publish->response_collection_start;
            $this->response_collection_end = $publish->response_collection_end;
        }
    }

    public function submit()
    {
        $this->validate();

        $overlapping = FormPublish::where('form_id', $this->form_id)
            ->where(function ($query) {
                $query->where('response_collection_start', '<=', $this->response_collection_start)
                      ->where('response_collection_end', '>=', $this->response_collection_start);
            })
            ->when($this->form_publish_id, function ($query) {
                $query->where('id', '!=', $this->form_publish_id);
            })
            ->exists();

        if ($overlapping) {
            $this->addError('response_collection_start', 'The start date overlaps with an existing publish period.');
            return;
        }

        $data = [
            'form_id' => $this->form_id,
            'response_collection_start' => $this->response_collection_start,
            'response_collection_end' => $this->response_collection_end,
        ];

        if ($this->form_publish_id) {
            FormPublish::findOrFail($this->form_publish_id)->update($data);
        } else {
            FormPublish::create($data);
        }

        $this->dispatch('form-published');
        $this->dispatch('close', [
            'detail' => 'modal-form-publish-' . $this->form_id . '-' . $this->form_publish_id,
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.tracer.components.form-publish-form');
    }
}
