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
    public $state = [];
    public $information = [
        'address' => [
            'address' => '',
            'number' => '',
            'neighborhood' => '',
            'zip_code' => '',
            'state' => '',
            'city' => ''
        ],
        'logo_path' => null,
    ];

    protected $rules = [
        'state.name' => 'required|string|min:4|max:255',
        'logo' => 'nullable|image',
        'information.address.id' => 'nullable|exists:addresses,id',
        'information.address.address' => 'required|string|min:4|max:255',
        'information.address.number' => 'required|string',
        'information.address.neighborhood' => 'required|string|max:255',
        'information.address.zip_code' => 'required|string|max:255',
        'information.address.state' => 'required|string',
        'information.address.city' => 'required|string|max:255',
    ];

    protected $messages = [
        'state.name.required' => 'Por favor, informe o nome do Centro Espírita',
        'state.name.min' => 'O nome do Centro deve ter no mínimo 4 caracteres',
        'state.name.max' => 'O nome do Centro deve ter no máximo 255 caracteres',
    ];

    public function mount() 
    {
        $this->state = Tenant::find(auth()->user()->tenant_id);
        $information = TenantInformation::with('address')->first();

        if($information) {
            $this->information = $information;
        }
    }

    public function render()
    {
        return view('livewire.spiritist-center');
    }



    public function updateSpiritistCenterInformation()
    {
        $this->validate([
            'state.name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        
        $this->information['logo_path'] = $this->logo->store('public/logos');
        $this->state->update();
    }

    public function updateSpiritistCenterAddress()
    {
        $this->validate([
            'information.address.address' => 'required|string|min:4|max:255',
            'information.address.number' => 'required|string',
            'information.address.neighborhood' => 'required|string|max:255',
            'information.address.zip_code' => 'required|string|max:255',
            'information.address.state' => 'required|string',
            'information.address.city' => 'required|string|max:255',
        ]);

        if(isset($this->information->address->id)) {
            Address::where('id', $this->information->address->id)->update([
                'address' => $this->information->address->address,
                'number' => $this->information->address->number,
                'neighborhood' => $this->information->address->neighborhood,
                'zip_code' => $this->information->address->zip_code,
                'state' => $this->information->address->state,
                'city' => $this->information->address->city,
            ]);

        } else {
            DB::beginTransaction();

            $addressId = Address::create($this->information['address']);
            TenantInformation::create([
                'tenant_id' => auth()->user()->tenant_id,
                'address_id' => $addressId->id,
            ]);

            DB::commit();
        };
    }

    public function searchZipCode($zipCode)
    {
        $zipCode = preg_replace('/[^0-9]/', '', $zipCode);

        $response = Http::get('https://viacep.com.br/ws/'. $zipCode .'/json/');
        
        if ($response) {
            $response = $response->json();
            if (empty($response['erro'])) {
                $this->information['address']['address'] = $response['logradouro'];
                $this->information['address']['neighborhood'] = $response['bairro'];
                $this->information['address']['state'] = $response['uf'];
                $this->information['address']['city'] = $response['localidade'];
            }
        }        
    }
}
