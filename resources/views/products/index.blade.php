<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Product Grid Wrapper --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 border border-gray-100 dark:border-gray-700 flex flex-col">

                        {{-- Image Container with Aspect Ratio --}}
                        <div class="relative aspect-square w-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover object-center transition-transform duration-500 hover:scale-110"
                            >
                        </div>

                        {{-- Product Details --}}
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 leading-tight">
                                    {{ $product->name }}
                                </h3>
                                <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">
                                    {{ $product->price }} $
                                </span>
                            </div>

                            {{-- Optional: Short Description --}}
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4 overflow-hidden">
                                {{ $product->description ?? 'Premium quality accessory for your collection.' }}
                            </p>

                            {{-- Actions --}}
                            <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700">
                                @auth
                                    <form action="/cart/add/{{ $product->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 group">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="block text-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                                        Log in to purchase
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
