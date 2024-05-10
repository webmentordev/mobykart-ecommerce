<section class="w-full">
    <div class="max-w-7xl m-auto w-full py-6 px-4">
        <div class="grid grid-cols-2 gap-12">
            <div class="w-full">
                <img src="{{ asset('storage/'. $product->image) }}" :alt="$product->title" :title="$product->title" class="border border-gray-200 rounded-xl">
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
                <div class="grid grid-cols-3 gap-6 border-b border-gray-200 mt-6 w-full pb-6 mb-3">
                    <div class="flex items-center border p-1 border-gray-200 w-fit rounded-full">
                        <button wire:click='decrement' class="bg-black text-white py-1 px-3 rounded-full font-semibold">-</button>
                        <span class="mx-4">{{ $quantity }}</span>
                        <button wire:click='increment' class="bg-black text-white py-1 px-3 rounded-full font-semibold">+</button>
                    </div>
                    <button wire:click='addToCart' class="bg-black text-white py-2 px-4 rounded-full font-semibold">Add to Cart</button>
                    <button wire:click='checkout' class="bg-red-600 text-white py-2 px-4 rounded-full font-semibold">Buy Now</button>
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
        <article>
            {!! $product->body !!}
        </article>
    </div>
</section>