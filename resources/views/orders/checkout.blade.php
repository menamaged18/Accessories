<x-app-layout>
    <div class="py-12 text-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">Checkout</h1>

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-500/20 text-red-400 border border-red-500/50 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-gray-800 rounded-xl p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                <div class="space-y-4">
                    @foreach($cart->items as $item)
                        <div class="flex justify-between border-b border-gray-700 pb-2">
                            <div>
                                <span class="font-medium">{{ $item->product->name }}</span>
                                <span class="text-gray-400 text-sm"> x {{ $item->quantity }}</span>
                            </div>
                            <span>{{ number_format($item->product->price * $item->quantity, 2) }} $</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between mt-4 pt-2 border-t border-gray-700">
                    <span class="font-bold">Total</span>
                    <span class="font-bold text-xl text-indigo-400">
                        {{ number_format($cart->items->sum(fn($i) => $i->quantity * $i->product->price), 2) }} $
                    </span>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-4">Shipping Details</h2>
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="shipping_address" class="block text-sm font-medium mb-1">Address *</label>
                            <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address') }}" class="w-full bg-gray-700 border-gray-600 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 text-white" required>
                            @error('shipping_address') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="shipping_city" class="block text-sm font-medium mb-1">City *</label>
                            <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city') }}" class="w-full bg-gray-700 border-gray-600 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 text-white" required>
                            @error('shipping_city') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium mb-1">Phone Number *</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full bg-gray-700 border-gray-600 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 text-white" required>
                            @error('phone') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-indigo-500/20">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
