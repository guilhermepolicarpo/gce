<?php

namespace App\Http\Livewire\Treatments;

use Livewire\Component;
use App\Models\Treatment;
use App\Models\Appointment;
use App\Models\TypeOfTreatment;
use Illuminate\Support\Facades\DB;
use App\Traits\PhoneNumberFormater;

class Create extends Component
{
    use PhoneNumberFormater;

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
    public $healingTouches;

    protected $rules = [
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
    ];

    protected $messages = [
        'treatmentState.mentor_id.required' => 'Por favor, informe o mentor que realizou o atendimento',
        'treatmentState.return_date.after' => 'Por favor, informe uma data maior que a data atual',
        'treatmentState.healing_touches.*.quantity.min' => 'Por favor, informe uma quantidade maior que 0',
        'treatmentState.healing_touches.*.quantity.required' => 'Por favor, informe uma quantidade',
        'treatmentState.healing_touches.*.mode.required' => 'Por favor, informe o modo de atendimento',
    ];

    public function mount($appointmentId)
    {
        $this->treatment = Appointment::with(['patient.address', 'typeOfTreatment'])->where('id', $appointmentId)->first();

        if ($this->treatment->treatment_id) {
            return redirect()->route('schedule');
        }

        $this->healingTouches = typeOfTreatment::where('is_the_healing_touch', true)->get(['id', 'name']);
    }

    public function render()
    {
        return view('livewire.treatments.create');
    }

    public function addHealingTouch()
    {
        array_push($this->treatmentState['healing_touches'], ['healing_touch' => null, 'mode' => 'Presencial', 'quantity' => null]);
    }

    public function removeHealingTouch($key)
    {
        unset($this->treatmentState['healing_touches'][$key]);
    }

    public function saveTreatment()
    {

        $this->treatmentState['tenant_id'] = $this->treatment->tenant_id;
        $this->treatmentState['patient_id'] = $this->treatment->patient_id;
        $this->treatmentState['treatment_type_id'] = $this->treatment->treatment_type_id;
        $this->treatmentState['date'] = $this->treatment->date;
        $this->treatmentState['treatment_mode'] = $this->treatment->treatment_mode;

        $this->validate();
        
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
                    'notes' => 'Retorno',
                ]);
            }

            DB::commit();

            return redirect()->route('schedule');

        } catch (\Exception $e) {

            DB::rollback();
            return response()->json(['erro' => 'Ocorreu um erro no servidor.'], 500);
        }
    }

    public function cancel()
    {
        return redirect()->route('schedule');
    }
}
