<?php

namespace App\Http\Livewire\Mentors;

use App\Models\Mentor;
use Livewire\Component;

class DeleteMentor extends Component
{
    public $mentorId;
    public $confirmingMentorDeletion = false;

    public function render()
    {
        return view('livewire.mentors.delete-mentor');
    }

    public function confirmMentorDeletion()
    {
        $this->confirmingMentorDeletion = true;
    }

    public function deleteMentor()
    {
        Mentor::destroy($this->mentorId);
        $this->emitUp('mentorDeleted');
        $this->confirmingMentorDeletion = false;
    }
}
