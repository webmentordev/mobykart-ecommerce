<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Mail\Pending;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Stripe\StripeClient;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class Cart extends Component
{
    public $cartItems, $totalPrice = 0;
    public $email;

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

    function orderIdGenerator() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 30; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function confirmOrder(){
        $this->validate([ 
            'email' => 'required|max:255|email'
        ]);
        $this->payNow_click();
    }
    private function payNow_click(){
        $stripe = new StripeClient(config('app.stripe'));
        $orderID = $this->orderIdGenerator();
        $checkoutArray = [];
        if(count($this->cartItems) == 0){ abort(500); }
        
        foreach($this->cartItems as $cart){
            $product = Product::where('slug', $cart['slug'])->first();
            $price = 0;
            if($product->discount){
                $price = ($product->price - ($product->price * ($product->discount->discount / 100)));
            }else{
                $price = $product->price;
            }
            Order::create([
                'name' => $cart['name'],
                'email' => $this->email,
                'product_id' => $product->id,
                'quantity' => $cart['quantity'],
                'price' => $price,
                'order_id' => $orderID
            ]);
            array_push($checkoutArray, [ 'price_data' => [
                "product" => $product->stripe_id,
                "currency" => 'USD',
                "unit_amount" =>  $price * 100,
            ], 'quantity' => $cart['quantity']]);
        }

        $completed = URL::temporarySignedRoute('completed', now()->addMinutes(360), ['order' => $orderID]);
        $canceled = URL::temporarySignedRoute('canceled', now()->addMinutes(360), ['order' => $orderID]);

        $checkout = $stripe->checkout->sessions->create([
            'success_url' => $completed,
            'cancel_url' => $canceled,
            'currency' => "USD",
            'billing_address_collection' => 'required',
            'expires_at' => Carbon::now()->addMinutes(360)->timestamp,
            'line_items' => $checkoutArray,
            'mode' => 'payment'
        ]);
        Order::where('order_id', $orderID)->update([
            'url' => $checkout['url']
        ]);
        Mail::to($this->email)->send(new Pending($checkout['url']));
        $this->emptyCart();
        return redirect($checkout['url']);
    }
}