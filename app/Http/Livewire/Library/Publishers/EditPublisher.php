<?php

namespace App\Http\Livewire\Library\Publishers;

use Livewire\Component;
use App\Models\Publisher;

class EditPublisher extends Component
{
    public int $publisherId;
    public string $name;
    public bool $showEditModal = false;

    protected $rules = [
        'name' => 'required|string|min:3|max:255',
    ];

    protected array $messages = [
        'name.required' => 'Por favor, digite o nome da editora.',
        'name.min' => 'O nome da editora deve ter pelo menos 3 caracteres.',
        'name.max' => 'O nome da editora deve ter no máximo 255 caracteres.',
    ];

    public function render()
    {
        return view('livewire.library.publishers.edit-publisher');
    }

    public function showEditModal(): void
    {
        $this->name = Publisher::select('name')->where('id', $this->publisherId)->first()->name;
        $this->showEditModal = true;
    }

    public function savePublisher(): void
    {
        $validated = $this->validate();
        Publisher::where('id', $this->publisherId)->update($validated);
        $this->emitUp('publisherUpdated');
        $this->showEditModal = false;
    }
}
