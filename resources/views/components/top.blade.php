<section class="w-full bg-gray-100 p-3">
    <div class="w-full max-w-7xl m-auto px-4 flex items-center justify-between 460px:flex-col">
        <a href="mailto:contact@mobycart.com" class="flex items-center">
            <img src="https://api.iconify.design/fluent:mail-48-regular.svg" width="20" alt="Mobycart Email icon">
            <span class="text-sm ml-2 text-gray-500">contact@mobycart.com</span>
        </a>
        <ul class="text-sm text-gray-500 460px:mt-2">
            <a href="{{ route('contact') }}" class="pr-6 border-r border-gray-200 580px:hidden">Contact</a>
            <a href="{{ route('track.order') }}" class="pl-5 460px:underline 460px:text-red-500">Track Your Order</a>
        </ul>
    </div>
</section>