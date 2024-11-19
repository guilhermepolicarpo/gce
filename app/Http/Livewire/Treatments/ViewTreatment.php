<?php

namespace App\Http\Livewire\Treatments;

use Livewire\Component;
use App\Models\Treatment;
use App\Models\Appointment;
use App\Traits\PhoneNumberFormater;

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
}
