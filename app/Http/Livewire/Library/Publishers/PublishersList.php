<?php

namespace App\Http\Livewire\Library\Publishers;

use Livewire\Component;
use App\Models\Publisher;
use Livewire\WithPagination;

class PublishersList extends Component
{
    use WithPagination;

    public string $q = '';
    public string $sortBy = 'id';
    public bool $sortDesc = true;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDesc' => ['except' => true],
    ];

    protected $listeners = [
        'publisherUpdated' => 'render',
        'publisherDeleted' => 'render',
        'publisherCreated' => 'render',
    ];
    public function render()
    {
        $publishers = Publisher::select('name', 'id')->when($this->q, function ($query) {
            $query->where('name', 'like', "%{$this->q}%");
        })->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
        ->paginate(10);

        return view('livewire.library.publishers.publishers-list', [
            'publishers' => $publishers,
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
