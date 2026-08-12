<?php

namespace App\Livewire\Configuration;

use Livewire\Component;
use App\Models\BatchYear;
use Illuminate\Validation\Rule;

class BatchList extends Component
{
    public $batch_year;
    public $batch_list;

    public function mount()
    {
        $this->loadBatches();
    }

    public function loadBatches()
    {
        $this->batch_list = BatchYear::orderBy('batch_year', 'asc')->get();
    }

    public function submit()
    {
        $this->batch_year = trim($this->batch_year);

        $this->validate([
            'batch_year' => [
                'required',
                'regex:/^\d{4}-\d{4}$/',
                Rule::unique('batch_year', 'batch_year'),
                function ($attribute, $value, $fail) {
                    if (strpos($value, '-') === false) {
                        // If no dash, regex should already fail, but we prevent PHP error
                        return;
                    }

                    [$start, $end] = explode('-', $value);
                    if ((int)$end !== (int)$start + 1) {
                        $fail('The second year must be exactly one year after the first.');
                    }
                }
            ],
        ]);

        BatchYear::create([
            'batch_year' => $this->batch_year
        ]);

        $this->loadBatches();
        $this->dispatch('batch-year-added');
        $this->batch_year = '';
    }

    protected function messages()
    {
        return [
            'batch_year.required' => 'Please enter a batch year.',
            'batch_year.regex' => 'Format must be YYYY-YYYY (e.g., 2012-2013).',
            'batch_year.unique' => 'This batch year already exists.',
        ];
    }

    public function delete($id)
    {
        $batch = BatchYear::find($id);

        if ($batch) {
            $batch->delete();
            $this->dispatch('batch-year-deleted');
        }

        $this->loadBatches();
    }

    public function render()
    {
        return view('livewire.configuration.batch-list');
    }
}
