<?php

namespace App\Http\Livewire\Mentors;

use App\Models\Mentor;
use Livewire\Component;

class AddMentor extends Component
{
    public string $name = '';
    public bool $showModal = false;

    protected $rules = [
        'name' => 'required|string|min:2|max:100|unique:mentors,name',
    ];

    protected $messages = [
        'name.required' => 'Por favor, informe o nome do mentor',
        'name.min' => 'O nome do mentor deve ter no mínimo 2 caracteres',
        'name.max' => 'O nome do mentor deve ter no maximo 100 caracteres',
        'name.unique' => 'Já existem um mentor com este nome',
        'name.string' => 'O nome do mentor deve ser um texto',
    ];

    public function render()
    {
        return view('livewire.mentors.add-mentor');
    }

    public function showAddModal()
    {
        $this->reset(['name']);
        $this->showModal = true;
    }

    public function saveMentor()
    {
        $validated = $this->validate();

        Mentor::create($validated);

        $this->emitUp('mentorAdded');
        $this->showModal = false;
    }
}
