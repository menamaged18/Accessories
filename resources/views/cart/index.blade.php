<x-app-layout>
    <div class="py-12 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">Your Shopping Cart</h1>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-500/20 text-green-400 border border-green-500/50 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(!$cart || $cart->items->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-400 mb-4">Your cart is empty.</p>
                    <a href="/" class="text-indigo-400 hover:text-indigo-300 underline">Go Shopping</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($cart->items as $item)
                        <x-product-card :product="$item->product" type="list" class="mb-4">
                            <div class="flex flex-col gap-4 mt-2">
                                {{-- Quantity Controls --}}
                                <div class="flex items-center justify-between bg-gray-700/50 p-2 rounded-lg">
                                    <div class="flex items-center gap-4">
                                        {{-- Decrease Quantity --}}
                                        <form action="/cart/remove/{{ $item->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded bg-gray-600 hover:bg-gray-500 flex items-center justify-center transition-colors">
                                                -
                                            </button>
                                        </form>

                                        <span class="font-bold text-lg text-white">{{ $item->quantity }}</span>

                                        {{-- Increase Quantity (Uses your existing add route) --}}
                                        <form action="/cart/add/{{ $item->product_id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded bg-gray-600 hover:bg-gray-500 flex items-center justify-center transition-colors">
                                                +
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Subtotal for this item --}}
                                    <span class="text-indigo-400 font-semibold">
                                        {{ number_format($item->product->price * $item->quantity, 2) }} $
                                    </span>
                                </div>

                                {{-- Full Delete Button --}}
                                <form action="{{ route('cart.remove-by-product', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-center py-1 text-xs text-red-400 hover:text-red-300 border border-red-500/30 hover:border-red-500 rounded transition-all">
                                        Remove from Cart
                                    </button>
                                </form>
                            </div>
                        </x-product-card>
                    @endforeach
                </div>

                {{-- Order Summary --}}
                <div class="mt-8 p-6 bg-gray-800 rounded-xl border border-gray-700 flex flex-col items-end">
                    <p class="text-gray-400">Total Amount</p>
                    <h2 class="text-3xl font-black text-white">
                        {{ number_format($cart->items->sum(fn($i) => $i->quantity * $i->product->price), 2) }} $
                    </h2>
                    <a href="{{ route('checkout.index') }}" class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-indigo-500/20 text-center inline-block">
                        Checkout
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
