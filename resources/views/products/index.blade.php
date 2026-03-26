<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Product Grid Wrapper --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product">
                        <form action="/cart/add/{{ $product->id }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg">
                                Add to Cart
                            </button>
                        </form>
                    </x-product-card>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
