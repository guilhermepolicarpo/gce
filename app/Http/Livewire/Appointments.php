<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Treatment;
use App\Models\Appointment;
use Livewire\WithPagination;
use App\Models\TypeOfTreatment;
use Illuminate\Support\Facades\DB;
use App\Traits\PhoneNumberFormater;

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

    public $saveModal;
    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;
    public $date;
    public $status = "";
    public $treatmentMode;
    public $treatmentType;
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
        'state.patient_id' => 'required|numeric|exists:patients,id',
        'state.date' => 'required|date|after:yesterday',
        'state.treatment_type_id' => 'required|numeric',
        'state.treatment_mode' => 'required|string|max:255',
        'state.notes' => 'nullable|string|max:65535',
    ];

    protected $messages = [
        'state.patient_id.required' => 'Por favor, selecione um assistido',
        'state.patient_id.exists' => 'Por favor, selecione um assistido',
        'state.date.required' => 'Por favor, informe uma data de agendamento',
        'state.date.date' => 'Por favor, informe uma data de agendamento',
        'state.treatment_type_id.required' => 'Por favor, selecione um tipo de atendimento',
        'state.treatment_type_id.exists' => 'Por favor, selecione um tipo de atendimento',
        'state.treatment_mode.required' => 'Por favor, selecione um modo de atendimento',
    ];

    public function mount()
    {
        $this->typesOfTreatment = TypeOfTreatment::orderBy('name', 'asc')->get();

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
            ->paginate(15);


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

    public function deleteScheduling(Appointment $appointment)
    {
        $appointment->delete();
    }

    public function saveScheduling()
    {
        $this->validate();

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

        $this->saveModal = false;
    }


    public function getAppointment(Appointment $appointment)
    {
        $this->state = $appointment->toArray();
    }

    public function changeStatusToArrived(Appointment $appointment)
    {
        $appointment->status = "Em espera";
        $appointment->save();
    }

    public function changeStatusToAbsent(Appointment $appointment)
    {
        $appointment->status = "Faltou";
        $appointment->save();
    }


    public function treatmentCreate(Appointment $appointment)
    {
        $hasForm = TypeOfTreatment::where('id', $appointment->treatment_type_id)->first()->has_form;

        if($hasForm) {
            return redirect()->route('TreatmentCreate', $appointment->id);
        }

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
    }

    public function resetData(): void
    {
        $this->reset(['state']);
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
