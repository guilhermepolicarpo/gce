<?php

namespace App\Http\Livewire\Treatments;

use App\Models\Treatment;
use App\Models\TypeOfTreatment;
use App\Traits\PhoneNumberFormater;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    use PhoneNumberFormater;

    public $treatment;
    public $healingTouches;

    public $treatmentState = [
        'mentor_id' => null,
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

    protected $rules = [
        'treatmentState.mentor_id' => 'required|numeric',
        'treatmentState.notes' => 'nullable|string',
        'treatmentState.return_mode' => 'nullable|string',
        'treatmentState.return_date' => 'nullable|date',
        'treatmentState.infiltracao' => 'nullable|string|max:255',
        'treatmentState.infiltracao_remove_date' => 'nullable|date',
        'treatmentState.healing_touches.*.healing_touch' => 'nullable|string|max:255',
        'treatmentState.healing_touches.*.quantity' => 'exclude_if:treatmentState.healing_touches.*.healing_touch,null|required|numeric|min:1',
        'treatmentState.healing_touches.*.mode' => 'exclude_if:treatmentState.healing_touches.*.healing_touch,null|required|string|max:255',
        'treatmentState.orientations.*' => 'nullable|numeric|exists:orientations,id',
        'treatmentState.medicines.*' => 'nullable|numeric|exists:medicines,id',
        'treatmentState.magnetized_water_frequency' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'treatmentState.mentor_id.required' => 'Por favor, informe o mentor que realizou o atendimento',
        'treatmentState.healing_touches.*.quantity.min' => 'Por favor, informe uma quantidade maior que 0',
        'treatmentState.healing_touches.*.quantity.required' => 'Por favor, informe uma quantidade',
        'treatmentState.healing_touches.*.mode.required' => 'Por favor, informe o modo de atendimento',
    ];

    public function mount($treatmentId)
    {
        $this->treatment = Treatment::with(['patient.address', 'treatmentType', 'medicines', 'orientations'])
            ->where('id', $treatmentId)
            ->firstOrFail();

        $this->treatmentState['mentor_id'] = $this->treatment->mentor_id;
        $this->treatmentState['notes'] = $this->treatment->notes;
        $this->treatmentState['orientations'] = $this->treatment->orientations->pluck('id')->toArray();
        $this->treatmentState['medicines'] = $this->treatment->medicines->pluck('id')->toArray();
        $this->treatmentState['return_date'] = $this->treatment->return_date;
        $this->treatmentState['return_mode'] = $this->treatment->return_mode ?? 'Presencial';
        $this->treatmentState['infiltracao'] = $this->treatment->infiltracao;
        $this->treatmentState['infiltracao_remove_date'] = $this->treatment->infiltracao_remove_date;
        $this->treatmentState['healing_touches'] = $this->treatment->healing_touches ?: [
            ['healing_touch' => null, 'mode' => 'Presencial', 'quantity' => null],
        ];
        $this->treatmentState['magnetized_water_frequency'] = $this->treatment->magnetized_water_frequency;

        $this->healingTouches = TypeOfTreatment::where('is_the_healing_touch', true)->get(['id', 'name']);
    }

    public function render()
    {
        return view('livewire.treatments.edit');
    }

    public function addHealingTouch()
    {
        array_push($this->treatmentState['healing_touches'], ['healing_touch' => null, 'mode' => 'Presencial', 'quantity' => null]);
    }

    public function removeHealingTouch($key)
    {
        unset($this->treatmentState['healing_touches'][$key]);
    }

    public function updateTreatment()
    {
        $this->validate();

        foreach ($this->treatmentState['healing_touches'] as $key => $value) {
            if ($value['healing_touch'] == null) {
                unset($this->treatmentState['healing_touches'][$key]);
            }
        }

        $orientationSync = collect($this->treatmentState['orientations'])
            ->filter()
            ->mapWithKeys(function ($orientationId) {
                return [
                    $orientationId => ['orientation_treatment_tenant_id' => auth()->user()->tenant_id],
                ];
            })->toArray();

        $medicineSync = collect($this->treatmentState['medicines'])
            ->filter()
            ->mapWithKeys(function ($medicineId) {
                return [
                    $medicineId => ['medicine_treatment_tenant_id' => auth()->user()->tenant_id],
                ];
            })->toArray();

        try {
            DB::beginTransaction();

            $this->treatment->update([
                'mentor_id' => $this->treatmentState['mentor_id'],
                'notes' => $this->treatmentState['notes'],
                'infiltracao' => $this->treatmentState['infiltracao'],
                'infiltracao_remove_date' => $this->treatmentState['infiltracao_remove_date'],
                'healing_touches' => array_values($this->treatmentState['healing_touches']),
                'return_mode' => $this->treatmentState['return_mode'],
                'return_date' => $this->treatmentState['return_date'],
                'magnetized_water_frequency' => $this->treatmentState['magnetized_water_frequency'],
            ]);

            $this->treatment->orientations()->sync($orientationSync);
            $this->treatment->medicines()->sync($medicineSync);

            DB::commit();

            return redirect()->route('treatmentView', $this->treatment->id);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['erro' => 'Ocorreu um erro no servidor.'], 500);
        }
    }

    public function cancel()
    {
        return redirect()->route('treatmentView', $this->treatment->id);
    }
}
