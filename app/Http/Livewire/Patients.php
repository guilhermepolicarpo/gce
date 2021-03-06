<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class Patients extends Component
{
    use WithPagination;

    public $carbon;
    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;
    public $action;
    public $patient = [
        'id' => null,
        'email' => null,
        'phone' => null,
        'birth' => null,
        'address_id' => null,
        'address' => '',
        'number' => '',
        'neighborhood' => '',
        'zip_code' => '',
        'complement' => '',
        'state' => 'MG',
        'city' => ''
    ];

    public $confirmingPatientDeletion = false;
    public $confirmingPatientAddition = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true]
    ];

    protected $rules = [
        'patient.name' => 'required|string|min:4',
        'patient.email' => 'nullable|email',
        'patient.phone' => 'nullable|string',
        'patient.birth' => 'nullable|date',
        'patient.address' => 'nullable|string|min:4',
        'patient.number' => 'nullable|string',
        'patient.neighborhood' => 'nullable|string',
        'patient.zip_code' => 'nullable|string',
        'patient.complement' => 'nullable|string',
        'patient.state' => 'nullable|string|max:2',
        'patient.city' => 'nullable|string'        
    ];

    protected $messages = [
        'patient.name.required' => 'Informe o nome do paciente.',
        'patient.email.email' => 'Informe um e-mail válido.',
        'patient.birth.date' => 'Informe uma data válida.',
        'patient.state.max' => 'O estádo não deve ter mais de 2 caracteres.',
    ];

    public function render()
    {
        
        $this->carbon = Carbon::now();       

        $patients = Patient::with('address')
            ->when($this->q, function($query) {
                return $query
                    ->whereRelation('address', 'address', 'like', '%'.$this->q.'%')
                    ->orWhere(function($query){
                        $query->where('name', 'like', '%'. $this->q . '%')
                        ->orWhere('email', 'like', '%' . $this->q . '%')
                        ->orWhere('phone', 'like', '%' . $this->q . '%');
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
        $this->action = 'adding';
        $this->confirmingPatientAddition = true;
    }

    public function confirmPatientEditing(Patient $patient)
    {
        $this->patient = [
            'id' => $patient->id,
            'name' => $patient->name,
            'email' => $patient->email,
            'phone' => $patient->phone,
            'birth' => $patient->birth,
            'address_id' => $patient->address_id,
            'address' => $patient->address->address,
            'number' => $patient->address->number,
            'neighborhood' => $patient->address->neighborhood,
            'zip_code' => $patient->address->zip_code,
            'complement' => $patient->address->complement,
            'state' => $patient->address->state,
            'city' => $patient->address->city
        ];
        
        $this->action = 'editing';
        $this->confirmingPatientAddition = true;
    }

    public function addPatient()
    {
        $this->validate();

        DB::beginTransaction();

        $address = Address::updateOrCreate(
            [
                'id' => $this->patient['address_id']
            ],
            [
                'address' => $this->patient['address'],
                'number' => $this->patient['number'],
                'neighborhood' => $this->patient['neighborhood'],
                'zip_code' => $this->patient['zip_code'],
                'complement' => $this->patient['complement'],
                'state' => $this->patient['state'],
                'city' => $this->patient['city']
            ]
            );

        Patient::updateOrCreate(
            [
                'id' => $this->patient['id']
            ],
            [
                'address_id' => $address->id,
                'name' => $this->patient['name'],
                'email' => $this->patient['email'],
                'phone' => $this->patient['phone'],
                'birth' => $this->patient['birth']
            ]
        );
    
        DB::commit();

        $this->confirmingPatientAddition = false;
    }

    public function searchZipCode($zipCode)
    {
        $zipCode = preg_replace('/[^0-9]/', '', $zipCode);

        $response = Http::get('https://viacep.com.br/ws/'. $zipCode .'/json/');
        $response = $response->json();
        
        if ($response) {
            if (empty($response['erro'])) {
                $this->patient['address'] = $response['logradouro'];
                $this->patient['neighborhood'] = $response['bairro'];
                $this->patient['state'] = $response['uf'];
                $this->patient['city'] = $response['localidade'];
            }
        }        
    }
}
