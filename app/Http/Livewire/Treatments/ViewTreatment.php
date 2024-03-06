<?php

namespace App\Http\Livewire\Treatments;

use App\Models\Treatment;
use Livewire\Component;

class ViewTreatment extends Component
{
    public ?Treatment $treatment;
    public $treatmentId;
    public $dateFormat;
    public $openingTreatmentsModal = false;

    public function mount()
    {
        $this->dateFormat = now();
    }

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
