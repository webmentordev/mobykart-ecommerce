<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Tags Database') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="max-w-[99%] mx-auto p-3">
            <form action="{{ route('admin.tag.store') }}" method="post" enctype="multipart/form-data" class="flex items-center mb-3">
                @csrf
                @method('POST')
                <div class="w-full bg-white p-2 rounded-lg">
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required placeholder="Use , to separate the tags, don't put space at the start" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
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
                    @if (count($tags))
                        <table class="w-full text-[12px] rounded-xl overflow-hidden">
                            <tr class="text-white bg-black">
                                <th class="text-start p-2">Name</th>
                                <th class="text-start">Slug</th>
                                <th class="text-end">Added</th>
                                <th class="text-end p-2">Delete</th>
                            </tr>
                            @foreach ($tags as $item)
                                <tr class="odd:bg-gray-100">
                                    <td class="text-start p-2">{{ $item->name }}</td>
                                    <td class="text-start">{{ $item->slug }}</td>
                                    <td class="text-end">{{ $item->created_at->format('D d m, Y H:i:s A') }} UTC - {{ $item->created_at->diffForHumans() }}</td>
                                    <td class="text-end p-2">
                                        <form action="{{ route('admin.tag.delete', $item->slug) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="tb-btn-disable" onclick="return confirm('Are you sure you want to delete?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p class="text-center py-2 px-4">No tags data exist at the moment!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>