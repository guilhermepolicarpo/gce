<?php

namespace App\Http\Livewire;

use App\Models\Tenant;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class SpiritistCenter extends Component
{
    use WithPagination;
    
    public $state = [
        'id' => '',
        'name' => '',
    ];

    protected $rules = [
        'state.name' => 'required|string|min:4',
    ];

    protected $messages = [
        'state.name.required' => 'Por favor, informe o nome do Centro Espírita',
        'state.name.min' => 'O nome do Centro deve ter no mínimo 4 caracteres',
    ];

    public function mount() 
    {
        $this->state = Tenant::find(auth()->user()->tenant_id);
    }

    public function render()
    {        
        return view('livewire.spiritist-center');
    }

    public function updateSpiritistCenterInformation()
    {
        $this->validate();

        $this->state->update();

        //$this->emit('updateSpiritistCenterInformation');
    }
}
