<?php

namespace App\Http\Livewire\Library\Authors;

use App\Models\Author;
use Livewire\Component;

class EditAuthor extends Component
{
    public int $authorId;
    public string $name = '';
    public $is_spiritual_author = false;

    public bool $showEditModal = false;

    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'is_spiritual_author' => 'nullable',
    ];

    protected $messages = [
        'name.required' => 'Por favor, digite o nome do autor.',
        'name.min' => 'O nome do autor deve ter pelo menos 3 caracteres.',
        'name.max' => 'O nome do autor deve ter no máximo 255 caracteres.',
        'name.unique' => 'Já existe um autor com esse nome. Por favor, escolha outro.',
    ];

    public function render()
    {
        return view('livewire.library.authors.edit-author');
    }

    public function showEditModal(Author $author): void
    {
        $this->name = $author->name;
        $this->is_spiritual_author = $author->is_spiritual_author;
        $this->showEditModal = true;
    }

    public function saveAuthor(): void
    {
        $validated = $this->validate();

        Author::where('id', $this->authorId)->update($validated);

        $this->reset('name', 'is_spiritual_author');
        $this->emitUp('authorUpdated');
        $this->showEditModal = false;
    }
}
