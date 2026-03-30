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
                                    <form action="{{ route('cart.remove-by-product', $product->id) }}" method="POST">
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
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                           class="flex-1 text-center py-2 px-3 text-sm font-medium text-white border border-blue-600 rounded-lg hover:bg-blue-600 hover:text-white dark:text-blue-400 dark:border-blue-400 dark:hover:bg-blue-400 dark:hover:text-gray-900 transition-all duration-200">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this product?')"
                                              class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full py-2 px-3 text-sm font-medium text-red-600 border border-red-600 rounded-lg hover:bg-red-600 hover:text-white dark:text-red-400 dark:border-red-400 dark:hover:bg-red-400 dark:hover:text-gray-900 transition-all duration-200">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                    </x-product-card>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
