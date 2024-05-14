<?php

namespace App\Livewire;

use Livewire\Component;

class Cart extends Component
{
    public $cartItems, $totalPrice = 0;

    public function mount(){
        $this->cartItems = session()->get('cart');
        if($this->cartItems != null){
            foreach($this->cartItems as $cart){
                $this->totalPrice+= $cart['total'];
            }
        }
    }

    public function render()
    {
        return view('livewire.cart');
    }

    public function emptyCart(){
        session(['cart' => []]);
        $this->totalPrice = 0;
        $this->dispatch('cart-function');
    }
    
    public function removeItem($slug){
        if (array_key_exists($slug, $this->cartItems)) {
            unset($this->cartItems[$slug]);
            session(['cart' => $this->cartItems]);
            session()->flash('success', 'Product has been removed!');
            $this->dispatch('cart-function');
        }
    }
}