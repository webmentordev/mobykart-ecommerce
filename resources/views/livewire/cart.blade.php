<section class="w-full min-h-[50vh] h-full border-b border-gray-200">
    <div class="max-w-4xl m-auto py-6 px-4 h-full flex items-center justify-center">
        <div class="w-full">
            @if ($cartItems)
                <h2 class="mb-3 font-bold text-2xl">Order Summary</h2>
                <div class="border border-gray-200 p-6 rounded-xl">
                    <div class="border-b border-gray-200 pb-2">
                        @foreach ($cartItems as $cart)
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-lg border border-gray-200">
                                        <img src="{{ asset($cart['image']) }}" alt="{{ $cart['name'] }}" width="60">
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="font-bold text-lg">{{ $cart['name'] }}</h3>
                                        <p class="text-sm text-gray-500"><strong>Quantity:</strong> <span class="text-red-600 font-semibold">x{{ $cart['quantity'] }}</span></p>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="font-semibold m-auto">${{ $cart['total'] }}</h4>
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
                            <strong>Subtotal</strong>
                            <span class="text-gray-500">${{ $totalPrice }}</span>
                        </div>
                        <div class="flex justify-between">
                            <strong>Shipping fee</strong>
                            <span class="text-gray-500">$0.00</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <strong>Total</strong>
                        <span class="text-gray-500 text-3xl font-semibold">${{ $totalPrice }}</span>
                    </div>
                </div>
            @else
                <p class="text-center text-3xl font-bold">Your cart is empty! 🚚</p>
            @endif
        </div>
    </div>
</section>
