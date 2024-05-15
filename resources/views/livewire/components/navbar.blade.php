<nav class="w-full">
    <div class="border-b border-gray-200">
        <div class="max-w-7xl py-6 px-4 m-auto w-full flex items-center justify-between">
            <a href="/" wire:navigate><img src="{{ asset('images/logo.png') }}" alt="MobyKart Logo" width="180"></a>
            <form wire:submit='search' class="flex border border-gray-200 rounded-full p-1 px-2 max-w-[740px] w-full" method="get">
                <x-input type="text" wire:model="title" placeholder="Search product..." />
                <button class="bg-black py-1 px-6 text-white rounded-full" type='submit'>
                    <img src="https://api.iconify.design/gravity-ui:magnifier.svg?color=%23ffffff" width="28" alt="Search icon">
                </button>
            </form>
            <div class="flex items-center">
                <a href="{{ route('cart') }}" class="relative" wire:navigate>
                    <img src="https://api.iconify.design/teenyicons:bag-outline.svg?color=%23292929" alt="Cart icon" width="30">
                    <span class="absolute -top-3 -right-2 bg-red-600 text-white rounded-full text-sm w-[20px] h-[20px] flex items-center justify-center">{{ $cartCount }}</span>
                </a>
            </div>
        </div>
    </div>
    <div class="max-w-7xl py-6 px-4 m-auto w-full flex items-center justify-between">
        <ul class="flex items-center uppercase font-semibold text-sm">
            <a class="pr-4" href="/" wire:navigate>Home</a>
            <a class="px-4" href="{{ route('products') }}" wire:navigate>Products</a>
            <a class="px-4" href="{{ route('cart') }}" wire:navigate>Cart</a>
            {{-- <a class="px-4" href="/" wire:navigate>About</a>
            <a class="px-4" href="/" wire:navigate>FAQ</a>
            <a class="px-4" href="/" wire:navigate>Contact</a> --}}
            @auth
                <a class="px-4" href="{{ route('dashboard') }}" wire:navigate>Dashboard</a>
            @endauth
        </ul>
        <div class="flex items-center">
            <img src="https://api.iconify.design/mdi:truck-fast-outline.svg?color=%23d40808" width="25" alt="Shipping cart">
            <span class="text-sm ml-2 text-gray-500">Free Shipping all over the world</span>
        </div>
    </div>
</nav>