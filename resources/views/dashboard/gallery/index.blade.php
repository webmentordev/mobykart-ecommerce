<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Gallery') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="max-w-[99%] mx-auto p-3">
            <form action="{{ route('admin.gallery.store') }}" method="post" enctype="multipart/form-data" class="flex items-center mb-3 bg-white p-2 rounded-lg">
                @csrf
                @method('POST')
                <div class="w-full">
                    <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" required />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
                <div class="w-full">
                    <x-select id="brand" class="block mt-1 w-full" name="product" required>
                        @if (count($products))
                            <option value="" select> Select the product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->title }}</option>
                            @endforeach
                        @else
                            <option value="" select> No product exist</option>
                        @endif
                    </x-select>
                    <x-input-error :messages="$errors->get('product')" class="mt-2" />
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
                    @if (count($images))
                        <table class="w-full text-[12px] rounded-xl overflow-hidden">
                            <tr class="text-white bg-black">
                                <th class="text-start p-2">Product</th>
                                <th class="text-start">Link</th>
                                <th class="text-start">View</th>
                                <th class="text-end">Status</th>
                                <th class="text-end">Uploaded</th>
                                <th class="text-end p-2">Delete</th>
                            </tr>
                            @foreach ($images as $item)
                                <tr class="odd:bg-gray-100">
                                    <td class="text-start p-2">{{ $item->product->title }}</td>
                                    <td class="text-start">{{ url('/').'/storage/'.$item->image }}</td>
                                    <td class="text-start"><a href="{{ url('/').'/storage/'.$item->image }}" class="underline text-blue-600 font-bold" target="_blank">(view)</a></td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.gallery.status', $item->slug) }}" method="post">
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
                                    <td class="text-end p-2">
                                        <form action="{{ route('admin.gallery.delete', $item->slug) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="tb-btn-disable" onclick="return confirm('Are you sure you want to delete?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p class="text-center py-2 px-4">No gallery images data exist at the moment!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>