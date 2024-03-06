<?php

namespace App\Http\Livewire\Mentors;

use App\Models\Mentor;
use Livewire\Component;
use Livewire\WithPagination;

class MentorsList extends Component
{
    use WithPagination;

    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;
    public $actionAdd;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true],
    ];

    protected $listeners = [
        'mentorAdded' => 'render',
        'mentorDeleted' => 'render',
        'mentorEddited' => 'render',
    ];

    public function render()
    {
        $mentors = Mentor::when($this->q, function ($query) {
            $query->where('name', 'like', "%{$this->q}%");
        })->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
            ->paginate(10);

        return view('livewire.mentors.mentors-list', [
            'mentors' => $mentors,
        ]);
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
