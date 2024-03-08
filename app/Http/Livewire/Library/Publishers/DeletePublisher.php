<?php

namespace App\Http\Livewire\Library\Publishers;

use Livewire\Component;
use App\Models\Publisher;

class DeletePublisher extends Component
{
    public $publisherId;
    public $showDeleteModal = false;

    public function render()
    {
        return view('livewire.library.publishers.delete-publisher');
    }

    public function showDeleteModal()
    {
        $this->showDeleteModal = true;
    }

    public function deletePublisher()
    {
        Publisher::destroy($this->publisherId);
        $this->emitUp('publisherDeleted');
        $this->showDeleteModal = false;
    }
}
