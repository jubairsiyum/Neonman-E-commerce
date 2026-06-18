@php
    $order = $record;
    $items = $order->items;

    $statusColors = [
        'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
        'paid' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        'processing' => 'bg-primary-100 text-primary-800 dark:bg-primary-900/30 dark:text-primary-400',
        'shipped' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
        'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    ];
    $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';

    $payStatusColors = [
        'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
        'failed' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    ];
    $payStatusColor = $payStatusColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800';

    $payBadgeColors = [
        'paid' => 'bg-green-100 text-green-800',
        'pending' => 'bg-amber-100 text-amber-800',
        'failed' => 'bg-red-100 text-red-800',
    ];
    $payBadgeColor = $payBadgeColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800';
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white font-display">
                Order {{ $order->order_number }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $statusColor }}">
                {{ ucfirst($order->status) }}
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $payStatusColor }}">
                {{ ucfirst($order->payment_status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Customer Information --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Customer Information</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Name</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Email</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order->customer_email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Phone</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Customer Type</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order->user ? 'Registered' : 'Guest' }}</p>
                    </div>
                </div>
            </div>

            {{-- Shipping Information --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Shipping Address</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Address</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order->shipping_address }}</p>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">District</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order->shipping_district }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Division</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order->shipping_division }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Postal Code</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order->shipping_postal_code ?: 'N/A' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Shipping Phone</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order->shipping_phone }}</p>
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Order Items ({{ $items->count() }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Product</th>
                                <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Variant</th>
                                <th class="text-center px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Qty</th>
                                <th class="text-right px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                                <th class="text-right px-6 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($items as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $item->product_name }}</p>
                                </td>
                                <td class="px-4 py-4 text-gray-600 dark:text-gray-400">
                                    {{ $item->variant_details ?: '-' }}
                                </td>
                                <td class="px-4 py-4 text-center text-gray-900 dark:text-white font-medium">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-4 py-4 text-right text-gray-600 dark:text-gray-400">
                                    ৳{{ number_format($item->price, 0) }}
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white">
                                    ৳{{ number_format($item->total, 0) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Notes --}}
            @if($order->notes || $order->admin_notes)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Notes</h3>
                </div>
                <div class="p-6 space-y-4">
                    @if($order->notes)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Customer Notes</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $order->notes }}</p>
                    </div>
                    @endif
                    @if($order->admin_notes)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Admin Notes</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $order->admin_notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Order Summary --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Order Summary</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Subtotal</span>
                        <span class="font-medium text-gray-900 dark:text-white">৳{{ number_format($order->subtotal, 0) }}</span>
                    </div>
                    @if($order->discount > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Discount</span>
                        <span class="font-medium text-green-600">-৳{{ number_format($order->discount, 0) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Shipping</span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ $order->shipping_charge > 0 ? '৳' . number_format($order->shipping_charge, 0) : 'FREE' }}
                        </span>
                    </div>
                    @if($order->tax > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Tax</span>
                        <span class="font-medium text-gray-900 dark:text-white">৳{{ number_format($order->tax, 0) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
                        <span class="font-bold text-gray-900 dark:text-white">Total</span>
                        <span class="text-xl font-bold text-primary-600 dark:text-primary-400">৳{{ number_format($order->total, 0) }}</span>
                    </div>
                </div>
            </div>

            {{-- Payment Information --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Payment</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Method</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white uppercase">{{ $order->payment_method }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $payBadgeColor }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    @if($order->payment_method === 'bkash')
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">bKash Transaction ID</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order->bkash_transaction_id ?: 'N/A' }}</p>
                    </div>
                    @if($order->bkash_proof_image)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Payment Proof</p>
                        <img src="{{ asset('storage/' . $order->bkash_proof_image) }}" alt="Payment Proof" class="w-full rounded-lg border border-gray-200 dark:border-gray-700">
                    </div>
                    @endif
                    @endif
                    @if($order->paid_at)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Paid At</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $order->paid_at->format('M d, Y h:i A') }}</p>
                    </div>
                    @endif
                    @if($order->coupon_code)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Coupon Used</p>
                        <p class="text-sm font-bold text-primary-600 dark:text-primary-400">{{ $order->coupon_code }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden p-6 space-y-3">
                <a href="{{ route('admin.orders.print-slip', $order->id) }}" target="_blank" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gray-900 dark:bg-white dark:text-gray-900 text-white text-sm font-bold rounded-lg hover:bg-primary-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Print Parcel Slip
                </a>
                <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-bold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Print Invoice
                </a>
            </div>
        </div>
    </div>
</div>
