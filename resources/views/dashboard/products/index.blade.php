<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Products Listing') }}
                </h2>
                <a href="{{ route('admin.product.create') }}" class="py-2 px-4 bg-black text-white font-semibold rounded-lg">Create</a>
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
                    @if (count($products))
                        <table class="w-full text-[12px] rounded-xl overflow-hidden">
                            <tr class="text-white bg-black">
                                <th class="text-start p-2">StripeID</th>
                                <th class="text-start">Title</th>
                                <th class="text-start">Slug</th>
                                <th class="text-start">Price</th>
                                <th class="text-start">Tags</th>
                                <th class="text-start">Brand</th>
                                <th class="text-start">Category</th>
                                <th class="text-start">Featured</th>
                                <th class="text-end">Active</th>
                                <th class="text-end">Created</th>
                                <th class="text-end">Updated</th>
                                <th class="text-end p-2">Edit</th>
                            </tr>
                            @foreach ($products as $item)
                                <tr class="odd:bg-gray-100">
                                    <td class="text-start p-2">{{ $item->stripe_id }}</td>
                                    <td class="text-start"><a class="underline text-blue-600" href="{{ route('product', $item->slug) }}">{{ $item->title }}</a></td>
                                    <td class="text-start">{{ $item->slug }}</td>
                                    <td class="text-start">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-start">{{ $item->tags_count }}</td>
                                    <td class="text-start">{{ $item->brand->title }}</td>
                                    <td class="text-start">{{ $item->category->title }}</td>
                                    <td class="text-start">
                                        <form action="{{ route('admin.product.feature', $item->slug) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            @if ($item->is_featured)
                                                <button type="submit" class="tb-btn-active">Featured</button>
                                            @else
                                                <button type="submit" class="tb-btn-disable">NotFeatured</button>
                                            @endif
                                        </form>
                                    </td>
                                    <td class="text-end p-2">
                                        <form action="{{ route('admin.product.status', $item->slug) }}" method="post">
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
                                    <td class="text-end p-2"><a href="{{ route('admin.product.update', $item->slug) }}" class="underline text-blue-500 font-bold">Edit</a></td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p class="text-center py-2 px-4">No products data exist at the moment!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>