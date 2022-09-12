<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Orientation;
use Livewire\WithPagination;

class Orientations extends Component
{
    use WithPagination;

    public $state = ['id' => ''];
    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;
    public $actionAdd;
    public $confirmingOrientationDeletion = false;
    public $confirmingOrientationAddition = false;

    protected $rules = [
        'state.name' => 'required|string|min:2',
        'state.description' => 'nullable|string|min:2',
    ];

    protected $messages = [
        'state.name.required' => 'Por favor, informe o nome da orientação',
        'state.name.min' => 'O nome da orientação deve ter no mínimo 2 caracteres',
        'state.description.min' => 'A descrição deve ter no mínimo 2 caracteres',
    ];

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true],
    ];

    public function render()
    {
        $orientations = Orientation::when($this->q, function($query) {
            $query->where('name', 'like', "%{$this->q}%");
        })->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
            ->paginate();

        return view('livewire.orientations', [
            'orientations' => $orientations,
        ]);
    }

    public function confirmOrientationAddition()
    {
        $this->reset(['state']);
        $this->actionAdd = true;
        $this->confirmingOrientationAddition = true;
    }

    public function saveOrientation()
    {
        $this->validate();

        Orientation::updateOrCreate(
            [
                'id' => $this->state['id']
            ],
            [
                'name' => $this->state['name'],
                'description' => $this->state['description'],
            ]
        );
        
        $this->reset(['state']);
        $this->confirmingOrientationAddition = false;
    }

    public function confirmOrientationEditing(Orientation $orientation)
    {
        $this->state = $orientation->toArray();
        $this->actionAdd = false;
        $this->confirmingOrientationAddition = true;
    }

    public function confirmOrientationDeletion($id)
    {
        $this->confirmingOrientationDeletion = $id;
    }
    
    public function deleteOrientation(Orientation $orientation)
    {
        $orientation->delete();

        $this->confirmingOrientationDeletion = false;
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
