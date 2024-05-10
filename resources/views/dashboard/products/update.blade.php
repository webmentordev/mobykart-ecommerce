<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Update Product') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="max-w-3xl mx-auto p-3">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.product.update', $product->slug) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @session('success')
                            <x-alerts.success :message="$value" />
                        @endsession
                        <div class="grid grid-cols-2 gap-3">
                            <div class="w-full mb-3">
                                <x-input-label for="title" :value="__('Product Title')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$product->title" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            <div class="w-full mb-3">
                                <x-input-label for="title" :value="__('Product price in $')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="$product->price" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                        </div>
                        <div class="w-full mb-3">
                            <x-input-label for="slug" :value="__('Product Slug')" />
                            <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="$product->slug" required />
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="w-full mb-3">
                                <x-input-label for="brand" :value="__('Brand')" />
                                <x-select id="brand" class="block mt-1 w-full" name="brand" required>
                                    @if (count($brands))
                                        <option value="{{ $product->brand->id }}" select> {{ $product->brand->title }}</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                        @endforeach
                                    @else
                                        <option value="" select> No brand exist</option>
                                    @endif
                                </x-select>
                                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                            </div>
                            <div class="w-full mb-3">
                                <x-input-label for="category" :value="__('Category')" />
                                <x-select id="category" class="block mt-1 w-full" name="category" required>
                                    @if (count($categories))
                                        <option value="{{ $product->category->id }}" select> {{ $product->category->title }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    @else
                                        <option value="" select> No category exist</option>
                                    @endif
                                </x-select>
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>
                        </div>
                        <div class="w-full mb-3">
                            <x-input-label for="seo" :value="__('SEO')" />
                            <x-text-input id="seo" class="block mt-1 w-full" type="text" name="seo" :value="$product->seo" required />
                            <x-input-error :messages="$errors->get('seo')" class="mt-2" />
                        </div>
                        <div class="w-full mb-3">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description">{{ $product->description }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="w-full mb-3">
                            <textarea id="body" name="body">{{ $product->body }}</textarea>
                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                        </div>
                        <div class="w-full my-3">
                            <x-input-label for="image" :value="__('Image')" />
                            <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                        <x-primary-button class="mt-3 py-3">
                            {{ __('Update') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'body', {
                filebrowserUploadUrl: "{{route('admin.image.upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form'
            });
            CKEDITOR.replace( 'description');
        </script>
    </div>
</x-app-layout>