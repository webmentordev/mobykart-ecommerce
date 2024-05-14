<section class="w-full">
    <div class="max-w-7xl m-auto w-full py-6 px-4">
        <div wire:target='buyNow, addToCart, increment, decrement' wire:loading>
            <x-alerts.processing message="Processing..." />
        </div>
        @session('success')
            <x-alerts.success :message="$value" />
        @endsession

        <div class="grid grid-cols-2 gap-12 mb-6">
            <div class="w-full">
                <img src="{{ asset('storage/'. $product->image) }}" alt="{{ $product->title }}" title="{{ $product->title }}" class="border border-gray-200 rounded-xl">
            </div>
            <div class="w-full">
                <h1 class="mb-1 font-medium text-3xl">{{ $product->title }}</h1>
                <p class="text-gray-500 text-sm">Brand: <span class="text-red-600">{{ $product->brand->title }}</span></p>
                @if ($product->discount)
                    <div class="flex items-center mt-6 border-b border-gray-200 pb-4 mb-3">
                        <del class="text-gray-500 font-medium text-lg mr-1">${{ $price }}</del>
                        <span class="text-red-600 font-medium text-2xl">${{ number_format($price - ($price * ($product->discount->discount / 100)), 2) }}</span>
                        <span class="bg-red-600 text-white font-medium text-lg px-2 rounded-md ml-3">-%{{ $product->discount->discount }}</span>
                    </div>
                @else
                    <div class="border-b border-gray-200 mt-6 w-full pb-4 mb-3">
                        <span class="font-bold text-2xl">${{ number_format($price, 2) }}</span>
                    </div>
                @endif
                <div class="description border-b border-gray-200 mt-6 w-full pb-4 mb-6">
                    {!! $product->description !!}
                </div>
                <div class="grid grid-cols-3 gap-6 border-b border-gray-200 mt-6 w-full pb-6 mb-3" x-data="{ open : false }">
                    <div class="flex items-center border p-1 border-gray-200 w-fit rounded-full">
                        <button wire:click='decrement' class="bg-black text-white py-1 px-3 rounded-full font-semibold">-</button>
                        <span class="mx-4">{{ $quantity }}</span>
                        <button wire:click='increment' class="bg-black text-white py-1 px-3 rounded-full font-semibold">+</button>
                    </div>
                    <button wire:click='addToCart' class="bg-black text-white py-2 px-4 rounded-full font-semibold">Add to Cart</button>
                    <button x-on:click="open = true" class="bg-red-600 text-white py-2 px-4 rounded-full font-semibold">Buy Now</button>
                    <div class="fixed z-20 top-0 left-0 w-full h-full bg-black/90 backdrop-blur-md" x-show="open" x-cloak x-transition>
                        <div class="w-full h-full flex items-center justify-center" x-on:click.self="open = false">
                            <div class="max-w-lg w-full bg-white p-6 rounded-xl">
                                <form wire:submit='buyNow' method="POST">
                                    <h3 class="mb-3 font-bold text-2xl">Click Buy Now & Pay</h3>
                                    <p class="text-sm mb-2 text-gray-500">We'll send you the tracking ID and order information to the email provided. For your privacy and security, we'll collect the shipping address and contact number on the Stripe checkout page.</p>
                                    <x-input type="email" wire:model='email' name="email" placeholder="Email address" class="bg-gray-200 py-2 px-3 rounded-lg mb-2" />
                                    <x-input-error :messages="$errors->get('email')" class="mb-2" />
                                    <x-primary-button>Pay Now</x-primary-button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @if (count($product->tags))
                    <div class="text-gray-500 flex items-center text-sm py-2">
                        <p>Tags:</p>
                        <ul class="flex items-center flex-wrap">
                            @foreach ($product->tags as $tag)
                                @if (!$loop->last)
                                    <a href="/search/tag/product/{{ $tag->tag->slug }}" class="capitalize ml-2"><span class="text-red-600">{{ $tag->tag->name }}</span>,</a>
                                @else
                                    <a href="/search/tag/product/{{ $tag->tag->slug }}" class="capitalize ml-2"><span class="text-red-600">{{ $tag->tag->name }}</span></a>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <article class="article">
            {!! $product->body !!}
        </article>
    </div>
</section>