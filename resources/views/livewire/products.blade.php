<section class="w-full min-h-[40vh]">
    <div class="max-w-7xl m-auto w-full py-6 px-4 flex">
        @if (count($products))
            <div class="w-full ml-3 grid grid-cols-5 gap-4 1120px:grid-cols-4 850px:grid-cols-3 580px:grid-cols-2 440px:grid-cols-1">
                @foreach ($products as $product)
                    <a href="{{ route('product', $product->slug) }}" :title="$product->title" class="relative border px-4 py-2 border-gray-200 group rounded-xl" wire:navigate>
                        @if ($product->discount)
                            <span class="absolute top-3 left-3 text-[12px] bg-red-600 rounded-full text-white py-1 px-2">-%{{ $product->discount->discount }}</span>
                        @endif
                        <img src="{{ asset('storage/'. $product->image) }}" :alt="$product->title">
                        <span class="text-[12px] text-gray-400">{{ $product->category->title }}</span>
                        <div class="flex flex-col justify-between">
                            <h3 class="text-[15px] text-blue-600 font-semibold group-hover:text-red-600">{{ $product->title }}</h3>
                            @if ($product->discount)
                                <div class="flex items-center mt-3">
                                    <del class="text-gray-500 font-medium text-[12px] mr-1">${{ $product->price }}</del>
                                    <span class="text-red-600 font-medium">${{ number_format($product->price - ($product->price * ($product->discount->discount / 100)), 2) }}</span>
                                </div>
                            @else
                                <span class="text-gray-500 font-medium mt-3">${{ $product->price }}</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="py-12 px-4 text-center text-2xl m-auto">Products not found! 😓</p>
        @endif
    </div>
</section>