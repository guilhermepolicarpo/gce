<?php

namespace App\Http\Livewire\Treatments;

use App\Models\Treatment;
use App\Traits\PhoneNumberFormater;
use Livewire\Component;

class ViewTreatment extends Component
{
    use PhoneNumberFormater;

    public $treatment;

    public function mount($treatmentId)
    {
        $this->treatment = Treatment::with('patient.address', 'treatmentType')
            ->where('id', $treatmentId)
            ->first();
    }

    public function render()
    {
        return view('livewire.treatments.view-treatment');
    }
}
