@props(['product'])

<div {{ $attributes->merge(['class' => 'lg:col-span-3']) }}>
    <div class="w-full bg-gray-50 dark:bg-gray-700/50 rounded-2xl h-72 md:h-[400px] overflow-hidden">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
    </div>
</div>
