<?php

namespace App\Http\Livewire\Library\Authors;

use App\Models\Author;
use Livewire\Component;

class DeleteAuthor extends Component
{
    public $authorId;
    public $showDeleteModal = false;

    public function render()
    {
        return view('livewire.library.authors.delete-author');
    }

    public function showDeleteModal()
    {
        $this->showDeleteModal = true;
    }

    public function deleteAuthor()
    {
        Author::destroy($this->authorId);
        $this->emitUp('authorDeleted');
        $this->showDeleteModal = false;
    }
}
