<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Medicine;
use Livewire\WithPagination;

class Medicines extends Component
{
    use WithPagination;

    public $state = [
        'id' => '',
        'name' => null,
        'description' => null
    ];
    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;
    public $actionAdd;
    public $confirmingMedicineDeletion = false;
    public $confirmingMedicineAddition = false;

    protected $rules = [
        'state.name' => 'required|string|min:2',
        'state.description' => 'nullable|string|min:2',
    ];

    protected $messages = [
        'state.name.required' => 'Por favor, informe o nome do medicamento',
        'state.name.min' => 'O nome do medicamento deve ter no mínimo 2 caracteres',
        'state.description.min' => 'A descrição deve ter no mínimo 2 caracteres',
    ];

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true],
    ];
    
    public function render()
    {
        $medicines = Medicine::when($this->q, function($query) {
            $query->where('name', 'like', "%{$this->q}%");
        })->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
            ->paginate(10);

        return view('livewire.medicines', [
            'medicines' => $medicines,
        ]);
    }
    
    public function confirmMedicineAddition()
    {
        $this->reset(['state']);
        $this->actionAdd = true;
        $this->confirmingMedicineAddition = true;
    }

    public function saveMedicine()
    {
        $this->validate();

        Medicine::updateOrCreate(
            [
                'id' => $this->state['id']
            ],
            [
                'name' => $this->state['name'],
                'description' => $this->state['description'],
            ]
        );
        
        $this->reset(['state']);
        $this->confirmingMedicineAddition = false;
    }

    public function confirmMedicineEditing(Medicine $medicine)
    {
        $this->state = $medicine->toArray();
        $this->actionAdd = false;
        $this->confirmingMedicineAddition = true;
    }

    public function confirmMedicineDeletion($id)
    {
        $this->confirmingMedicineDeletion = $id;
    }
    
    public function deleteMedicine(Medicine $medicine)
    {
        $medicine->delete();

        $this->confirmingMedicineDeletion = false;
    }

    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortDesc = !$this->sortDesc;
        }
        $this->sortBy = $field;
    }

    public function updatingQ()
    {
        $this->resetPage();
    }
}
