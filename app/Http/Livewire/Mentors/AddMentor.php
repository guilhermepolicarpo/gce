<?php

namespace App\Http\Livewire\Mentors;

use App\Models\Mentor;
use Illuminate\Auth\Events\Validated;
use Livewire\Component;

class AddMentor extends Component
{
    public $state = [];
    public $confirmingMentorAddition = false;

    protected $rules = [
        'state.name' => 'required|string|min:2',
    ];

    protected $messages = [
        'state.name.required' => 'Por favor, informe o nome do mentor',
        'state.name.min' => 'O nome do mentor deve ter no mínimo 2 caracteres',
    ];


    public function render()
    {
        return view('livewire.mentors.add-mentor');
    }

    public function confirmMentorAddition()
    {
        $this->reset(['state']);
        $this->confirmingMentorAddition = true;
    }

    public function saveMentor()
    {
        $validated = $this->validate();

        Mentor::create($validated['state']);

        $this->emitUp('mentorAdded');
        $this->confirmingMentorAddition = false;
        $this->reset(['state']);
    }
}
