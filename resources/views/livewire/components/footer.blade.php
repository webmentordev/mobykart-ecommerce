<footer class="bg-gray-100">
    <div class="max-w-7xl m-auto py-12 px-4 grid grid-cols-4 gap-6 1000px:grid-cols-3 680px:grid-cols-1">
        <div class="flex flex-col">
            <img src="{{ asset('images/logo.png') }}" width="200px" alt="MobiKart Logo" class="mb-4">
            <p class="text-gray-600 mb-4 text-sm">If you have any question, please contact us at</p>
            <a href="mailto:contact@mobycart.com" class="text-red-600"><strong>contact@mobykart.com</strong></a>
        </div>
        <ul class="flex flex-col">
            <h3 class="font-bold mb-6 uppercase">Categories</h3>
            @foreach ($categories as $category)
                <a class="capitalize text-gray-600 mb-3 hover:text-red-600 text-sm" href="/category/{{ $category->slug }}">{{ $category->title }}</a>
            @endforeach
        </ul>
        <ul class="flex flex-col">
            <h3 class="font-bold mb-6 uppercase">Customer Services</h3>
            <a class="capitalize text-gray-600 mb-3 hover:text-red-600 text-sm" href="/contact">Contact Us</a>
            <a class="capitalize text-gray-600 mb-3 hover:text-red-600 text-sm" href="/">Track your Order</a>
            <a class="capitalize text-gray-600 mb-3 hover:text-red-600 text-sm" href="/">Return policy</a>
            <a class="capitalize text-gray-600 mb-3 hover:text-red-600 text-sm" href="/">Privacy Policy</a>
            <a class="capitalize text-gray-600 mb-3 hover:text-red-600 text-sm" href="/">Terms of service</a>
        </ul>
        <ul class="flex flex-col">
            <h3 class="font-bold mb-6 uppercase">Newsletter</h3>
            <p class="text-gray-600 mb-4 text-sm">Subscribe to the weekly newsletter for all the latest updates</p>
            <form action="{{ route('newsletter.create') }}" method="POST">
                @csrf
                @session('newsletter')
                    <x-alerts.success :message="$value" />
                @endsession
                <x-input name="email" required placeholder="Your email address" class="border border-gray-300 outline rounded-lg bg-white" />
                <button type="submit" class="text-white text-sm py-2 px-3 bg-red-500 rounded-sm mt-2 inline-block">Subscribe</button>
            </form>
        </ul>
    </div>
    <div class="w-full bg-primary-dark">
        <div class="max-w-7xl m-auto py-8 px-4 text-center text-sm">
            <p class="text-gray-200">Copyrights &copy; {{ date('Y') }} {{ config('app.name') }} all reserved.</p>
        </div>
    </div>
</footer>