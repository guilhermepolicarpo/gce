<?php

namespace App\Http\Livewire\Library\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class CategoriesList extends Component
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
        'categoryAdded' => 'render',
        'categoryDeleted' => 'render',
        'categoryEddited' => 'render',
    ];

    public function render()
    {
        $categories = Category::when($this->q, function ($query) {
            $query->where('name', 'like', "%{$this->q}%");
        })->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
            ->paginate(10);

        return view('livewire.library.categories.categories-list', [
            'categories' => $categories,
        ]);
    }

    /**
     * Sorts the collection by the given field.
     *
     * @param $field The field to sort by
     */
    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortDesc = !$this->sortDesc;
        }
        $this->sortBy = $field;
    }

    /**
     * Reset pagination.
     *
     */
    public function updatingQ()
    {
        $this->resetPage();
    }
}
