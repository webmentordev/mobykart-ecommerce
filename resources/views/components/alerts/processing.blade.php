@props(['message'])
<div {!! $attributes->merge(['class' => 'bg-black flex items-center py-5 px-6 font-semibold text-lg fixed bottom-3 left-3 rounded-lg text-white']) !!}>
    <img src="https://api.iconify.design/svg-spinners:90-ring-with-bg.svg?color=%23ffffff" alt="Processing Icon" width="30"> 
    <p class="ml-4">{{ $message }}</p>
</div>