@props(['product', 'type' => 'grid'])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 border border-gray-100 dark:border-gray-700 flex ' . ($type === 'list' ? 'flex-row h-32' : 'flex-col')]) }}>

    {{-- Image --}}
    <div class="{{ $type === 'list' ? 'w-32' : 'relative aspect-square w-full' }} bg-gray-200 dark:bg-gray-700 overflow-hidden">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
    </div>

    {{-- Details --}}
    <div class="p-4 flex flex-col flex-grow">
        <div class="flex justify-between items-start">
            <h3 class="font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</h3>
            <span class="font-black text-indigo-600">{{ $product->price }} $</span>
        </div>

        @if($type === 'grid')
            <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $product->description }}</p>
        @endif

        {{-- Slot for Actions (Add to Cart vs Remove/Quantity) --}}
        <div class="mt-auto pt-2">
            {{ $slot }}
        </div>
    </div>
</div>
