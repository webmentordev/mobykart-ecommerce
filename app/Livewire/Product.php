<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Mail\Pending;
use App\Models\Order;
use Livewire\Component;
use Stripe\StripeClient;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Models\Product as SingleProduct;

use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

class Product extends Component
{
    public $product, $quantity = 1, $price = 0;
    public $email;

    public function mount(SingleProduct $product)
    {
        $this->product = $product;
        $this->price = $product->price;

        SEOMeta::setTitle($product->title);
        SEOMeta::setDescription($product->seo);
        SEOMeta::setCanonical(url('/')."/product/".$product->slug);
        SEOMeta::addMeta('apple-mobile-web-app-title', $product->title);
        SEOMeta::addMeta('application-name', 'MobyKart');
        SEOMeta::addMeta('article:published_time', $product->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:modified_time', $product->updated_at->toW3CString(), 'property');
        
        OpenGraph::setTitle($product->title);
        OpenGraph::setDescription($product->seo); 
        OpenGraph::addProperty('type', 'product');
        OpenGraph::addProperty('image:secure', 'https://');
        OpenGraph::addProperty('image:alt', $product->title. ' Image');
        OpenGraph::addProperty('locale', 'eu');
        OpenGraph::setUrl(url('/')."/product/".$product->slug);
        OpenGraph::addImage(url('/')."/storage/".$product->image);
        OpenGraph::setSiteName($product->title);

        TwitterCard::setTitle($product->title);
        TwitterCard::setSite('@mobykart');
        TwitterCard::setImage(url('/')."/storage/".$product->image);
        TwitterCard::setDescription($product->seo);
        
        JsonLd::setTitle($product->title);
        JsonLd::setDescription($product->seo);
        JsonLd::addImage(url('/')."/storage/".$product->large_thumb);
        JsonLd::setType('WebSite');
        JsonLd::addImage(url('/')."/storage/".$product->large_thumb);
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
        $price = 0;
        if($this->product->discount){
            $price = $this->price - ($this->price * ($this->product->discount->discount / 100));
        }else{
            $price = $this->price;
        }
        $completed = URL::temporarySignedRoute('completed', now()->addMinutes(360), ['order' => $orderID]);
        $canceled = URL::temporarySignedRoute('canceled', now()->addMinutes(360), ['order' => $orderID]);
        $checkout = $stripe->checkout->sessions->create([
            'success_url' => $completed,
            'cancel_url' => $canceled,
            'currency' => "USD",
            'billing_address_collection' => 'required',
            'expires_at' => Carbon::now()->addMinutes(360)->timestamp,
            'line_items' => [
                    [ 
                        'price_data' => [
                        "product" => $this->product->stripe_id,
                        "currency" => 'USD',
                        "unit_amount" =>  $price * 100,
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
            'price' => $price,
            'order_id' => $orderID,
            'url' => $checkout['url']
        ]);
        Mail::to($this->email)->send(new Pending($checkout['url']));
        return redirect($checkout['url']);
    }

    public function addToCart(){
        $cartItems = session()->get('cart');
        $price = 0;
        if($this->product->discount){
            $price = $this->product->price - ($this->product->price * ($this->product->discount->discount / 100));
        }else{
            $price = $this->product->price;
        }
        $cartItems[$this->product->slug] = [
            'quantity' => $this->quantity,
            'total' => $price * $this->quantity,
            'price' => number_format($price, 2),
            'product_id' => $this->product->stripe_id,
            'slug' => $this->product->slug,
            'name' => $this->product->title,
            'image' => config('app.url').'/storage/'.$this->product->image
        ];
        session()->put('cart', $cartItems);
        session()->flash('success', 'Added to the cart!');
        $this->dispatch('cart-function');
    }
}