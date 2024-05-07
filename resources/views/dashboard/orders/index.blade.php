<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Orders') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="max-w-[99%] mx-auto p-3">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @session('success')
                        <x-alerts.success :message="$value" />
                    @endsession
                    @if (count($orders))
                        <table class="w-full text-[12px] rounded-xl overflow-hidden">
                            <tr class="text-white bg-black">
                                <th class="text-start p-2">Order</th>
                                <th class="text-start">Name</th>
                                <th class="text-start">Email</th>
                                <th class="text-start">TrackingID</th>
                                <th class="text-start">Logistics</th>
                                <th class="text-start">Product</th>
                                <th class="text-start">Price</th>
                                <th class="text-start">Quantity</th>
                                <th class="text-start">Paid</th>
                                <th class="text-start">Payment</th>
                                <th class="text-start">Shipping</th>
                                <th class="text-end">URL</th>
                                <th class="text-end">Created</th>
                                <th class="text-end p-2">Edit</th>
                            </tr>
                            @foreach ($orders as $item)
                                <tr class="odd:bg-gray-100">
                                    <td class="text-start p-2">{{ $item->order_id }}</td>
                                    <td class="text-start">{{ $item->name }}</td>
                                    <td class="text-start">{{ $item->email }}</td>
                                    <td class="text-start">
                                        @if ($item->transit_id)
                                            {{ $item->transit_id }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        @if ($item->logistics)
                                            {{ $item->logistics }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="text-start">{{ $item->product->title }}</td>
                                    <td class="text-start">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-start">{{ $item->quantity }}</td>
                                    <td class="text-start">
                                        @if ($item->is_paid)
                                            <span class="p-1 rounded-full font-semibold text-white bg-green-600">Yes</span>
                                        @else
                                            <span class="p-1 rounded-full font-semibold text-white bg-red-600">No</span>
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        @if ($item->payment == 'pending')
                                            <span class="py-1 rounded-full font-semibold text-black bg-yellow-500 px-2 capitalize">{{ $item->payment }}</span>
                                        @elseif($item->payment == 'completed')
                                            <span class="py-1 rounded-full font-semibold text-white bg-green-600 px-2 capitalize">{{ $item->payment }}</span>
                                        @else
                                            <span class="py-1 rounded-full font-semibold text-white bg-red-600 px-2 capitalize">{{ $item->payment }}</span>
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        @if ($item->shipping == 'pending')
                                            <span class="py-1 rounded-full font-semibold text-black bg-yellow-500 px-2 capitalize">{{ $item->shipping }}</span>
                                        @elseif ($item->shipping == 'processed')
                                            <span class="py-1 rounded-full font-semibold text-white bg-blue-500 px-2 capitalize">{{ $item->shipping }}</span>
                                        @elseif($item->shipping == 'completed')
                                            <span class="py-1 rounded-full font-semibold text-white bg-green-600 px-2 capitalize">{{ $item->shipping }}</span>
                                        @elseif($item->shipping == 'canceled')
                                            <span class="py-1 rounded-full font-semibold text-white bg-red-600 px-2 capitalize">{{ $item->shipping }}</span>
                                        @elseif($item->shipping == 'refunded')
                                            <span class="py-1 rounded-full font-semibold text-white bg-red-600 px-2 capitalize">{{ $item->shipping }}</span>
                                        @elseif($item->shipping == 'transit')
                                            <span class="py-1 rounded-full font-semibold text-white bg-black px-2 capitalize">{{ $item->shipping }}</span>
                                        @endif
                                    </td>
                                    <td class="text-start"><a href="{{ $item->url }}" target="_blank" class="underline text-blue-600 font-bold">Visit</a></td>
                                    <td class="text-end">{{ $item->created_at->format('D d m, Y H:i:s A') }} UTC - {{ $item->created_at->diffForHumans() }}</td>
                                    <td class="text-start p-2 flex justify-end items-center" x-data="{ open: false }">
                                        <img class="cursor-pointer" x-on:click="open = !open" src="https://api.iconify.design/ph:dots-three-outline-vertical-fill.svg" alt="Dots">
                                        <div x-show="open" x-cloak x-transition class="fixed top-0 left-0 w-full h-full bg-black/10 backdrop-blur">
                                            <div class="flex items-center justify-center w-full h-full" x-on:click.self="open = false">
                                                <div class="max-w-2xl w-full bg-white border border-gray-200 p-6 rounded-2xl">
                                                    <div class="flex items-center justify-between mb-2 text-sm">
                                                        <h3 class="font-bold name">Update shipping status </h3>
                                                        <p><strong>OrderID:</strong> {{ $item->order_id }}</p>
                                                    </div>
                                                    <p class="capitalize"><strong>Current:</strong> {{ $item->shipping }}</p>
                                                    @if ($item->shipping == "pending" || $item->shipping == "processed" || $item->shipping == "transit")
                                                        <form action="{{ route('admin.order.status', $item->order_id) }}" method="post">
                                                            @csrf
                                                            @method('patch')
                                                            <div class="w-full mb-3">
                                                                @if ($item->shipping == 'pending')
                                                                    <x-select class="block mt-1 w-full" name="status" required>
                                                                        <option value="processed" selected>Processed - selected</option>
                                                                        <option value="transit">In Transit</option>
                                                                        <option value="completed">Completed</option>
                                                                        <option value="canceled">Canceled</option>
                                                                        <option value="refunded">Refunded</option>
                                                                    </x-select>
                                                                @elseif ($item->shipping == 'processed')
                                                                    <x-select class="block mt-1 w-full" name="status" required>
                                                                        <option value="transit" selected>In Transit - selected</option>
                                                                        <option value="completed">Completed</option>
                                                                        <option value="canceled">Canceled</option>
                                                                        <option value="refunded">Refunded</option>
                                                                    </x-select>
                                                                @elseif ($item->shipping == 'transit')
                                                                    <x-select class="block mt-1 w-full" name="status" required>
                                                                        <option value="completed" selected>Completed - selected</option>
                                                                        <option value="canceled">Canceled</option>
                                                                        <option value="refunded">Refunded</option>
                                                                    </x-select>
                                                                @endif
                                                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                                            </div>

                                                            @if ($item->shipping == 'processed')
                                                                <div class="w-full mb-3">
                                                                    <x-text-input id="title" class="block mt-1 w-full" placeholder="TrackingID" type="text" name="transit" />
                                                                    <x-input-error :messages="$errors->get('transit')" class="mt-2" />
                                                                </div>
                                                                <div class="w-full mb-3">
                                                                    <x-text-input id="title" class="block mt-1 w-full" placeholder="Logistics Name" type="text" name="logistics" />
                                                                    <x-input-error :messages="$errors->get('logistics')" class="mt-2" />
                                                                </div>
                                                            @endif
                                                            <div class="flex items-center">
                                                                <input type="checkbox" id="email_send" name="email_send" checked>
                                                                <label for="email_send" class="ml-2 text-base">Send email?</label>
                                                            </div>
                                                            <x-primary-button class="mt-3 py-3">
                                                                {{ __('Update') }}
                                                            </x-primary-button>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p class="text-center py-2 px-4">No orders data exist at the moment!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>