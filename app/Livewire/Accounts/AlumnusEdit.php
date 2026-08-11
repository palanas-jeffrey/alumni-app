<?php

namespace App\Livewire\Accounts;

use Livewire\Component;
use App\Models\User;
use App\Models\Program;
use App\Models\BatchYear;
use Illuminate\Validation\Rule;

class AlumnusEdit extends Component
{
    public $account;
    public $last_name;
    public $first_name;
    public $middle_name;
    public $maiden_name;
    public $date_of_birth;
    public $gender;
    public $civil_status;
    public $program_id;
    public $batch_year;
    public $permanent_address;
    public $current_address;
    public $mobile_number;
    public $email;
    public $alumni_id;
    public $password;
    public $password_confirmation;
    public $programs;
    public $batch_years;

    public function mount($account_id = null)
    {
        $this->account = User::findOrFail($account_id);
        $this->programs = Program::get();
        $this->batch_years = BatchYear::orderBy('batch_year', 'asc')->get()->pluck('batch_year')->toArray();

        if ($this->account)
        {
            $this->loadAccount();
        }
    }

    public function loadAccount() 
    {
        $this->last_name = $this->account->last_name;
        $this->first_name = $this->account->first_name;
        $this->middle_name = $this->account->middle_name;
        $this->maiden_name = $this->account->maiden_name;
        $this->date_of_birth = $this->account->date_of_birth;
        $this->gender = $this->account->gender;
        $this->civil_status = $this->account->civil_status;
        $this->program_id = $this->account->program_id;
        $this->batch_year = $this->account->batch_year;
        $this->permanent_address = $this->account->permanent_address;
        $this->current_address = $this->account->current_address;
        $this->mobile_number = $this->account->mobile_number;
        $this->email = $this->account->email;
        $this->alumni_id = $this->account->alumni_id;
    }

    public function submit()
    {
        $this->batch_year = trim($this->batch_year);

        $validated = $this->validate([
            'first_name'         => ['required', 'string', 'max:255'],
            'last_name'          => ['required', 'string', 'max:255'],
            'middle_name'        => ['required', 'string', 'max:255'],
            'maiden_name'        => ['nullable', 'string', 'max:255'],
            'date_of_birth'      => 'nullable|date',
            'gender'             => 'nullable|in:male,female',
            'civil_status'       => ['required', 'in:single,married,widowed,seperated'],
            'program_id'         => ['required', 'integer', 'exists:programs,id'],
            'batch_year' => [
                'required',
                'regex:/^\d{4}-\d{4}$/',
                'exists:batch_year,batch_year',
            ],
            'permanent_address'  => ['required', 'string', 'max:255'],
            'current_address'    => ['required', 'string', 'max:255'],
            'mobile_number'      => ['nullable', 'string', 'regex:/^[0-9]{10}$/', 'size:10'],    
            'email' => [
                    'nullable',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($this->account->id),
                ],

            'alumni_id' => [
                    'required', 
                    'string', 
                    'regex:/^ALU-\d{4}-\d{4,7}$/', 
                    'max:50',
                    Rule::unique('users', 'alumni_id')->ignore($this->account->id),
                ],
            ]);

        User::find($this->account->id)->update($validated);

        $this->dispatch('account-updated');
    }

    public function updatedBatchYear($value)
    {
        if (!empty($value)) {
            $yearParts = explode('-', $value);
            $year = $yearParts[1];

            $lastAlumni = User::where('batch_year', $value)
                ->orderBy('id', 'desc')
                ->first();

            if ($lastAlumni && !empty($lastAlumni->alumni_id)) {
                $parts = explode('-', $lastAlumni->alumni_id);
                $newNumber = isset($parts[2]) ? intval($parts[2]) + 1 : 1;
            } else {
                $newNumber = 1;
            }

            $this->alumni_id = sprintf("ALU-%s-%04d", $year, $newNumber);
        }
    }


    public function submitPassword()
    {
        $validated = $this->validate([
            'password' => ['required', 'confirmed', new \App\Rules\StrongPassword()],
        ]);

        User::find($this->account->id)->update($validated);

        $this->dispatch('password-updated');
        $this->password = "";
        $this->password_confirmation = "";
    }

    public function render()
    {
        return view('livewire.accounts.alumnus-edit');
    }
}
