<?php

namespace App\Http\Livewire;

use App\Models\Patient;
use Livewire\Component;
use App\Models\Appointment;
use Livewire\WithPagination;
use App\Models\TypeOfTreatment;
use Illuminate\Support\Facades\Cache;

class Appointments extends Component
{
    use WithPagination;

    public $state = [
        'id' => '',
        'patient_id' => '',
        'date' => '',
        'treatment_type_id' => '',
        'treatment_mode' => 'Presencial',
        'treatment_id' => '',
    ];
    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;
    public $action;
    public $date;
    public $status = "Não atendido";
    public $treatmentMode;
    public $treatmentType;
    public $confirmingSchedulingDeletion = false;
    public $confirmingSchedulingAddition = false;
    public $dateFormat;
    public $patients;
    public $typesOfTreatment;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true],
        'date' => ['except' => ''],
        'status' => ['except' => ''],
        'treatmentType' => ['except' => ''],
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

    public function mount()
    {   
        $this->patients = Patient::with('address')->orderBy('name', 'asc')->get();
        $this->typesOfTreatment = TypeOfTreatment::orderBy('name', 'asc')->get();
        $this->dateFormat = now();

        if (!isset($this->date)) {
            $this->date = date('Y-m-d');
        }
    }

    public function render()
    {
        $appointments = Appointment::with(['patient:id,name', 'typeOfTreatment:id,name'])
            ->when($this->q, function($query) {
                return $query
                    ->whereRelation('patient', 'name', 'like', '%'.$this->q.'%');
            })
            ->when($this->treatmentMode, function($query) {
                return $query
                    ->where('treatment_mode', '=', $this->treatmentMode);
            })
            ->when($this->status, function($query) {
                if ($this->status == "Não atendido") {
                    return $query
                        ->whereNull('treatment_id');
                } else {
                    return $query
                        ->whereNotNull('treatment_id');
                }
            })
            ->when($this->treatmentType, function($query) {
                return $query
                    ->where('treatment_type_id', '=', $this->treatmentType);
            })
            ->when($this->date, function($query) {
                return $query
                    ->where('date', '=', $this->date);
            })
            ->orderBy($this->sortBy, $this->sortDesc ? 'DESC' : 'ASC')
            ->paginate(10);

        return view('livewire.scheduling', [
            'appointments' => $appointments,
        ]);
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

    public function deleteScheduling(Appointment $appointment)
    {
        $appointment->delete();
        $this->confirmingSchedulingDeletion = false;
    }

    public function confirmSchedulingAddition()
    {
        $this->reset(['state']);
        $this->resetValidation();
        $this->action = 'adding';
        $this->confirmingSchedulingAddition = true;
    }

    public function saveScheduling()
    {
        $this->validate();

        Appointment::updateOrCreate([
            'id' => $this->state['id'],
        ],[
            'patient_id' =>  $this->state['patient_id'],
            'date' => $this->state['date'],
            'treatment_type_id' => $this->state['treatment_type_id'],
            'treatment_mode' => $this->state['treatment_mode'],
        ]);

        $this->confirmingSchedulingAddition = false;
    }

    public function confirmSchedulingEditing(Appointment $appointment)
    {
        $this->reset(['state']);
        $this->state = $appointment;      
        $this->action = 'editing';
        $this->confirmingSchedulingAddition = true;
        $this->resetValidation();
    }

    public function updatingQ()
    {
        $this->resetPage();
    }
    public function updatingStatus()
    {
        $this->resetPage();
    }
    public function updatingDate()
    {
        $this->resetPage();
    }
    public function updatingTreatmentType()
    {
        $this->resetPage();
    }
    public function updatingTreatmentMode()
    {
        $this->resetPage();
    }
}