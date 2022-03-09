<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use Illuminate\Support\Carbon;
use App\Models\TypeOfTreatment;

class Scheduling extends Component
{
    public $state = [];
    public $sortBy = 'id';
    public $sortDesc = true;
    public $action;
    public $date;
    public $confirmingSchedulingDeletion = false;
    public $confirmingAppointmentAddition = false;

    protected $queryString = [
        'date',
    ];

    public function render()
    {        
        $today = date("y-m-d");
        $appointments = Schedule::where('date', $today)->paginate();
        $typesOfTreatment = TypeOfTreatment::all();

        return view('livewire.scheduling', [
            'appointments' => $appointments,
            'dateFormat' => Carbon::now(),
            'typesOfTreatment' => $typesOfTreatment,
        ]);
    }

    public function confirmSchedulingDeletion($id)
    {
        $this->confirmingSchedulingDeletion = $id;
    }

    public function deleteScheduling(Schedule $schedule)
    {
        $schedule->delete();
        $this->confirmingSchedulingDeletion = false;
    }
}
