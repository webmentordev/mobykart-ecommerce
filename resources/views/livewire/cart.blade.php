<section class="w-full min-h-[50vh] h-full border-b border-gray-200">
    <div class="max-w-4xl m-auto py-12 px-4 h-full flex items-center justify-center">
        <div wire:target='increment, decrement, confirmOrder' wire:loading>
            <x-alerts.processing message="Processing..." />
        </div>
        <div class="w-full">
            @if ($cartItems)
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-bold text-2xl">Order Summary</h2>
                    <button wire:click="emptyCart" class="p-2 rounded-full bg-red-600/10 group relative">
                        <img src="https://api.iconify.design/ci:trash-full.svg?color=%23d40808" width="20" alt="Empty cart icon">
                        <span class="hidden absolute p-2 top-10 right-0 bg-black/80 rounded-md group-hover:block text-white w-[120px] text-sm">Empty cart</span>
                    </button>
                </div>
                <div class="border border-gray-200 p-6 rounded-xl">
                    <div class="border-b border-gray-200 pb-2">
                        @foreach ($cartItems as $cart)
                            <div class="flex items-center justify-between mb-6 relative">
                                <button wire:click="removeItem('{{ $cart['slug'] }}')" class="ml-2 p-2 rounded-full bg-red-600/10 absolute -top-3 -left-4">
                                    <img src="https://api.iconify.design/noto:cross-mark.svg?color=%23d40808" width="10" alt="Cross icon">
                                </button>
                                <div class="flex items-center">
                                    <div class="p-2 rounded-lg border border-gray-200">
                                        <img src="{{ asset($cart['image']) }}" alt="{{ $cart['name'] }}" width="60">
                                    </div>
                                    <div class="ml-3">
                                        <a href="{{ route('product', $cart['slug']) }}" class="font-bold text-lg underline hover:text-red-600">{{ $cart['name'] }}</a>
                                        <p class="text-sm text-gray-500"><strong>Quantity:</strong> <span class="text-red-600 font-semibold">x{{ $cart['quantity'] }}</span></p>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-semibold m-auto">${{ number_format($cart['total'], 2) }}</h4>
                                    <div class="flex justify-between items-center border border-gray-200 rounded-lg">
                                        <button class="px-2 py-1 border-r border-gray-200" wire:click="decrement('{{ $cart['slug'] }}')">-</button>
                                        <span class="px-3">{{ $cart['quantity'] }}</span>
                                        <button class="px-2 py-1 border-l border-gray-200" wire:click="increment('{{ $cart['slug'] }}')">+</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex flex-col py-4 border-b border-gray-200 mb-5"> 
                        <div class="flex justify-between mb-5">
                            <strong class="text-gray-500">Subtotal</strong>
                            <span>${{ number_format($totalPrice, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <strong class="text-gray-500">Shipping fee</strong>
                            <span>$0.00</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center border-b border-gray-200 mb-5 pb-6">
                        <strong>Total</strong>
                        <span class="text-3xl font-semibold"><span class="text-red-600 text-lg">US</span>${{ number_format($totalPrice, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center" x-data="{ open : false }">
                        <button x-on:click="open = true" class="py-3 bg-black text-white font-semibold rounded-xl px-4 w-full">Confirm Order</button>
                        <div class="fixed z-20 top-0 left-0 w-full h-full bg-black/90 backdrop-blur-md" x-show="open" x-cloak x-transition>
                            <div class="w-full h-full flex items-center justify-center" x-on:click.self="open = false">
                                <div class="max-w-lg w-full bg-white p-6 rounded-xl">
                                    <form wire:submit='confirmOrder' method="POST">
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
                </div>
            @else
                <p class="text-center text-3xl font-bold">Your cart is empty! 🛒</p>
            @endif
        </div>
    </div>
</section>
