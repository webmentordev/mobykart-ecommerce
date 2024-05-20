@extends('layouts.apps')
@section('title', 'Contact')
@section('content')
    <section class="min-h-[50vh] flex items-center py-12">
        <div class="bg-gray-100 rounded-md p-6 max-w-lg w-full text-sm m-auto">
            @session('success')
                <x-alerts.success :message="$value" />
            @endsession
            <form action="{{ route('track.order') }}" method="get">
                <h1 class="text-2xl mb-3 font-semibold">Trach your order!</h1>
                <div class="mb-3 w-full">
                    <x-input-label for="order" :value="__('Order ID')" />
                    <x-text-input id="order" class="block mt-1 w-full" type="text" name="order" :value="old('order')" required />
                    <x-input-error :messages="$errors->get('order')" class="mt-2" />
                </div>
                <x-primary-button class="mt-3">
                    {{ __('Search') }}
                </x-primary-button>
                @if ($order)
                    <div class="mt-3">
                        @if ($order->shipping == 'pending')
                            <div class="bg-white border border-gray-300 w-full p-3 rounded-lg">
                                Cuttent: Pending | order has been placed ♻
                            </div>
                        @elseif ($order->shipping == 'processed')
                            <div class="bg-white border border-gray-300 w-full p-3 rounded-lg">
                                Cuttent: Processed | order was processed 📦
                            </div>
                        @elseif ($order->shipping == 'transit')
                            <div class="bg-white border border-gray-300 w-full p-3 rounded-lg">
                                Cuttent: In-Transit | order has been dispatched! 🚚
                            </div>
                        @elseif ($order->shipping == 'completed')
                            <div class="bg-white border border-gray-300 w-full p-3 rounded-lg">
                                Cuttent: Completed | order has been delivered! 🔔
                            </div>
                        @elseif ($order->shipping == 'refunded')
                            <div class="bg-white border border-gray-300 w-full p-3 rounded-lg">
                                Cuttent: Refunded | order has been refunded! 💸
                            </div>
                        @elseif ($order->shipping == 'canceled')
                            <div class="bg-white border border-gray-300 w-full p-3 rounded-lg">
                                Cuttent: Canceled | place a new order 💥
                            </div>
                        @endif
                    </div>
                @endif
            </form>
        </div>
    </section>
@endsection