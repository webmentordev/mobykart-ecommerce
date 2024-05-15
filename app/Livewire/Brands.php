<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;

class Brands extends Component
{
    public $products;

    public function mount(Brand $brand){
        $this->products = $brand->active_products;
    }

    public function render()
    {
        return view('livewire.brands');
    }
}