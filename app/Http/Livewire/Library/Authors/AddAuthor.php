<?php

namespace App\Http\Livewire\Library\Authors;

use App\Models\Author;
use Livewire\Component;

class AddAuthor extends Component
{
    public string $name = '';
    public bool $is_spiritual_author = false;

    public bool $showAddModal = false;

    protected $rules = [
        'name' => 'required|string|min:3|max:255|unique:authors,name',
        'is_spiritual_author' => 'required|boolean',
    ];

    protected $messages = [
        'name.required' => 'Por favor, digite o nome do autor.',
        'name.min' => 'O nome do autor deve ter pelo menos 3 caracteres.',
        'name.max' => 'O nome do autor deve ter no máximo 255 caracteres.',
        'name.unique' => 'Já existe um autor com esse nome. Por favor, escolha outro.',
        'is_spiritual_author.required' => 'Por favor, selecione se o autor é um autor espiritual.',
        'is_spiritual_author.boolean' => 'Por favor, selecione se o autor é um autor espiritual.',
    ];

    public function render()
    {
        return view('livewire.library.authors.add-author');
    }

    public function showAddModal(): void
    {
        $this->reset(['name', 'is_spiritual_author']);
        $this->showAddModal = true;
    }

    public function saveAuthor(): void
    {
        $validated = $this->validate();

        Author::create($validated);

        $this->showAddModal = false;
        $this->emitUp('authorCreated');
    }
}
