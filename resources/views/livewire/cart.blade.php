<section class="w-full min-h-[50vh] h-full border-b border-gray-200">
    <div class="max-w-4xl m-auto py-12 px-4 h-full flex items-center justify-center">
        <div wire:target='increment, decrement' wire:loading>
            <x-alerts.processing message="Processing..." />
        </div>
        <div class="w-full">
            @if ($cartItems)
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-bold text-2xl">Order Summary</h2>
                    <button wire:click="emptyCart" class="p-2 rounded-full bg-red-600/10">
                        <img src="https://api.iconify.design/ci:trash-full.svg?color=%23d40808" width="20" alt="Empty cart icon">
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

                    <div class="flex justify-between items-center">
                        <form wire:click='checkoutNow' method="post" class="w-full">


                            <button type="submit" class="py-3 bg-black text-white font-semibold rounded-xl px-4 w-full">Confirm order & Pay</button>
                        </form>
                    </div>
                </div>
            @else
                <p class="text-center text-3xl font-bold">Your cart is empty! 🛒</p>
            @endif
        </div>
    </div>
</section>
