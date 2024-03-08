<?php

namespace App\Http\Livewire\Library\Categories;

use App\Models\Category;
use Livewire\Component;

class EditCategory extends Component
{
    public int $categoryId;
    public string $name = '';
    public $showEditModal = false;

    protected $rules = [
        'name' => 'required|min:3|max:255|unique:categories,name',
    ];

    protected $messages = [
        'name.required' => 'Por favor, informe um nome para a categoria.',
        'name.min' => 'O nome da categoria deve ter pelo menos 3 caracteres.',
        'name.max' => 'O nome da categoria deve ter no máximo 255 caracteres.',
        'name.unique' => 'Já existe uma categoria com este nome. Por favor, escolha outro.',
    ];

    public function render()
    {
        return view('livewire.library.categories.edit-category');
    }

    public function showEditModal(Category $category): void
    {
        $this->name = $category->name;
        $this->showEditModal = true;
    }

    public function editCategory(): void
    {
        $validated = $this->validate();

        Category::where('id', $this->categoryId)->update($validated);

        $this->reset('name');
        $this->emitUp('categoryEddited');
        $this->showEditModal = false;
    }
}
