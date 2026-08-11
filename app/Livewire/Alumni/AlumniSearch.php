<?php

namespace App\Livewire\Alumni;

use Livewire\Component;
use App\Models\User;
use App\Models\BatchYear;

class AlumniSearch extends Component
{
    public $accounts = []; 
    public $searchTerm = "";
    public $batch_years;
    public $batchYear;
    public $resultCount = null;

    public function mount()
    {
        $this->accounts = [];
        $this->batch_years = BatchYear::orderBy('batch_year', 'asc')
            ->get()->pluck('batch_year')->toArray();
    }

    public function render()
    {
        return view('livewire.alumni.alumni-search');
    }

    public function updatedSearchTerm()
    {
        $this->fetchResults();
    }

    public function updatedBatchYear()
    {
        $this->fetchResults();
    }

    public function fetchResults()
    {

        if ($this->searchTerm && $this->batchYear) 
        {
            $this->accounts = User::where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->where(['batch_year'=> $this->batchYear])
            ->get();
            $this->resultCount = $this->accounts->count();
        } else if ($this->searchTerm)
        {
            $this->accounts = User::where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->get();
            $this->resultCount = $this->accounts->count();
        }
         else if ($this->batchYear)
        {
            $this->accounts = User::where(['batch_year'=> $this->batchYear])
                ->get();
            $this->resultCount = $this->accounts->count();
        } else {
            $this->accounts = [];
            $this->resultCount = null;
        }
    }
}
