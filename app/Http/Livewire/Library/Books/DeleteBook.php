<?php

namespace App\Http\Livewire\Library\Books;

use App\Models\Book;
use Livewire\Component;

class DeleteBook extends Component
{
    public $bookId;
    public $showDeleteModal = false;

    public function render()
    {
        return view('livewire.library.books.delete-book');
    }

    public function showDeleteModal()
    {
        $this->showDeleteModal = true;
    }

    public function deleteBook()
    {
        $book = Book::find($this->bookId);
        $book->authors()->detach();
        $book->delete();

        $this->emitUp('bookDeleted');
        $this->showDeleteModal = false;
    }
}
