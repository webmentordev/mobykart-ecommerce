<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Mail\Pending;
use App\Models\Order;
use Livewire\Component;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Mail;
use App\Models\Product as SingleProduct;

class Product extends Component
{
    public $product, $quantity = 1, $price = 0;
    public $email;

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

    public function buyNow(){
        $this->validate([ 
            'email' => 'required|max:255|email'
        ]);
        $this->buyNow_click();
    }
    private function buyNow_click(){
        $stripe = new StripeClient(config('app.stripe'));
        $orderID = $this->orderIdGenerator();
        $checkout = $stripe->checkout->sessions->create([
            'success_url' => config('app.url').'/complete/'.$orderID,
            'cancel_url' => config('app.url').'/cancel/'.$orderID,
            'currency' => "USD",
            'billing_address_collection' => 'required',
            'expires_at' => Carbon::now()->addMinutes(360)->timestamp,
            'line_items' => [
                    [ 
                        'price_data' => [
                        "product" => $this->product->stripe_id,
                        "currency" => 'USD',
                        "unit_amount" =>  $this->price * 100,
                    ], 
                'quantity' => 1 
                ],
            ],
            'mode' => 'payment'
        ]);
        Order::create([
            'name' => $this->product->title,
            'email' => $this->email,
            'product_id' => $this->product->id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'order_id' => $orderID,
            'url' => $checkout['url']
        ]);
        Mail::to($this->email)->send(new Pending($checkout['url']));
        return redirect($checkout['url']);
    }

    public function addToCart(){
        $cartItems = session()->get('cart');
        $cartItems[$this->product->slug] = [
            'quantity' => $this->quantity,
            'price' => $this->price,
            'product_id' => $this->product->stripe_id,
            'slug' => $this->product->slug,
            'name' => $this->product->title,
            'image' => config('app.url').'/storage/'.$this->product->image
        ];
        session()->put('cart', $cartItems);
        session()->flash('success', 'Added to the cart!');
        $this->dispatch('added-to-cart'); 
    }
}