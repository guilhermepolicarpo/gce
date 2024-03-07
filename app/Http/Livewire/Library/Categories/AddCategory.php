<?php

namespace App\Http\Livewire\Library\Categories;

use Livewire\Component;
use App\Models\Category;

class AddCategory extends Component
{
    public string $name = '';
    public bool $showModal = false;

    protected $rules = [
        'name' => 'required|string|min:3|max:255|unique:categories',
    ];

    protected $messages = [
        'name.required' => 'Por favar, digite o nome da categoria.',
        'name.string' => 'Por favar, digite um texto válido.',
        'name.min' => 'Por favar, digite pelo menos 3 caracteres.',
        'name.max' => 'Por favar, digite no maximo 255 caracteres.',
        'name.unique' => 'Ja existe uma categoria com esse nome.',
    ];

    public function render()
    {
        return view('livewire.library.categories.add-category');
    }

    public function showAddModal(): void
    {
        $this->reset(['name']);
        $this->showModal = true;
    }

    public function saveCategory(): void
    {
        $this->validate();

        Category::create(['name' => $this->name]);

        $this->showModal = false;
        $this->emitUp('categoryAdded');
    }
}
