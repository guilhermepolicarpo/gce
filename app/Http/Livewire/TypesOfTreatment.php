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

    public $state = [
        'is_the_healing_touch' => false,
        'has_form' => false,
    ];

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true],
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'description',
        'is_the_healing_touch',
        'has_form',
    ];

    public function render()
    {
        $sortBy = in_array($this->sortBy, $this->allowedSorts, true) ? $this->sortBy : 'id';

        $typesOfTreatment = TypeOfTreatment::query()
            ->when($this->q, function ($query) {
                $query
                    ->where('name', 'like', "%{$this->q}%")
                    ->orWhere('description', 'like', "%{$this->q}%");
            })
            ->orderBy($sortBy, $this->sortDesc ? 'desc' : 'asc')
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
        $this->state = $this->defaultState();
        $this->actionAdd = true;
        $this->confirmingTypeOfTreatmentAddition = true;
    }

    public function saveTypeOfTreatment()
    {
        $validated = $this->validate();

        if (isset($this->state['id'])) {
            $typeOfTreatment = TypeOfTreatment::findOrFail($this->state['id']);
            $typeOfTreatment->update($validated['state']);
        } else {
            TypeOfTreatment::create($validated['state']);
        }
        $this->confirmingTypeOfTreatmentAddition = false;
    }

    public function confirmTypeOfTreatmentEditing(TypeOfTreatment $typeOfTreatment)
    {
        $this->state = array_merge($this->defaultState(), $typeOfTreatment->toArray());
        $this->actionAdd = false;
        $this->confirmingTypeOfTreatmentAddition = true;
    }

    protected function defaultState()
    {
        return [
            'is_the_healing_touch' => false,
            'has_form' => false,
        ];
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

    protected function rules()
    {
        return [
            'state.name' => 'required|string|max:255',
            'state.description' => 'nullable|string|max:255',
            'state.is_the_healing_touch' => 'required|boolean',
            'state.has_form' => 'required|boolean',
        ];
    }

    protected function messages()
    {
        return [
            'state.name.required' => 'Por favor, informe um nome para o tipo de tratamento',
            'state.name.string' => 'O nome do tipo de tratamento deve ser um texto válido',
            'state.name.max' => 'O nome do tipo de tratamento deve ter no máximo :max caracteres',
            'state.description.string' => 'A descrição do tipo de tratamento deve ser um texto válido',
            'state.description.max' => 'A descrição do tipo de tratamento deve ter no máximo :max caracteres',
            'state.is_the_healing_touch.required' => 'Por favor, informe se este atendimento é um tipo de passe',
            'state.is_the_healing_touch.boolean' => 'O campo tipo de passe deve ser verdadeiro ou falso',
            'state.has_form.required' => 'Por favor, informe se este atendimento habilita formulário',
            'state.has_form.boolean' => 'O campo habilitar formulário deve ser verdadeiro ou falso',
        ];
    }
}
