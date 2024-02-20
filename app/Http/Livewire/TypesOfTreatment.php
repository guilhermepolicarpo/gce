<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TypeOfTreatment;

class TypesOfTreatment extends Component
{
    use WithPagination;

    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;
    public $actionAdd = false;
    public $confirmingTypeOfTreatmentDeletion = false;
    public $confirmingTypeOfTreatmentAddition = false;

    public $state = [];

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true],
    ];

    protected $messages = [
        'state.name.required' => 'Por favor, informe um nome para o tipo de tratamento',
        'state.name.max' => 'O nome do tipo de tratamento deve ter no máximo :max caracteres',
        'state.description.max' => 'A descrição do tipo de tratamento deve ter no máximo :max caracteres',
    ];

    public function render()
    {
        $typesOfTreatment = TypeOfTreatment::query()
            ->when($this->q, function ($query) {
                $query
                    ->where('name', 'like', "%{$this->q}%")
                    ->orWhere('description', 'like', "%{$this->q}%");
            })
            ->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
            ->paginate(10);

        return view('livewire.types-of-treatment', [
            'typesOfTreatment' => $typesOfTreatment,
        ]);
    }

    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortDesc = !$this->sortDesc;
        }
        $this->sortBy = $field;
    }

    public function confirmTypeOfTreatmentAddition()
    {
        $this->reset(['state']);
        $this->actionAdd = true;
        $this->confirmingTypeOfTreatmentAddition = true;
    }

    public function saveTypeOfTreatment()
    {
        $validated = $this->validate([
            'state.name' => 'required|string|max:255',
            'state.description' => 'nullable|string|max:255',
            'state.is_the_healing_touch' => 'required|boolean',
            'state.has_form' => 'required|boolean',
        ]);

        if (isset($this->state['id'])) {
            $typeOfTreatment = TypeOfTreatment::find($this->state['id']);
            $typeOfTreatment->update($validated['state']);
        } else {
            TypeOfTreatment::create($validated['state']);
        }
        $this->confirmingTypeOfTreatmentAddition = false;
    }

    public function confirmTypeOfTreatmentEditing(TypeOfTreatment $typeOfTreatment)
    {
        $this->state = $typeOfTreatment->toArray();
        $this->actionAdd = false;
        $this->confirmingTypeOfTreatmentAddition = true;
    }

    public function confirmTypeOfTreatmentDeletion($id)
    {
        $this->confirmingTypeOfTreatmentDeletion = $id;
    }

    public function deleteTypeOfTreatment(TypeOfTreatment $typeOfTreatment)
    {
        $typeOfTreatment->delete();
        $this->confirmingTypeOfTreatmentDeletion = false;
    }

    public function updatingQ()
    {
        $this->resetPage();
    }
}
