<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Address;
use App\Models\Patient;
use Livewire\Component;
use App\Models\Treatment;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Traits\HandleText;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Patients extends Component
{
    use WithPagination;
    use HandleText;

    public $carbon;
    public $dateFormat;
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
        'state' => 'MG',
        'city' => ''
    ];
    public $treatments = [];
    public $patientOfTheTreatment;
    public $confirmingPatientDeletion = false;
    public $confirmingPatientAddition = false;
    public $openingTreatmentsModal = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true]
    ];

    protected $rules = [
        'patient.name' => 'required|string|min:4',
        'patient.email' => 'nullable|email',
        'patient.phone' => 'required|string',
        'patient.birth' => 'required|date',
        'patient.address' => 'nullable|string|min:4',
        'patient.number' => 'nullable|string',
        'patient.neighborhood' => 'nullable|string',
        'patient.zip_code' => 'nullable|string|min:8',
        'patient.state' => 'nullable|string|max:2',
        'patient.city' => 'nullable|string'
    ];

    protected $messages = [
        'patient.name.required' => 'Informe o nome do assistido.',
        'patient.name.min' => 'Informe um nome válido',
        'patient.phone.required' => 'Informe o telefone do assistido.',
        'patient.birth.required' => 'Informe a data de nascimento do assistido.',
        'patient.email.email' => 'Informe um e-mail válido.',
        'patient.birth.date' => 'Informe uma data válida.',
        'patient.state.max' => 'O estádo não deve ter mais de 2 caracteres.',
        'patient.zip_code.min' => 'Informe um CEP válido.',
        'patient.address.min' => 'Informe um endereço válido.',
    ];

    public function mount()
    {
        $this->dateFormat = now();
    }

    public function render()
    {

        $this->carbon = Carbon::now();

        $patients = Patient::with('address')
            ->when($this->q, function ($query) {
                return $query
                    ->whereRelation('address', 'address', 'like', '%' . $this->q . '%')
                    ->orWhere(function ($query) {
                        $query->where('name', 'like', '%' . $this->q . '%')
                            ->orWhere('email', 'like', '%' . $this->q . '%')
                            ->orWhere('phone', 'like', '%' . $this->q . '%');
                    });
            })
            ->orderBy($this->sortBy, $this->sortDesc ? 'DESC' : 'ASC')
            ->paginate(1);

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
        $this->resetValidation();
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
            'state' => $patient->address->state,
            'city' => $patient->address->city
        ];

        $this->action = 'editing';
        $this->resetValidation();
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
                'address' => $this->formatName($this->patient['address']),
                'number' => $this->patient['number'],
                'neighborhood' => $this->formatName($this->patient['neighborhood']),
                'zip_code' => $this->patient['zip_code'],
                'state' => $this->patient['state'],
                'city' => $this->formatName($this->patient['city'])
            ]
        );

        Patient::updateOrCreate(
            [
                'id' => $this->patient['id']
            ],
            [
                'address_id' => $address->id,
                'name' => $this->formatName($this->patient['name']),
                'email' => $this->formatEmail($this->patient['email']),
                'phone' => $this->patient['phone'],
                'birth' => $this->patient['birth']
            ]
        );

        DB::commit();

        $this->confirmingPatientAddition = false;
    }

    public function searchZipCode($zipCode)
    {
        if (!empty($zipCode)) {
            $zipCode = preg_replace('/[^0-9]/', '', $zipCode);

            $response = Http::get('https://viacep.com.br/ws/' . $zipCode . '/json/');

            if ($response && $response->status() == 200) {
                $response = $response->json();
                if (empty($response['erro'])) {
                    $this->patient['address'] = $response['logradouro'];
                    $this->patient['neighborhood'] = $response['bairro'];
                    $this->patient['state'] = $response['uf'];
                    $this->patient['city'] = $response['localidade'];
                }
            }
        }
    }

    private function formatPhoneNumber($phoneNumber)
    {
        // Remove non-numeric characters from the phone number
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Check if it's a mobile or landline number and apply the appropriate format
        if (strlen($phoneNumber) == 11) {
            // Format as (XX) 9XXXX-XXXX for mobile numbers
            return sprintf(
                '(%s) %s-%s',
                substr($phoneNumber, 0, 2),
                substr($phoneNumber, 2, 5),
                substr($phoneNumber, 7)
            );
        } elseif (strlen($phoneNumber) == 10) {
            // Format as (XX) XXXX-XXXX for landline numbers
            return sprintf(
                '(%s) %s-%s',
                substr($phoneNumber, 0, 2),
                substr($phoneNumber, 2, 4),
                substr($phoneNumber, 6)
            );
        }

        // Return the original number if it doesn't match expected lengths
        return $phoneNumber;
    }

    public function openTreatmentsModal($patient)
    {
        $this->openingTreatmentsModal = true;
        $this->getTreatments($patient);
    }

    public function getTreatments($patient)
    {
        $this->treatments = Treatment::with(['mentor', 'attachments', 'medicines', 'orientations', 'treatmentType'])
            ->where('treatments.patient_id', $patient)
            ->orderBy('date', 'DESC')
            ->get();

        $this->patientOfTheTreatment = Patient::where('id', $patient)->first();
    }
}
