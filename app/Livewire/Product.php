<?php

namespace App\Livewire;

use App\Models\Product as SingleProduct;
use Livewire\Component;

class Product extends Component
{
    public $product, $quantity = 1, $price = 0;

    public function mount(SingleProduct $product)
    {
        $this->product = $product;
        $this->price = $product->price;
    }

    public function render()
    {
        return view('livewire.product');
    }

    public function decrement(){
        if($this->quantity > 1){
            $this->quantity = $this->quantity - 1;
            $this->price = $this->product->price * $this->quantity;
        }
    }

    public function increment(){
        $this->quantity = $this->quantity + 1;
        $this->price = $this->product->price * $this->quantity;
    }
}