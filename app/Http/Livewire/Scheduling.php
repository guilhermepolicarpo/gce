<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use Illuminate\Support\Carbon;

class Scheduling extends Component
{
    protected $appointments;
    public $sortBy = 'id';
    public $sortDesc = true;
    public $action;

    public $confirmingAppointmentDeletion = false;
    public $confirmingAppointmentAddition = false;

    public function render()
    {        
        $this->appointments = Schedule::paginate();

        return view('livewire.scheduling', [
            'appointments' => $this->appointments,
            'dateFormat' => Carbon::now(),
        ]);
    }
}
