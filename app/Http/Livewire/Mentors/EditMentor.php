<?php

namespace App\Http\Livewire\Mentors;

use App\Models\Mentor;
use Livewire\Component;

class EditMentor extends Component
{
    public int $mentorId;
    public string $name = '';
    public $showEditModal = false;

    protected $rules = [
        'name' => 'required|string|min:2|max:255|unique:mentors,name',
    ];

    protected $messages = [
        'name.required' => 'Por favor, informe o nome do mentor',
        'name.min' => 'O nome do mentor deve ter no mínimo 2 caracteres',
        'name.max' => 'O nome do mentor deve ter no maximo 255 caracteres',
        'name.unique' => 'Já existe um mentor com este nome',
        'name.string' => 'O nome do mentor deve ser um texto',
    ];

    public function render()
    {
        return view('livewire.mentors.edit-mentor');
    }

    public function showEditModal(Mentor $mentor)
    {
        $this->name = $mentor->name;
        $this->showEditModal = true;
    }

    public function saveMentor()
    {
        $validated = $this->validate();

        Mentor::where('id', $this->mentorId)->update($validated);

        $this->showEditModal = false;
        $this->reset(['name']);
        $this->emitUp('mentorEdited');
    }
}
