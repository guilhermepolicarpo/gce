<?php

namespace App\Http\Livewire\Library\Authors;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Author;

class AuthorList extends Component
{
    use WithPagination;

    public $q;
    public $sortBy = 'id';
    public $sortDesc = true;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true],
    ];

    protected $listeners = [
        'authorUpdated' => 'render',
        'authorDeleted' => 'render',
        'authorCreated' => 'render',
    ];

    public function render()
    {
        $authors = Author::select('id', 'name', 'is_spiritual_author')->when($this->q, function ($query) {
            $query->where('name', 'like', "%{$this->q}%");
        })->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
        ->paginate(10);

        return view('livewire.library.authors.author-list', [
            'authors' => $authors,
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
