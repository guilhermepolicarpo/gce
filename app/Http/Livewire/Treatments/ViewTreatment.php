<?php

namespace App\Http\Livewire\Treatments;

use App\Models\Treatment;
use App\Traits\PhoneNumberFormater;
use Livewire\Component;

class ViewTreatment extends Component
{
    use PhoneNumberFormater;
    
    public ?Treatment $treatment;
    public $treatmentId;
    public $dateFormat;
    public $openingTreatmentsModal = false;

    public function render()
    {
        return view('livewire.treatments.view-treatment');
    }

    public function openTreatmentsModal($treatmentId)
    {
        $this->treatment = Treatment::with('patient.address', 'treatmentType')->where('id', $this->treatmentId)->first();
        $this->openingTreatmentsModal = true;
    }
}
