<?php

namespace App\Http\Livewire\Treatments;

use Livewire\Component;
use App\Models\Treatment;
use App\Models\Appointment;
use App\Traits\PhoneNumberFormater;
use Illuminate\Support\Facades\DB;

class ViewTreatment extends Component
{
    use PhoneNumberFormater;

    public $treatment;
    public $appointment;

    public function mount($treatmentId)
    {
        $this->treatment = Treatment::with('patient.address', 'treatmentType')
            ->where('id', $treatmentId)
            ->first();

        $this->appointment = Appointment::where('treatment_id', $this->treatment->id)->first();
    }

    public function render()
    {
        return view('livewire.treatments.view-treatment');
    }

    public function deleteTreatment()
    {
        DB::transaction(function () {
            $appointment = Appointment::where('treatment_id', $this->treatment->id)->first();

            if ($appointment) {
                $appointment->update([
                    'treatment_id' => null,
                    'status' => $appointment->treatment_mode === 'A distância' ? 'Em espera' : 'Não atendido',
                ]);
            }

            $this->treatment->medicines()->detach();
            $this->treatment->orientations()->detach();
            $this->treatment->attachments()->delete();
            $this->treatment->delete();
        });

        return redirect()->route('patientTreatments', $this->treatment->patient_id);
    }
}
