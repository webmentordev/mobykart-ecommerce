<section class="w-full">
    <div class="max-w-7xl m-auto w-full py-6 px-4 flex 900px:flex-col">
        <div class="max-w-[300px] w-full 900px:hidden">
            <div class="border border-gray-200 rounded-xl w-full mb-5">
                <h3 class="uppercase font-bold text-sm pt-4 pb-3 px-3 border-b border-gray-200">Categories</h3>
                <ul class="flex flex-col">
                    @foreach ($categories as $category)
                        @if(!$loop->last)
                            <a wire:navigate href="{{ route('products.category', $category->slug) }}" class="capitalize font-medium text-gray-500 text-[12px] pt-3 pb-2 px-3 border-b border-gray-200">{{ $category->title }} <span class="text-gray-400">({{ $category->active_products_count }})</span></a>
                        @else
                            <a wire:navigate href="{{ route('products.category', $category->slug) }}" class="capitalize font-medium text-gray-500 text-[12px] pt-3 pb-2 px-3">{{ $category->title }} <span class="text-gray-400">({{ $category->active_products_count }})</span></a>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="border border-gray-200 rounded-xl w-full">
                <h3 class="uppercase font-bold text-sm pt-4 pb-3 px-3 border-b border-gray-200">Brands</h3>
                <ul class="flex flex-col">
                    @foreach ($brands as $brand)
                        @if(!$loop->last)
                            <a wire:navigate href="{{ route('products.brand', $brand->slug) }}" class="capitalize font-medium text-gray-500 text-[12px] pt-3 pb-2 px-3 border-b border-gray-200">{{ $brand->title }} ({{ $brand->active_products_count }})</a>
                        @else
                            <a wire:navigate href="{{ route('products.brand', $brand->slug) }}" class="capitalize font-medium text-gray-500 text-[12px] pt-3 pb-2 px-3">{{ $brand->title }} ({{ $brand->active_products_count }})</a>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="hidden 900px:block mb-5" x-data="{ open: false }">
            <div class="flex items-center cursor-pointer" x-on:click="open = true">
                <div class="rounded-full p-2 bg-gray-100 w-fit">
                    <img src="https://api.iconify.design/lets-icons:filter.svg?color=%23212121" width="30" alt="Filter icon">
                </div>
                <span class="font-semibold">All Departments</span>
            </div>
            <div x-show="open" class="max-w-[300px] w-full fixed min-h-screen overflow-y-scroll bg-white top-0 left-0 z-50 shadow-xl pb-6" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="transform -translate-x-full"
            x-transition:enter-end="transform translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="transform translate-x-0"
            x-transition:leave-end="transform -translate-x-full">
                <div class="flex justify-end bg-red-500 py-3 cursor-pointer px-3 mb-3" x-on:click="open = false">
                    <span class="text-white font-semibold">Close</span>
                </div>
                <div class="w-full mb-5">
                    <h3 class="uppercase font-bold text-sm pt-4 pb-3 px-3 border-b border-gray-200">Categories</h3>
                    <ul class="flex flex-col">
                        @foreach ($categories as $category)
                            @if(!$loop->last)
                                <a wire:navigate href="{{ route('products.category', $category->slug) }}" class="capitalize font-medium text-gray-500 text-[12px] pt-3 pb-2 px-3 border-b border-gray-200">{{ $category->title }} <span class="text-gray-400">({{ $category->active_products_count }})</span></a>
                            @else
                                <a wire:navigate href="{{ route('products.category', $category->slug) }}" class="capitalize font-medium text-gray-500 text-[12px] pt-3 pb-2 px-3">{{ $category->title }} <span class="text-gray-400">({{ $category->active_products_count }})</span></a>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="w-full">
                    <h3 class="uppercase font-bold text-sm pt-4 pb-3 px-3 border-b border-gray-200">Brands</h3>
                    <ul class="flex flex-col">
                        @foreach ($brands as $brand)
                            @if(!$loop->last)
                                <a wire:navigate href="{{ route('products.brand', $brand->slug) }}" class="capitalize font-medium text-gray-500 text-[12px] pt-3 pb-2 px-3 border-b border-gray-200">{{ $brand->title }} ({{ $brand->active_products_count }})</a>
                            @else
                                <a wire:navigate href="{{ route('products.brand', $brand->slug) }}" class="capitalize font-medium text-gray-500 text-[12px] pt-3 pb-2 px-3">{{ $brand->title }} ({{ $brand->active_products_count }})</a>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="w-full ml-3 900px:ml-0">
            <div class="w-full grid grid-cols-4 gap-4 1120px:grid-cols-3 580px:grid-cols-2 440px:grid-cols-1">
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
        </div>
    </div>
</section>
