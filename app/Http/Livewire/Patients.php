<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Patient;
use Livewire\WithPagination;

class Patients extends Component
{
    use WithPagination;

    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;

    public $confirmingPatientDeletion;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true]
    ];

    public function render()
    {
        $patients = Patient::when($this->q, function($query) {
            return $query->where(function($query){
                $query->where('name', 'like', '%'. $this->q . '%')
                ->orWhere('email', 'like', '%' . $this->q . '%');
            });
        })
        ->orderBy($this->sortBy, $this->sortDesc ? 'DESC' : 'ASC');

        $patients = $patients->paginate(10);

        return view('livewire.patients', [
            'patients' => $patients
        ]);
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortDesc = !$this->sortDesc;
        }
        $this->sortBy = $field;
    }

    public function confirmePatientDeletion(Patient $patient)
    {
        $patient->delete();
    }
}
