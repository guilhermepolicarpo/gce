<?php

namespace App\Http\Livewire\Mentors;

use App\Models\Mentor;
use Livewire\Component;

class EditMentor extends Component
{
    public $mentorId;
    public $state = [];
    public $confirmingMentorEdditing = false;

    protected $rules = [
        'state.name' => 'required|string|min:2',
    ];

    protected $messages = [
        'state.name.required' => 'Por favor, informe o nome do mentor',
        'state.name.min' => 'O nome do mentor deve ter no mínimo 2 caracteres',
    ];

    public function render()
    {
        return view('livewire.mentors.edit-mentor');
    }

    public function confirmMentorEditing(Mentor $mentor)
    {
        $this->state = $mentor->toArray();
        $this->confirmingMentorEdditing = true;
    }

    public function saveMentor()
    {
        $validated = $this->validate();

        Mentor::where('id', $this->mentorId)->update($validated['state']);

        $this->confirmingMentorEdditing = false;
        $this->reset(['state']);
        $this->emitUp('mentorEddited');
    }
}
