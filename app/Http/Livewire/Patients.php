<?php

namespace App\Http\Livewire;

use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Patients extends Component
{
    use WithPagination;

    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;
    public $patient;

    public $confirmingPatientDeletion = false;
    public $confirmingPatientAddition = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true]
    ];

    protected $rules = [
        'patient.name' => 'required|string|min:4',
        'patient.address' => 'required|string|min:4',
    ];

    public function render()
    {
        //$addresses = Address::all();
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
            //'addresses' => $addresses
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

    public function confirmPatientDeletion($id)
    {
        $this->confirmingPatientDeletion = $id;
    }

    public function deletePatient(Patient $patient)
    {
        $patient->delete();
        $this->confirmingPatientDeletion = false;
    }

    public function confirmPatientAddition()
    {
        $this->reset(['patient']);
        $this->confirmingPatientAddition = true;
    }

    public function addPatient()
    {
        $this->validate();

        DB::beginTransaction();
        
        $patient = Patient::create([
            'name' => $this->patient['name'],
            'email' => $this->patient['email'],
            'phone' => $this->patient['phone'],
            'birth' => $this->patient['birth']
        ]);

        $patient->address()->create([
            'address' => $this->patient['address'],
            'number' => $this->patient['number'],
            'neighborhood' => $this->patient['neighborhood'],
            'cep' => $this->patient['cep'],
            'complement' => $this->patient['complement'],
            'state' => $this->patient['state'],
            'city' => $this->patient['city']
        ]);

        DB::commit();

        $this->confirmingPatientAddition = false;
    }
}
