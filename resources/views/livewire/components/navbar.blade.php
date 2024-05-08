<nav class="w-full">
    <div class="border-b border-gray-200">
        <div class="max-w-7xl py-6 px-4 m-auto w-full flex items-center justify-between">
            <a href="/"><img src="{{ asset('images/logo.png') }}" alt="MobyKart Logo" width="180"></a>
            <form wire:submit.prevent='search' class="flex border border-gray-200 rounded-full p-1 px-2 max-w-[740px] w-full">
                <x-input type="text" placeholder="Search product..." />
                <button class="bg-black py-1 px-6 text-white rounded-full">
                    <img src="https://api.iconify.design/gravity-ui:magnifier.svg?color=%23ffffff" width="28" alt="Search icon">
                </button>
            </form>
            <div class="flex items-center">
                <a href="{{ route('cart') }}" class="relative"><img src="https://api.iconify.design/teenyicons:bag-outline.svg?color=%23292929" alt="Cart icon" width="30">
                    <span class="absolute -top-3 -right-2 bg-red-600 text-white rounded-full text-sm w-[20px] h-[20px] flex items-center justify-center">0</span>
                </a>
            </div>
        </div>
    </div>
    <div class="max-w-7xl py-6 px-4 m-auto w-full flex items-center justify-between">
        <ul class="flex items-center uppercase font-semibold text-sm">
            <a class="pr-4" href="/">Home</a>
            <a class="px-4" href="/">About</a>
            <a class="px-4" href="/">Cart</a>
            <a class="px-4" href="/">FAQ</a>
            <a class="px-4" href="/">Contact</a>
        </ul>
        <div class="flex items-center">
            <img src="https://api.iconify.design/mdi:truck-fast-outline.svg?color=%23d40808" width="25" alt="Shipping cart">
            <span class="text-sm ml-2 text-gray-500">Free Shipping all over the world</span>
        </div>
    </div>
</nav>
