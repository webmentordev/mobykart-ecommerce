@extends('layouts.apps')
@section('title', 'Contact')
@section('content')
    <section class="min-h-[50vh] flex items-center py-12">
        <div class="bg-gray-100 rounded-md p-6 max-w-lg w-full text-sm m-auto">
            @session('success')
                <x-alerts.success :message="$value" />
            @endsession
            <form action="{{ route('contact') }}" method="post">
                @csrf
                <h1 class="text-2xl mb-3 font-semibold">Contact Us!</h1>
                <div class="mb-3 w-full">
                    <x-input-label for="name" :value="__('Full name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mb-3 w-full">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mb-3 w-full">
                    <x-input-label for="subject" :value="__('Subject')" />
                    <x-text-input id="subject" class="block mt-1 w-full" type="text" name="subject" :value="old('subject')" required />
                    <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                </div>
                <div class="mb-3 w-full">
                    <x-input-label for="message" :value="__('Message')" />
                    <x-textarea id="message" class="block mt-1 w-full" name="message" required>{{ old('message') }}</x-textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                </div>
                <x-primary-button class="mt-3">
                    {{ __('Send message') }}
                </x-primary-button>
            </form>
        </div>
    </section>
@endsection