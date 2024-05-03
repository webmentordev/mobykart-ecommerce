@props(['message'])
<div {!! $attributes->merge(['class' => 'bg-black flex items-center py-5 px-6 font-semibold text-lg fixed bottom-3 left-3 rounded-lg text-white']) !!}>
    <img src="https://api.iconify.design/material-symbols:check-circle-outline-rounded.svg?color=%2337d82c" alt="Check Icon" width="30"> 
    <p class="ml-4">{{ $message }}</p>
</div>