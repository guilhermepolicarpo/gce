<?php

namespace App\Http\Livewire;

use App\Models\Mentor;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Mentors extends Component
{
    use WithPagination;

    public $state = [
        'id' => '',
        'name' => '',
    ];
    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;
    public $actionAdd;
    public $confirmingMentorDeletion = false;
    public $confirmingMentorAddition = false;

    protected $rules = [
        'state.name' => 'required|string|min:4',
    ];

    protected $messages = [
        'state.name.required' => 'Por favor, informe o nome do mentor',
        'state.name.min' => 'O nome do mentor deve ter no mínimo 4 caracteres',
    ];

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true],
    ];

    public function render()
    {
        $mentors = DB::table('mentors')
        ->when($this->q, function ($query) {
            return $query->where('name', 'like', "%{$this->q}%");
        })
        ->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
        ->paginate(10);

        
        // $mentors = Mentor::when($this->q, function($query) {
        //     $query->where('name', 'like', "%{$this->q}%");
        // })->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
        //     ->paginate(10);
        
        return view('livewire.mentors', [
            'mentors' => $mentors,
        ]);
    }

    public function confirmMentorAddition()
    {
        $this->reset(['state']);
        $this->actionAdd = true;
        $this->confirmingMentorAddition = true;
    }

    public function saveMentor()
    {
        $this->validate();

        Mentor::updateOrCreate(
            ['id' => $this->state['id']],
            ['name' => $this->state['name']]
        );
        
        $this->reset(['state']);
        $this->confirmingMentorAddition = false;
    }

    public function confirmMentorEditing(Mentor $mentor)
    {
        $this->state = $mentor->toArray();
        $this->actionAdd = false;
        $this->confirmingMentorAddition = true;
    }

    public function confirmMentorDeletion($id)
    {
        $this->confirmingMentorDeletion = $id;
    }
    
    public function deleteMentor(Mentor $mentor)
    {
        $mentor->delete();

        $this->confirmingMentorDeletion = false;
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
