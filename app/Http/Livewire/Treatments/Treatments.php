<?php

namespace App\Http\Livewire\Treatments;

use Livewire\Component;
use App\Traits\PhoneNumberFormater;
use App\Models\Treatment;

class Treatments extends Component
{
    use PhoneNumberFormater;

    public $patientId;

    public function mount($patientId)
    {
        $this->patientId = $patientId;
    }

    public function render()
    {
        $treatments = Treatment::with([
            'patient',
            'mentor',
            'attachments',
            'treatmentType',
            'medicines' => function ($query) {
                $query->withTrashed();
            },
            'orientations' => function ($query) {
                $query->withTrashed();
            }
        ])
            ->where('patient_id', $this->patientId)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $patientOfTheTreatment = $treatments->isNotEmpty() ? $treatments->first()->patient : null;

        return view('livewire.treatments.treatments', [
            'treatments' => $treatments,
            'patientOfTheTreatment' => $patientOfTheTreatment,
        ]);
    }
}
