<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class Categories extends Component
{
    public $products;

    public function mount(Category $category){
        $this->products = $category->active_products;
    }

    public function render()
    {
        return view('livewire.categories');
    }
}
