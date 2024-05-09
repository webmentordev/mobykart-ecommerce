<section class="w-full">
    <div class="max-w-7xl m-auto w-full py-6 px-4 flex gap-4">
        <div class="max-w-[300px] w-full">
            <div class="border border-gray-200 rounded-xl w-full">
                <h3 class="uppercase font-bold text-sm pt-4 pb-3 px-3 border-b border-gray-200">Categories</h3>
                <ul class="flex flex-col">
                    @foreach ($categories as $category)
                        @if(!$loop->last)
                            <a href="{{ route('products') }}" class="capitalize font-medium text-gray-500 text-sm pt-3 pb-2 px-3 border-b border-gray-200">{{ $category->title }} <strong>({{ $category->products_count }})</strong></a>
                        @else
                            <a href="{{ route('products') }}" class="capitalize font-medium text-gray-500 text-sm pt-3 pb-2 px-3">{{ $category->title }} <strong>({{ $category->products_count }})</strong></a>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="w-full ml-3 grid grid-cols-4 gap-4">
            @foreach ($products as $product)
                <a href="{{ route('product', $product->slug) }}" :title="$product->title" class="border border-gray-200 p-4 group" wire:navigate>
                    <img src="{{ asset('storage/'. $product->image) }}" :alt="$product->title">
                    <span class="text-[12px] text-gray-400">{{ $product->category->title }}</span>
                    <div class="flex flex-col justify-between">
                        <h3 class="text-[16px] text-blue-600 font-semibold group-hover:text-red-600">{{ $product->title }}</h3>
                        <span class="text-red-600 font-medium">${{ $product->price }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
