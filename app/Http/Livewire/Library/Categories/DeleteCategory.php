<?php

namespace App\Http\Livewire\Library\Categories;

use Livewire\Component;
use App\Models\Category;

class DeleteCategory extends Component
{
    public $categoryId;
    public $confirmingCategoryDeletion = false;

    public function render()
    {
        return view('livewire.library.categories.delete-category');
    }

    public function confirmCategoryDeletion()
    {
        $this->confirmingCategoryDeletion = true;
    }

    public function deleteCategory(): void
    {
        Category::destroy($this->categoryId);
        $this->emitUp('categoryDeleted');
        $this->confirmingCategoryDeletion = false;
    }
}
