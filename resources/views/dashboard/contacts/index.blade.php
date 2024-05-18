<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Contacts') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="max-w-[99%] mx-auto p-3">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (count($contacts))
                        <table class="w-full text-[12px] rounded-xl overflow-hidden">
                            <tr class="text-white bg-black">
                                <th class="text-start p-2">Name</th>
                                <th class="text-start">Email</th>
                                <th class="text-start">Subject</th>
                                <th class="text-start">Message</th>
                                <th class="text-end p-2">Created</th>
                            </tr>
                            @foreach ($contacts as $item)
                                <tr class="odd:bg-gray-100">
                                    <td class="text-start p-2">{{ $item->name }}</td>
                                    <td class="text-start">{{ $item->email }}</td>
                                    <td class="text-start">{{ $item->subject }}</td>
                                    <td class="text-start">{{ $item->message }}</td>
                                    <td class="text-end p-2">{{ $item->created_at->format('D d m, Y H:i:s A') }} UTC - {{ $item->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p class="text-center py-2 px-4">No contacts data exist at the moment!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>