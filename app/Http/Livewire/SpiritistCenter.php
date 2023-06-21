<?php

namespace App\Http\Livewire;

use App\Models\Tenant;
use App\Models\Address;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\TenantInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SpiritistCenter extends Component
{
    use WithPagination;
    use WithFileUploads;
    
    public $logo;
    public $state;

    protected $rules = [
        'state.tenant.name' => 'required|string|min:4|max:255',
        'state.logo_path' => 'nullable|image|max:2048',
        'state.address.id' => 'nullable|exists:addresses,id',
        'state.address.address' => 'required|string|min:4|max:255',
        'state.address.number' => 'required|string',
        'state.address.neighborhood' => 'required|string|max:255',
        'state.address.zip_code' => 'required|string|max:255',
        'state.address.state' => 'required|string',
        'state.address.city' => 'required|string|max:255',
    ];

    protected $messages = [
        'state.tenant.name.required' => 'Por favor, informe o nome do Centro Espírita',
        'state.tenant.name.min' => 'O nome do Centro deve ter no mínimo 4 caracteres',
        'state.tenant.name.max' => 'O nome do Centro deve ter no máximo 255 caracteres',
        'state.address.address.required' => 'Por favor, informe o endereço',
        'state.address.number.required' => 'Por favor, informe o número',
        'state.address.neighborhood.required' => 'Por favor, informe o bairro',
        'state.address.zip_code.required' => 'Por favor, informe o CEP',
        'state.address.state.required' => 'Por favor, informe o estado',
        'state.address.city.required' => 'Por favor, informe a cidade',
    ];

    public function mount() 
    {
        $tenantInformation = TenantInformation::with('address', 'tenant')->first();
        $this->state = [
            'id' => isset($tenantInformation->id) ? $tenantInformation->id : null,
            'tenant' => [
                'name' => isset($tenantInformation->tenant->name) ? $tenantInformation->tenant->name : null,
            ],
            'logo_path' => isset($tenantInformation->logo_path) ? $tenantInformation->logo_path : null,
            'address' => [
                'id' => isset($tenantInformation->address->id) ? $tenantInformation->address->id : null,
                'address' => isset($tenantInformation->address->address) ? $tenantInformation->address->address : null,
                'number' => isset($tenantInformation->address->number) ? $tenantInformation->address->number : null,
                'neighborhood' => isset($tenantInformation->address->neighborhood) ? $tenantInformation->address->neighborhood : null,
                'zip_code' => isset($tenantInformation->address->zip_code) ? $tenantInformation->address->zip_code : null,
                'city' => isset($tenantInformation->address->city) ? $tenantInformation->address->city : null,
                'state' => isset($tenantInformation->address->state) ? $tenantInformation->address->state : null,
            ]
        ];
    }

    public function render()
    {
        return view('livewire.spiritist-center');
    }

    public function updateSpiritistCenterInformation()
    {
        $validated = $this->validate();

        DB::beginTransaction();

        if($validated['state']['address']['id']) {

            Address::where('id', $validated['state']['address']['id'])->update($validated['state']['address']);
            
        } else {
            $addressId = Address::create($validated['state']['address']);

            TenantInformation::where('id', $this->state['id'])->update([                
                'address_id' => $addressId->id,
            ]);
        };
        
        if($validated['state']['tenant']['name']) {
            Tenant::where('id', auth()->user()->tenant_id)->update(['name' => $validated['state']['tenant']['name']]);
        };

        if(isset($this->logo)) {
            TenantInformation::where('id', $this->state['id'])->update(['logo_path' => $this->logo->store('public/logos')]);
        };

        DB::commit();
    }  
    
    public function searchZipCode($zipCode)
    {
        $zipCode = preg_replace('/[^0-9]/', '', $zipCode);
        $response = null;
        
        if($zipCode){
            $response = Http::get('https://viacep.com.br/ws/'. $zipCode .'/json/');
        }

        
        if ($response) {
            $response = $response->json();
            if (empty($response['erro'])) {
                $this->state['address']['address'] = $response['logradouro'];
                $this->state['address']['neighborhood'] = $response['bairro'];
                $this->state['address']['state'] = $response['uf'];
                $this->state['address']['city'] = $response['localidade'];
            }
        }        
    }
}
