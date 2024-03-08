<?php

namespace App\Http\Livewire\Library\Publishers;

use Livewire\Component;
use App\Models\Publisher;

class AddPublisher extends Component
{
    public string $name = '';

    public bool $showAddModal = false;

    protected $rules = [
        'name' => 'required|string|min:3|max:255|unique:publishers,name',
    ];

    protected $messages = [
        'name.required' => 'Por favor, digite o nome da editora.',
        'name.min' => 'O nome da editora deve ter pelo menos 3 caracteres.',
        'name.max' => 'O nome da editora deve ter no máximo 255 caracteres.',
        'name.unique' => 'Já existe uma editora com esse nome.',
    ];

    public function render()
    {
        return view('livewire.library.publishers.add-publisher');
    }

    public function showAddModal(): void
    {
        $this->reset(['name']);
        $this->showAddModal = true;
    }

    public function savePublisher(): void
    {
        $validated = $this->validate();

        Publisher::create($validated);

        $this->showAddModal = false;
        $this->emitUp('publisherCreated');
    }
}
