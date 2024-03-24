<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Treatment;
use App\Models\Appointment;
use Livewire\WithPagination;
use App\Models\TypeOfTreatment;
use App\Traits\PhoneNumberFormater;
use Illuminate\Support\Facades\DB;

class Appointments extends Component
{
    use WithPagination;
    use PhoneNumberFormater;

    public $state = [
        'id' => '',
        'patient_id' => '',
        'date' => '',
        'treatment_type_id' => '',
        'treatment_mode' => 'Presencial',
        'notes' => '',
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
        'return_date' => null,
        'return_mode' => 'Presencial',
        'infiltracao' => null,
        'infiltracao_remove_date' => null,
        'healing_touches' => [
            ['healing_touch' => null, 'mode' => 'Presencial', 'quantity' => null],
        ],
        'magnetized_water_frequency' => null,
    ];
    public $treatment;
    public $patient;
    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;
    public $action;
    public $date;
    public $status = "";
    public $treatmentMode;
    public $treatmentType;
    public $confirmingSchedulingDeletion = false;
    public $confirmingSchedulingAddition = false;
    public $confirmingTreatmentAddition = false;
    public $confirmingArrivalOfTheAssisted = false;
    public $confirmingAbsentAssisted = false;
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
        'state.notes' => 'nullable|string',
    ];

    protected $messages = [
        'state.patient_id.required' => 'Por favor, selecione um assistido',
        'state.date.required' => 'Por favor, informe uma data de agendamento',
        'state.treatment_type_id.required' => 'Por favor, selecione um tipo de atendimento',
        'state.treatment_mode.required' => 'Por favor, selecione um modo de atendimento',
        'treatmentState.mentor_id.required' => 'Por favor, informe o mentor que realizou o atendimento',
        'treatmentState.return_date.after' => 'Por favor, informe uma data maior que a data atual',
        'treatmentState.healing_touches.*.quantity.min' => 'Por favor, informe uma quantidade maior que 0',
        'treatmentState.healing_touches.*.quantity.required' => 'Por favor, informe uma quantidade',
        'treatmentState.healing_touches.*.mode.required' => 'Por favor, informe o modo de atendimento',
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
        $appointments = Appointment::with(['patient.address', 'typeOfTreatment'])
            ->when($this->q, function ($query) {
                return $query
                    ->whereRelation('patient', 'name', 'like', '%' . $this->q . '%');
            })
            ->when($this->treatmentMode, function ($query) {
                return $query
                    ->where('treatment_mode', '=', $this->treatmentMode);
            })
            ->when($this->status, function ($query) {
                return $query
                    ->where('status', '=', $this->status);
            })
            ->when($this->treatmentType, function ($query) {
                return $query
                    ->where('treatment_type_id', '=', $this->treatmentType);
            })
            ->when($this->date, function ($query) {
                return $query
                    ->where('date', '=', $this->date);
            })
            ->orderBy($this->sortBy, $this->sortDesc ? 'DESC' : 'ASC')
            ->paginate(10);

        $healingTouchesList = typeOfTreatment::where('is_the_healing_touch', true)->get(['id', 'name']);

        return view('livewire.scheduling', [
            'appointments' => $appointments,
            'healingTouches' => $healingTouchesList
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

        $appointment = Appointment::where('id', $this->state['id'])->first();

        if (!empty($appointment->date) && !empty($this->state['date'])) {
            if ($appointment->date !== $this->state['date'] && $appointment->status !== 'Não atendido') {
                $appointment->status = 'Não atendido';
                $appointment->save();
            }
        }



        Appointment::updateOrCreate([
            'id' => $this->state['id'],
        ], [
            'patient_id' =>  $this->state['patient_id'],
            'date' => $this->state['date'],
            'treatment_type_id' => $this->state['treatment_type_id'],
            'treatment_mode' => $this->state['treatment_mode'],
            'notes' => $this->state['notes'],
            'status' => ($this->state['treatment_mode'] === 'A distância') ? 'Em espera' : 'Não atendido',
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

    public function confirmArrivalOfTheAssisted($appointmentId)
    {
        $this->confirmingArrivalOfTheAssisted = $appointmentId;
    }

    public function changeStatusToArrived(Appointment $appointment)
    {
        $appointment->status = "Em espera";
        $this->confirmingArrivalOfTheAssisted = false;
        $appointment->save();
    }


    public function confirmAbsentAssisted($appointmentId): void
    {
        $this->confirmingAbsentAssisted = $appointmentId;
    }

    public function changeStatusToAbsent(Appointment $appointment)
    {
        $appointment->status = "Faltou";
        $this->confirmingAbsentAssisted = false;
        $appointment->save();
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












    // Treatment

    public function addHealingTouch()
    {
        array_push($this->treatmentState['healing_touches'], ['healing_touch' => null, 'mode' => 'Presencial', 'quantity' => null]);
    }

    public function removeHealingTouch($key)
    {
        unset($this->treatmentState['healing_touches'][$key]);
    }

    public function confirmTreatmentAddition(Appointment $appointment)
    {
        $this->reset(['treatmentState']);
        $this->resetValidation();

        $treatmentType = TypeOfTreatment::where('id', $appointment->treatment_type_id)->first();

        if (!$appointment->treatment_id) {

            if (!$treatmentType->has_form) {

                try {
                    DB::beginTransaction();

                    $treatment = Treatment::create([
                        'patient_id' => $appointment->patient_id,
                        'treatment_type_id' => $appointment->treatment_type_id,
                        'treatment_mode' => $appointment->treatment_mode,
                        'date' => $appointment->date,
                    ]);

                    $appointment->treatment_id = $treatment->id;
                    $appointment->status = 'Atendido';
                    $appointment->save();

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['erro' => 'Ocorreu um erro no servidor.'], 500);
                }
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
            'treatmentState.return_mode' => 'nullable|string',
            'treatmentState.return_date' => 'nullable|date|after:today',
            'treatmentState.infiltracao' => 'nullable|string|max:255',
            'treatmentState.infiltracao_remove_date' => 'nullable|date|after:today',
            'treatmentState.healing_touches.*.healing_touch' => 'nullable|string|max:255',
            'treatmentState.healing_touches.*.quantity' => 'exclude_if:treatmentState.healing_touches.*.healing_touch,null|required|numeric|min:1',
            'treatmentState.healing_touches.*.mode' => 'exclude_if:treatmentState.healing_touches.*.healing_touch,null|required|string|max:255',
            'treatmentState.orientations.*' => 'nullable|numeric|exists:orientations,id',
            'treatmentState.medicines.*' => 'nullable|numeric|exists:medicines,id',
            'treatmentState.magnetized_water_frequency' => 'nullable|string|max:255',
        ]);

        foreach ($this->treatmentState['healing_touches'] as $key => $value) {
            if ($value['healing_touch'] == null) {
                unset($this->treatmentState['healing_touches'][$key]);
            };
        }

        try {
            DB::beginTransaction();

            $treatment = Treatment::create([
                'patient_id' => $this->treatmentState['patient_id'],
                'treatment_type_id' => $this->treatmentState['treatment_type_id'],
                'mentor_id' => $this->treatmentState['mentor_id'],
                'treatment_mode' => $this->treatmentState['treatment_mode'],
                'date' => $this->treatmentState['date'],
                'notes' => $this->treatmentState['notes'],
                'infiltracao' => $this->treatmentState['infiltracao'],
                'infiltracao_remove_date' => $this->treatmentState['infiltracao_remove_date'],
                'healing_touches' => $this->treatmentState['healing_touches'],
                'return_mode' => $this->treatmentState['return_mode'],
                'return_date' => $this->treatmentState['return_date'],
                'magnetized_water_frequency' => $this->treatmentState['magnetized_water_frequency'],
            ]);

            $treatment->orientations()->attach($this->treatmentState['orientations'], ['orientation_treatment_tenant_id' => auth()->user()->tenant_id]);
            $treatment->medicines()->attach($this->treatmentState['medicines'], ['medicine_treatment_tenant_id' => auth()->user()->tenant_id]);

            $appointment = Appointment::where('id', $this->treatment->id)->first();
            $appointment->treatment_id = $treatment->id;
            $appointment->status = 'Atendido';
            $appointment->save();

            if ($this->treatmentState['return_date']) {
                Appointment::create([
                    'patient_id' => $this->treatmentState['patient_id'],
                    'date' => $this->treatmentState['return_date'],
                    'treatment_type_id' => $this->treatmentState['treatment_type_id'],
                    'treatment_mode' => $this->treatmentState['return_mode'],
                ]);
            }

            DB::commit();

            $this->confirmingTreatmentAddition = false;

        } catch (\Exception $e) {

            DB::rollback();
            return response()->json(['erro' => 'Ocorreu um erro no servidor.'], 500);
        }
    }
}
