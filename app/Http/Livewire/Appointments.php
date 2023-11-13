<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Treatment;
use App\Models\Appointment;
use Livewire\WithPagination;
use App\Models\TypeOfTreatment;
use Illuminate\Support\Facades\DB;

class Appointments extends Component
{
    use WithPagination;

    public $state = [
        'id' => '',
        'patient_id' => '',
        'date' => '',
        'treatment_type_id' => '',
        'treatment_mode' => 'Presencial',
        'status' => '',
    ];
    public $treatmentState = [
        'patient_id' => null,
        'treatment_type_id' => null,
        'mentor_id' => null,
        'date' => null,
        'treatment_mode' => null,
        'notes' => null,
        'orientations' => [],
        'medicines' => [],
    ];
    public $treatment;
    public $patient;
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
    public $confirmingTreatmentAddition = false;
    public $dateFormat;
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
        'state.patient_id.required' => 'Por favor, selecione um assistido',
        'state.date.required' => 'Por favor, informe uma data de agendamento',
        'state.treatment_type_id.required' => 'Por favor, selecione um tipo de atendimento',
        'state.treatment_mode.required' => 'Por favor, selecione um modo de atendimento',
    ];

    public function mount()
    {   
        $this->typesOfTreatment = TypeOfTreatment::orderBy('name', 'asc')->get();
        $this->dateFormat = now();

        if (!isset($this->date)) {
            $this->date = date('Y-m-d');
        }
    }

    public function render()
    {        
        $appointments = Appointment::with(['patient', 'typeOfTreatment'])
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
                        ->whereNull('status');
                } else {
                    return $query
                        ->whereNotNull('status');
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



    // Treatment
    public function confirmTreatmentAddition(Appointment $appointment)
    {
        $this->reset(['treatmentState']);
        $this->resetValidation();

        $treatmentType = TypeOfTreatment::where('id', $appointment->treatment_type_id)->first();
        
        if (!$appointment->status) {
            
            if($treatmentType->is_the_healing_touch) {
    
                DB::beginTransaction();
    
                $treatment = Treatment::create([
                    'patient_id' => $appointment->patient_id,
                    'treatment_type_id' => $appointment->treatment_type_id,
                    'treatment_mode' => $appointment->treatment_mode,
                    'date' => $appointment->date,
                ]);
                
                $appointment->status = $treatment->id;
                $appointment->save();
                
                DB::commit();
    
            } else {
    
                $this->reset(['treatment']);
                $this->treatment = Appointment::with(['patient.address', 'typeOfTreatment'])->where('id', $appointment->id)->first();                
                $this->confirmingTreatmentAddition = true;         
            }
        }
    }

    public function saveTreatment()
    {
        $this->treatmentState['tenant_id'] = $this->treatment->tenant_id;
        $this->treatmentState['patient_id'] = $this->treatment->patient_id;
        $this->treatmentState['treatment_type_id'] = $this->treatment->treatment_type_id;
        $this->treatmentState['date'] = $this->treatment->date;
        $this->treatmentState['treatment_mode'] = $this->treatment->treatment_mode;
        
        $this->validate([
            'treatmentState.patient_id' => 'required|numeric',
            'treatmentState.treatment_type_id' => 'required|numeric',
            'treatmentState.mentor_id' => 'required|numeric',
            'treatmentState.date' => 'required|date',
            'treatmentState.treatment_mode' => 'required|string',
            'treatmentState.notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        
        $treatment = Treatment::create([
            'patient_id' => $this->treatmentState['patient_id'],
            'treatment_type_id' => $this->treatmentState['treatment_type_id'],
            'mentor_id' => $this->treatmentState['mentor_id'],
            'treatment_mode' => $this->treatmentState['treatment_mode'],
            'date' => $this->treatmentState['date'],
            'notes' => $this->treatmentState['notes'],
        ]);

        $treatment->orientations()->attach($this->treatmentState['orientations'], ['orientation_treatment_tenant_id' => $treatment->tenant_id]);
        $treatment->medicines()->attach($this->treatmentState['medicines'], ['medicine_treatment_tenant_id' => $treatment->tenant_id]);

        $appointment = Appointment::where('id', $this->treatment->id)->first();
        $appointment->status = $treatment->id;
        $appointment->save();

        DB::commit();

        $this->confirmingTreatmentAddition = false;         

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