<?php

namespace App\Livewire\Configuration;

use Livewire\Component;
use App\Models\Program;

class Programs extends Component
{
    public $programs;
    public $program_name;
    public $program_abbreviation;

    public function mount()
    {
        $this->loadPrograms();
    }

    public function loadPrograms()
    {
        $this->programs = Program::get();
    }

    public function submit()
    {
        $this->program_name = trim($this->program_name);
        $this->program_abbreviation = trim($this->program_abbreviation);

        $validated = $this->validate([
            'program_name' => ['required', 'string', 'max:255', 'unique:programs,program_name'],
            'program_abbreviation' => ['required', 'string', 'max:25']
        ]);

        Program::create($validated);

        $this->resetForm();
        $this->loadPrograms();
        $this->dispatch('program-added');
    }

    public function setFormToUpdate($id)
    {
        if (!$id) return;

        $program = Program::findOrFail($id);

        if ($program)
        {
            $this->program_name = $program->program_name;
            $this->program_abbreviation = $program->program_abbreviation;
        }
    }

    public function updateProgram($id)
    {
        if (!$id) return;

        $this->program_name = trim($this->program_name);
        $this->program_abbreviation = trim($this->program_abbreviation);

        $validated = $this->validate([
            'program_name' => ['required', 'string', 'max:255', 'unique:programs,program_name'],
            'program_abbreviation' => ['required', 'string', 'max:25']
        ]);

        $program = Program::findOrFail($id);
        $program->update($validated);

        $this->resetForm();
        $this->loadPrograms();
        $this->dispatch('program-updated');
    }

    public function resetForm()
    {
        $this->reset(
            'program_name',
            'program_abbreviation',
        );
    }

    public function deleteProgram($id)
    {
        if (!$id) return;
    
        $program = Program::find($id);

        if ($program) {
            $program->delete();
            $this->dispatch('program-deleted');
        }

        $this->loadPrograms();
    }

    public function render()
    {
        return view('livewire.configuration.programs');
    }
}
