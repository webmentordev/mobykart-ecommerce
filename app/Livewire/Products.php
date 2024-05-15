<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Url;

class Products extends Component
{
    #[Url]
    public $search = '';

    public function render()
    {
        return view('livewire.products', [
            'products' => Product::where('is_active', true)
                ->where(function($query){
                    $query->orWhere('title', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('description', 'LIKE', '%'.$this->search.'%');
                })->latest()->get()
        ]);
    }
}