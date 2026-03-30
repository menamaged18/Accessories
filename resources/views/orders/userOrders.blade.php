<x-app-layout>
    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-white tracking-tight">My Orders</h2>
                    <p class="mt-2 text-sm text-gray-400">Manage your recent purchases and track status.</p>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 overflow-hidden shadow-xl sm:rounded-2xl">

                @if($orders->isEmpty())
                    <div class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-700/50 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-white">No orders yet</h3>
                        <p class="mt-2 text-gray-400 max-w-sm mx-auto">Looks like you haven't placed any orders yet. Start shopping to see your history here.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                            <tr class="border-b border-gray-700/50">
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700/50">
                            @foreach($orders as $order)
                                <tr class="group hover:bg-gray-700/30 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-mono text-gray-300">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="text-sm text-gray-300">{{ $order->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-bold text-white">${{ number_format($order->total_price, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-white text-center">
                                        @php
                                            $isCompleted = $order->status->value === 'completed';
                                            $badgeClass = $isCompleted
                                                ? 'bg-emerald-500/10 text-emerald-400 dark:text-emerald-400 border-emerald-500/20'
                                                : 'bg-amber-500/10 text-amber-400 dark:text-amber-400 border-amber-500/20';
                                        @endphp
                                        <span class="inline-flex items-center px-4 py-0.5 rounded-full text-xs font-medium border {{ $badgeClass }}">
                                                <span class="w-1.5 h-1.5 mr-1.5 rounded-full {{ $isCompleted ? 'bg-emerald-400 dark:bg-emerald-400' : 'bg-amber-400 dark:bg-amber-400' }}"></span>
                                                {{ $order->status->label() }}
                                            </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white dark:text-blue-400 bg-blue-500/10 rounded-lg hover:bg-blue-500/20 dark:hover:text-blue-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                                            View Details
                                            <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                @endif
            </div>
        </div>
    </div>
</x-app-layout>
