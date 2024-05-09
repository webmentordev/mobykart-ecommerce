<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Brands Listing') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="max-w-[99%] mx-auto p-3">
            <form action="{{ route('admin.brand.create') }}" method="post" class="flex items-center mb-3">
                @csrf
                @method('POST')
                <div class="w-full">
                    <x-text-input id="title" class="block mt-1 w-full" placeholder="Brand name" type="text" name="title" :value="old('title')" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <x-primary-button class="ml-3 py-3">
                    {{ __('Create') }}
                </x-primary-button>
            </form>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @session('success')
                        <x-alerts.success :message="$value" />
                    @endsession
                    @if (count($brands))
                        <table class="w-full text-[12px] rounded-xl overflow-hidden">
                            <tr class="text-white bg-black">
                                <th class="text-start p-2">Title</th>
                                <th class="text-start">Slug</th>
                                <th class="text-start">Products</th>
                                <th class="text-end">Active</th>
                                <th class="text-end">Created</th>
                                <th class="text-end">Updated</th>
                                <th class="text-end p-2">Edit</th>
                            </tr>
                            @foreach ($brands as $item)
                                <tr class="odd:bg-gray-100">
                                    <td class="text-start p-2">{{ $item->title }}</td>
                                    <td class="text-start">{{ $item->slug }}</td>
                                    <td class="text-start">{{ $item->products_count }}</td>
                                    <td class="text-end p-2">
                                        <form action="{{ route('admin.brand.status', $item->slug) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            @if ($item->is_active)
                                                <button type="submit" class="tb-btn-active">Active</button>
                                            @else
                                                <button type="submit" class="tb-btn-disable">InActive</button>
                                            @endif
                                        </form>
                                    </td>
                                    <td class="text-end">{{ $item->created_at->format('D d m, Y H:i:s A') }} UTC - {{ $item->created_at->diffForHumans() }}</td>
                                    <td class="text-end">
                                        @if ($item->created_at == $item->updated_at)
                                            N/A
                                        @else
                                            {{ $item->updated_at->format('D d m, Y H:i:s A') }} UTC - {{ $item->updated_at->diffForHumans() }}
                                        @endif
                                    </td>
                                    <td class="text-end p-2 flex justify-end relative" x-data="{ open: false }">
                                        <img class="cursor-pointer" x-on:click="open = !open" src="https://api.iconify.design/ph:dots-three-outline-vertical-fill.svg" alt="Dots">
                                        <div x-show="open" x-cloak x-transition class="fixed bottom-3 right-3 p-3 w-[600px] bg-white shadow-lg rounded-lg border border-gray-200">
                                            <div class="flex items-center justify-between mb-2 text-sm">
                                                <h3 class="font-bold name">Update the brand</h3>
                                                <span x-on:click="open = false" class="underline text-gray-700 cursor-pointer">Close</span>
                                            </div>
                                            <form action="{{ route('admin.brand.update', $item->slug) }}" method="post" class="text-start flex flex-col">
                                                @csrf
                                                @method('patch')
                                                <div class="w-full mb-3">
                                                    <x-input-label for="title" :value="__('Brand')" />
                                                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$item->title" required />
                                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                                </div>
                                                <div class="w-full">
                                                    <x-input-label for="slug" :value="__('Slug')" />
                                                    <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="$item->slug" required />
                                                    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                                                </div>
                                                <x-primary-button class="mt-3 py-3 w-fit">
                                                    {{ __('Update') }}
                                                </x-primary-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p class="text-center py-2 px-4">No brands data exist at the moment!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>