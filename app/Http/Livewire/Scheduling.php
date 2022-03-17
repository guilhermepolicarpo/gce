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
        'id' => '',
        'patient_id' => '',
        'date' => '',
        'treatment_type_id' => '',
        'treatment_mode' => '',
        'statys' => 'Não atendido',
    ];
    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;
    public $action;
    public $date;
    public $confirmingSchedulingDeletion = false;
    public $confirmingSchedulingAddition = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true]
    ];

    protected $rules = [
        'state.patient_id' => 'required|numeric',
        'state.date' => 'required|date',
        'state.treatment_type_id' => 'required|numeric',
        'state.treatment_mode' => 'required|string',
    ];

    protected $messages = [
        'state.patient_id.required' => 'Por favor, selecione um paciente',
        'state.date.required' => 'Por favor, informe uma data de agendamento',
        'state.treatment_type_id.required' => 'Por favor, selecione um tipo de tratamento',
        'state.treatment_mode.required' => 'Por favor, selecione um modo de tratamento',
    ];

    public function render()
    {
        $appointments = Schedule::with(['patient'])
            ->when($this->q, function($query) {
                return $query
                    ->whereRelation('patient', 'name', 'like', '%'.$this->q.'%')
                    ->orWhereRelation('typeOfTreatment', 'name', 'like', '%'.$this->q.'%')
                    ->orWhere('treatment_mode', 'like', '%'.$this->q.'%');
            })
            ->orderBy($this->sortBy, $this->sortDesc ? 'DESC' : 'ASC');

        $appointments = $appointments->paginate(10);

        $typesOfTreatment = TypeOfTreatment::all();
        $patients = Patient::all();

        return view('livewire.scheduling', [
            'appointments' => $appointments,
            'dateFormat' => Carbon::now(),
            'typesOfTreatment' => $typesOfTreatment,
            'patients' => $patients,
        ]);
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortDesc = !$this->sortDesc;
        }
        $this->sortBy = $field;
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

    public function saveScheduling()
    {
        $this->validate();

        Schedule::updateOrCreate([
            'id' => $this->state['id'],
        ],[
            'patient_id' =>  $this->state['patient_id'],
            'date' => $this->state['date'],
            'treatment_type_id' => $this->state['treatment_type_id'],
            'treatment_mode' => $this->state['treatment_mode'],
            'status' => 'Não atendido',
        ]);

        $this->confirmingSchedulingAddition = false;
    }

    public function confirmSchedulingEditing(Schedule $schedule)
    {
        $this->state = $schedule;      
        $this->action = 'editing';
        $this->confirmingSchedulingAddition = true;
    }
}