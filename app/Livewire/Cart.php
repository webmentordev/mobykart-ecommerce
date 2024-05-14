<?php

namespace App\Livewire;

use Livewire\Component;

class Cart extends Component
{
    public $cartItems, $totalPrice = 0;

    public function mount(){
        $this->priceCheck();
    }

    public function render()
    {
        return view('livewire.cart');
    }

    public function emptyCart(){
        session(['cart' => []]);
        $this->totalPrice = 0;
        $this->priceCheck();
        $this->cartItems = null;
        $this->dispatch('cart-function');
    }
    
    public function removeItem($slug){
        if (array_key_exists($slug, $this->cartItems)) {
            unset($this->cartItems[$slug]);
            session(['cart' => $this->cartItems]);
            session()->flash('success', 'Product has been removed!');
            $this->priceCheck();
            $this->dispatch('cart-function');
        }
    }

    public function priceCheck(){
        $this->totalPrice = 0;
        $this->cartItems = session()->get('cart');
        if($this->cartItems != null){
            foreach($this->cartItems as $cart){
                $this->totalPrice+= $cart['total'];
            }
        }
    }

    public function increment($slug){
        $quantity = $this->cartItems[$slug]['quantity'];
        $newQuantity = $quantity + 1;
        $this->cartItems[$slug]['quantity'] = $newQuantity;
        $this->cartItems[$slug]['total'] = $this->cartItems[$slug]['price'] * $newQuantity;
        session()->put('cart', $this->cartItems);
        $this->priceCheck();
    }

    public function decrement($slug){
        $quantity = $this->cartItems[$slug]['quantity'];
        $newQuantity = $quantity - 1;
        if($newQuantity != 0){
            $this->cartItems[$slug]['quantity'] = $newQuantity;
            $this->cartItems[$slug]['total'] = $this->cartItems[$slug]['price'] * $newQuantity;
            session()->put('cart', $this->cartItems);
            $this->priceCheck();
        }
    }
}