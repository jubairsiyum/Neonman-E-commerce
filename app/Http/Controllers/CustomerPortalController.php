<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerPortalController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $ordersQuery = $user->orders();

        $recentOrders = $user->orders()
            ->withCount('items')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_orders' => (clone $ordersQuery)->count(),
            'pending_orders' => (clone $ordersQuery)->whereIn('status', ['pending', 'paid', 'processing'])->count(),
            'wishlist_count' => $user->wishlists()->count(),
            'total_spent' => (clone $ordersQuery)->whereIn('status', ['delivered', 'completed'])->sum('total'),
        ];

        return view('customer.dashboard', compact('recentOrders', 'stats'));
    }

    public function orders(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'in:pending,paid,processing,shipped,delivered,completed,cancelled'],
        ]);

        $orders = $request->user()
            ->orders()
            ->with(['items.product'])
            ->when(!empty($validated['search']), function ($query) use ($validated) {
                $search = trim($validated['search']);
                $query->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                        ->orWhere('id', $search);
                });
            })
            ->when(!empty($validated['status']), fn ($query) => $query->where('status', $validated['status']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('customer.orders', compact('orders'));
    }

    public function showOrder(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $order->load(['items.product']);

        return view('customer.order-detail', compact('order'));
    }

    public function cancelOrder(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'This order can no longer be cancelled.');
        }

        $order->update([
            'status' => Order::STATUS_CANCELLED,
        ]);

        return back()->with('status', 'Order cancelled successfully.');
    }

    public function wishlist(Request $request): View
    {
        if (!$request->user()) {
            return view('wishlist');
        }

        $products = Product::query()
            ->where('is_active', true)
            ->whereIn('id', $request->user()->wishlists()->pluck('product_id'))
            ->with('category')
            ->latest()
            ->get();

        return view('customer.wishlist', compact('products'));
    }

    public function profile(Request $request): View
    {
        return view('customer.profile', [
            'user' => $request->user(),
        ]);
    }

    public function trackOrder(Request $request): View
    {
        if (!$request->user()) {
            return view('track-order');
        }

        $validated = $request->validate([
            'order' => ['nullable', 'string', 'max:100'],
        ]);

        $matchingOrder = null;
        if (!empty($validated['order'])) {
            $search = trim($validated['order']);
            $matchingOrder = $request->user()
                ->orders()
                ->where(function ($query) use ($search) {
                    $query->where('order_number', 'like', "%{$search}%")
                        ->orWhere('id', $search);
                })
                ->latest()
                ->first();
        }

        $latestOrders = $request->user()
            ->orders()
            ->latest()
            ->take(5)
            ->get();

        return view('customer.track-order', compact('matchingOrder', 'latestOrders'));
    }
}
