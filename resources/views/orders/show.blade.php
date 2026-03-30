<x-app-layout>
    <div class="py-12 bg-gray-900 min-h-screen text-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-white">Order Details</h1>
                    <p class="mt-1 text-sm text-gray-400">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                @if(Auth::check() && !Auth::user()->isAdmin())
                    <a href="{{ route('orders.userOrders') }}" class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Orders
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column: Order Summary & Info -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Status Card -->
                    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Order Status</h3>
                        @php
                            $statusColor = match($order->status->value) {
                                'completed' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                'processing' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                'shipped' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                default => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                            };
                            $dotColor = match($order->status->value) {
                                'completed' => 'bg-emerald-400',
                                'processing' => 'bg-blue-400',
                                'shipped' => 'bg-indigo-400',
                                default => 'bg-amber-400',
                            };
                        @endphp
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusColor }}">
                                <span class="w-2 h-2 mr-2 rounded-full {{ $dotColor }}"></span>
                                {{ $order->status->label() }}
                            </span>
                        </div>
                    </div>

                    <!-- Details Card -->
                    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-6 shadow-lg">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Order Information
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Total Amount</p>
                                <p class="text-2xl font-bold text-white">${{ number_format($order->total_price, 2) }}</p>
                            </div>

                            <div class="border-t border-gray-700 pt-4">
                                <p class="text-xs text-gray-500 uppercase mb-1">Shipping Address</p>
                                <p class="text-sm text-gray-300 leading-relaxed">
                                    {{ $order->shipping_address }}<br>
                                    {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}
                                </p>
                            </div>

                            <div class="border-t border-gray-700 pt-4">
                                <p class="text-xs text-gray-500 uppercase mb-1">Contact</p>
                                <p class="text-sm text-gray-300">{{ $order->phone }}</p>
                            </div>

                            <div class="border-t border-gray-700 pt-4">
                                <p class="text-xs text-gray-500 uppercase mb-1">Placed On</p>
                                <p class="text-sm text-gray-300">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Items List -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl shadow-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                Order Items
                            </h3>
                            <span class="text-sm text-gray-400">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-900/50 text-xs uppercase text-gray-400 font-semibold">
                                <tr>
                                    <th class="px-6 py-4">Product</th>
                                    <th class="px-6 py-4 text-center">Price</th>
                                    <th class="px-6 py-4 text-center">Qty</th>
                                    <th class="px-6 py-4 text-right">Total</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700/50">
                                @foreach($order->items as $item)
                                    <tr class="group hover:bg-gray-700/20 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center">
                                                <div class="h-8 w-8 flex-shrink-0 overflow-hidden rounded-lg border border-gray-600 bg-gray-700">
                                                    @if($item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                                    @else
                                                        <div class="h-full w-full flex items-center justify-center text-gray-500">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-white">{{ $item->product->name }}</div>
                                                    <div class="text-xs text-gray-500 mt-0.5">SKU: #{{ $item->product->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-sm text-gray-300">${{ number_format($item->price, 2) }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-700 text-gray-300">
                                                    {{ $item->quantity }}
                                                </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="text-sm font-bold text-white">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot class="bg-gray-900/30">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-400">Grand Total</td>
                                    <td class="px-6 py-4 text-right text-lg font-bold text-emerald-400">${{ number_format($order->total_price, 2) }}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
