<?php

namespace App\Http\Livewire\Library\Books;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;

class BookList extends Component
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
        'bookUpdated' => 'render',
        'bookDeleted' => 'render',
        'bookCreated' => 'render',
    ];

    public function render()
    {
        $books = Book::with(['authors' => function($query) {
            $query->orderBy('is_spiritual_author', 'desc');

        }, 'publisher', 'category'])
            ->when($this->q, function ($query) {
                $query->where('title', 'like', "%{$this->q}%");

            })->orderBy($this->sortBy, $this->sortDesc ? 'desc' : 'asc')
            ->paginate(10);

        return view('livewire.library.books.book-list', [
            'books' => $books,
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
