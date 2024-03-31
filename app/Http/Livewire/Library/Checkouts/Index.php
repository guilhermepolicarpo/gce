<?php

namespace App\Http\Livewire\Library\Checkouts;

use App\Models\Checkout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
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
        'checkoutUpdated' => 'render',
        'checkoutDeleted' => 'render',
        'checkoutCreated' => 'render',
    ];

    public function render()
    {
        $checkouts = Checkout::with(['patient', 'book'])
            ->when($this->q, function ($query) {
                $query->whereHas('patient', function ($query) {
                    $query->where('name', 'like', "%{$this->q}%");
                })->orWhereHas('book', function ($query) {
                    $query->where('title', 'like', "%{$this->q}%");
                });
            })
            ->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
            ->paginate(10);
            
        return view('livewire.library.checkouts.index', [
            'checkouts' => $checkouts,
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
