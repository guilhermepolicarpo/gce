<?php

namespace App\Http\Livewire;

use App\Models\Patient;
use Livewire\Component;
use App\Models\Schedule;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use App\Models\TypeOfTreatment;

class Scheduling extends Component
{
    use WithPagination;

    public $state = [
        'patient_id' => '',
        'date' => '',
        'treatment_type_id' => '',
        'treatment_mode' => '',
        'statys' => 'Não atendido',
    ];
    public $sortBy = 'patient_id';
    public $sortDesc = true;
    public $action;
    public $date;
    public $confirmingSchedulingDeletion = false;
    public $confirmingSchedulingAddition = false;
    public $today;

    protected $queryString = [
        'date',
    ];

    

    protected $rules = [
        'state.patient_id' => 'required|numeric',
        'state.date' => 'required|date',
        'state.treatment_type_id' => 'required|numeric',
        'state.treatment_mode' => 'required|string',
    ];

    public function render()
    {
        //$appointments = Schedule::where('date', $this->today)->paginate();
        $appointments = Schedule::paginate();
        $typesOfTreatment = TypeOfTreatment::all();
        $patients = Patient::all();

        return view('livewire.scheduling', [
            'appointments' => $appointments,
            'dateFormat' => Carbon::now(),
            'typesOfTreatment' => $typesOfTreatment,
            'patients' => $patients,
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

    public function confirmSchedulingAddition()
    {
        $this->reset(['state']);
        $this->action = 'adding';
        $this->confirmingSchedulingAddition = true;
    }

    public function saveScheduling(Schedule $schedule)
    {
        $schedule->create($this->state);
        $this->confirmingSchedulingAddition = false;
    }
}
