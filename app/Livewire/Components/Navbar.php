<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class Navbar extends Component
{
    public $cartCount = 0, $title = '';

    public function mount(){
        $this->cartCount = count(session()->get('cart', []));
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }

    public function search(){
        return $this->redirect('/products?search='.$this->title);
    }

    #[On('cart-function')] 
    public function cartRefresh(){
        $this->cartCount = count(session()->get('cart'));
    }
}