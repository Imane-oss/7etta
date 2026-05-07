@extends('admin.layout')

@section('title', 'Orders Management')

@section('content')
<div x-data="{ detailsModalOpen: false, selectedOrder: null }">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Orders Management</h1>
        
        <form method="GET" action="{{ route('admin.orders') }}" class="relative w-64">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search orders..." class="w-full border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-white">
            <i class="bi bi-search absolute left-3 top-2.5 text-gray-400"></i>
        </form>
    </div>

    @if(session('success'))
    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-md shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- Orders Table -->
    <div class="glass-card overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="p-4 pl-6">Order ID</th>
                    <th class="p-4">Customer</th>
                    <th class="p-4">Date</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 pr-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 pl-6">
                        <span class="text-blue-600 font-medium text-sm">#ORD-{{ $order->order_id }}</span>
                    </td>
                    <td class="p-4">
                        <span class="font-medium text-gray-900 text-sm">{{ $order->customer->full_name ?? 'N/A' }}</span>
                    </td>
                    <td class="p-4 text-sm text-gray-600">
                        {{ $order->order_date ? $order->order_date->format('M d, Y') : 'N/A' }}
                    </td>
                    <td class="p-4">
                        <span class="font-bold text-gray-900 text-sm">${{ number_format($order->total_amount, 2) }}</span>
                    </td>
                    <td class="p-4">
                        <form action="{{ route('admin.orders.status', $order->order_id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            @php
                                $statusColors = [
                                    'Delivered' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'Shipped' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'Pending' => 'bg-orange-100 text-orange-800 border-orange-200',
                                    'Processing' => 'bg-purple-100 text-purple-800 border-purple-200',
                                ];
                                $currentColorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                            @endphp
                            <select name="status" onchange="this.form.submit()" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border shadow-sm cursor-pointer focus:outline-none appearance-none {{ $currentColorClass }}" style="padding-right: 1.5rem; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right .7rem top 50%; background-size: .65rem auto;">
                                <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Processing" {{ $order->status === 'Processing' ? 'selected' : '' }}>Processing</option>
                                <option value="Shipped" {{ $order->status === 'Shipped' ? 'selected' : '' }}>Shipped 🚚</option>
                                <option value="Delivered" {{ $order->status === 'Delivered' ? 'selected' : '' }}>Delivered ✓</option>
                            </select>
                        </form>
                    </td>
                    <td class="p-4 pr-6 text-right">
                        @php
                            $orderData = [
                                'id' => '#ORD-' . $order->order_id,
                                'customer_name' => $order->customer->full_name ?? 'N/A',
                                'customer_email' => $order->customer->email_customer ?? 'N/A',
                                'customer_phone' => $order->customer->phone_customer ?? 'N/A',
                                'shipping_address' => $order->shipping_address ?? 'N/A',
                                'items' => $order->lines->map(function($line) {
                                    return [
                                        'name' => $line->product->name_product ?? 'Unknown Product',
                                        'qty' => $line->quantity,
                                        'price' => number_format($line->unit_price, 2)
                                    ];
                                })->toArray(),
                                'total' => number_format($order->total_amount, 2)
                            ];
                        @endphp
                        <button @click="selectedOrder = {{ htmlspecialchars(json_encode($orderData)) }}; detailsModalOpen = true" class="text-sm text-blue-600 hover:text-blue-800 transition-colors bg-blue-50 hover:bg-blue-100 border border-blue-100 rounded px-3 py-1 font-medium shadow-sm">Details</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">
                        No orders found matching "{{ request('search') }}".
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($orders->hasPages())
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            {{ $orders->links() }}
        </div>
        @endif
    </div>

    <!-- Order Details Modal -->
    <div x-show="detailsModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <!-- Background overlay -->
            <div x-show="detailsModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="detailsModalOpen = false" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="detailsModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-gray-100" style="max-width: 800px;">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 relative">
                    <!-- Close button -->
                    <button @click="detailsModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                        <i class="bi bi-x-lg text-lg"></i>
                    </button>

                    <!-- Header -->
                    <div class="mb-8">
                        <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title">
                            Order Details <span class="text-blue-600" x-text="selectedOrder?.id"></span>
                        </h3>
                    </div>

                    <div class="grid grid-cols-2 gap-8 mb-8 text-sm">
                        <!-- Customer Info -->
                        <div>
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Customer Info</h4>
                            <div class="space-y-1">
                                <p class="font-bold text-gray-900 text-base" x-text="selectedOrder?.customer_name"></p>
                                <p class="text-gray-600 flex items-center mt-2">
                                    <i class="bi bi-envelope-fill mr-2 text-gray-400"></i>
                                    <span x-text="selectedOrder?.customer_email"></span>
                                </p>
                                <p class="text-gray-600 flex items-center">
                                    <i class="bi bi-telephone-fill mr-2 text-gray-400"></i>
                                    <span x-text="selectedOrder?.customer_phone"></span>
                                </p>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="text-right">
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Shipping Address</h4>
                            <p class="text-gray-700 whitespace-pre-line leading-relaxed" x-text="selectedOrder?.shipping_address"></p>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div>
                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Order Items</h4>
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-100">
                            <table class="w-full text-left text-sm mb-4">
                                <thead>
                                    <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                        <th class="pb-3">Item</th>
                                        <th class="pb-3 text-center">Qty</th>
                                        <th class="pb-3 text-right">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <template x-for="item in selectedOrder?.items" :key="item.name">
                                        <tr>
                                            <td class="py-3 font-medium text-gray-900" x-text="item.name"></td>
                                            <td class="py-3 text-center text-gray-600" x-text="item.qty"></td>
                                            <td class="py-3 text-right font-medium text-gray-900" x-text="'$' + item.price"></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            <div class="border-t border-gray-200 pt-4 flex justify-between items-center">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total:</span>
                                <span class="text-xl font-bold text-blue-600" x-text="'$' + selectedOrder?.total"></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
