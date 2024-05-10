<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.home', [
            'categories' => Category::latest()->where('is_active', true)->withCount('products')->get(),
            'brands' => Brand::latest()->where('is_active', true)->withCount('products')->get(),
            'products' => Product::latest()->where('is_active', true)->get(),
        ]);
    }
}