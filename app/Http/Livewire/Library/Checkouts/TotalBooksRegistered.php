<?php

namespace App\Http\Livewire\Library\Checkouts;

use App\Models\Book;
use Livewire\Component;

class TotalBooksRegistered extends Component
{
    public function render()
    {
        $totalBooks = Book::get('id')->count();

        return view('livewire.library.checkouts.total-books-registered',[
            'totalBooks' => $totalBooks
        ]);
    }
}
