<x-app-layout>
    <div class="py-12 bg-gray-900 min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-white">All Orders</h1>
                    <p class="mt-1 text-sm text-gray-400">Manage and track all customer orders.</p>
                </div>
                <div class="flex gap-3">
                    <!-- Example Stats Badge -->
                    <div class="bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-center">
                        <span class="block text-xs text-gray-400 uppercase">Total Orders</span>
                        <span class="block text-xl font-bold text-emerald-400">{{ $orders->total() }}</span>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 overflow-hidden shadow-xl sm:rounded-2xl">

                @if($orders->isEmpty())
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-300">No orders found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by waiting for customers to place orders.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-900/50 text-xs uppercase text-gray-400 font-semibold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Order ID</th>
                                <th class="px-6 py-4">Customer</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700/50">
                            @foreach($orders as $order)
                                <tr class="group hover:bg-gray-700/30 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-mono text-gray-300">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex-col items-center">
                                            <div class="text-sm font-medium text-white">{{ $order->user->name ?? 'Guest User' }}</div>
                                            <div class="text-xs text-gray-500">{{ $order->user->email ?? 'N/A' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="text-sm text-gray-300">{{ $order->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                    </td>
                                    {{-- Order Status --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-black">
                                        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="inline-flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="bg-white dark:!bg-gray-700  text-gray-900 dark:!text-white rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500 block py-2 px-6">
                                                @foreach(\App\Enums\OrderStatus::cases() as $status)
                                                    <option value="{{ $status->value }}"
                                                            class="bg-gray-800 text-white "
                                                        {{ $order->status === $status ? 'selected' : '' }}>
                                                        {{ $status->label() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="text-xs bg-indigo-600 hover:bg-indigo-700 text-white px-2 py-1 rounded">Update</button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-bold text-white">${{ number_format($order->total_price, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-400 bg-blue-500/10 rounded-lg hover:bg-blue-500/20 hover:text-blue-300 transition-all duration-200">
                                            View
                                            <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-700/50">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
