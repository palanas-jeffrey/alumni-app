<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\BatchYear;

class AccountsPerProgram extends Component
{
    public $program_id;
    public $accounts = []; 
    public $searchTerm = "";
    public $batch_years;
    public $batchYear;
    public $resultCount = null;

    public function mount($program_id)
    {
        $this->program_id = $program_id;
        $this->accounts = User::where(['program_id' => $program_id])->get();
        $this->batch_years = BatchYear::orderBy('batch_year', 'asc')
            ->get()->pluck('batch_year')->toArray();
    }  
    public function render()
    {
        return view('livewire.admin.accounts-per-program');
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
            ->where(['program_id' => $this->program_id, 'batch_year'=> $this->batchYear])
            ->get();
            $this->resultCount = $this->accounts->count();
        } else if ($this->searchTerm)
        {
            $this->accounts = User::where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->where(['program_id' => $this->program_id])
            ->get();
            $this->resultCount = $this->accounts->count();
        }
         else if ($this->batchYear)
        {
            $this->accounts = User::where(['program_id' => $this->program_id, 'batch_year'=> $this->batchYear])
                ->get();
            $this->resultCount = $this->accounts->count();
        } else {
            $this->accounts = User::where(['program_id' => $this->program_id])
                ->get();
            $this->resultCount = null;
        }

    }
}
