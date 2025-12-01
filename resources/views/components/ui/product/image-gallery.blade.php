@props(['product'])
@php
    $thumbs = [
        'https://placehold.co/600x400?text=Img%0A1',
        'https://placehold.co/600x400?text=Img%0A2',
        'https://placehold.co/600x400?text=Img%0A3',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'lg:col-span-3 flex flex-col md:flex-row gap-4']) }} x-data="{ currentImage: '{{ $product->image_url }}' }">
    {{-- Main image first on small, thumbs flow under; on md+ thumbs are left column --}}
    <div class="order-1 md:order-2 w-full bg-gray-50 dark:bg-gray-700/50 rounded-2xl h-72 md:h-[500px] overflow-hidden">
        <img :src="currentImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
    </div>

    <div class="order-2 md:order-1 flex-row md:flex-col flex md:flex-col justify-start w-full md:w-[120px] gap-2">
        <button class="bg-gray-50 dark:bg-gray-700/50 rounded border w-1/4 md:w-[120px] h-20 md:h-[120px] overflow-hidden"
            @click="currentImage = '{{ $product->image_url }}'">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
        </button>

        @foreach ($thumbs as $img)
            <button
                class="bg-gray-50 dark:bg-gray-700/50 rounded border hover:border-blue-400 dark:hover:border-blue-500 w-1/4 md:w-[120px] h-20 md:h-[120px] overflow-hidden"
                @click="currentImage = '{{ $img }}'">
                <img src="{{ $img }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            </button>
        @endforeach
    </div>
</div>
