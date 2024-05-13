<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class Navbar extends Component
{
    public $cartCount = 0;

    public function mount(){
        $this->cartCount = count(session()->get('cart', []));
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }

    #[On('added-to-cart')] 
    public function cartRefresh(){
        $this->cartCount = count(session()->get('cart'));
    }
}