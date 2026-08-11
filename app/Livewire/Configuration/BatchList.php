<?php

namespace App\Livewire\Configuration;

use Livewire\Component;
use App\Models\BatchYear;

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
                'unique:batch_year,batch_year',
                function ($attribute, $value, $fail) {
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
