<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    @php
                        $isInCart = in_array($product->id, $userCartProductIds);
                    @endphp

                    <x-product-card :product="$product" :isInCart="$isInCart">
                        @if(Auth::check() && !Auth::user()->isAdmin())
                            @if($isInCart)
                                <div class="flex flex-col gap-2">
                                    <span class="text-center text-green-600 font-bold py-2 bg-green-50 rounded-lg border border-green-200">
                                        ✓ In Your Cart
                                    </span>
                                    <form action="/cart/deleteByProductId/{{ $product->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-xs font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 hover:underline transition-colors duration-200">
                                            Remove Item
                                        </button>
                                    </form>
                                </div>
                            @else
                                <form action="/cart/add/{{ $product->id }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg transition">
                                        Add to Cart
                                    </button>
                                </form>
                            @endif
                        @endif
                    </x-product-card>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
