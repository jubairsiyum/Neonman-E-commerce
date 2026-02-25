<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Place a new order
     */
    public function placeOrder(Request $request)
    {
        $cartItems = Cart::getContent();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:500',
            'division'       => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'area'           => 'required|string|max:100',
            'postcode'       => 'nullable|string|max:20',
            'notes'          => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cod,bkash',
        ]);

        // Calculate totals
        $subtotal = Cart::getSubTotal();
        $shippingCharge = $subtotal >= 2000 ? 0 : 100;

        // Coupon discount
        $discount = 0;
        $couponId = null;
        $couponCode = null;

        if ($couponSession = session('coupon')) {
            $discount = $couponSession['discount'] ?? 0;
            $couponId = $couponSession['id'] ?? null;
            $couponCode = $couponSession['code'] ?? null;
        }

        $total = max(0, $subtotal - $discount + $shippingCharge);

        DB::beginTransaction();
        try {
            // Verify stock for all items
            foreach ($cartItems as $item) {
                $product = Product::find($item->id);
                if (!$product || !$product->is_active) {
                    DB::rollBack();
                    return redirect()->route('cart')->with('error', "Product \"{$item->name}\" is no longer available.");
                }
                if ($product->stock_quantity < $item->quantity) {
                    DB::rollBack();
                    return redirect()->route('cart')->with('error', "Insufficient stock for \"{$item->name}\".");
                }
            }

            // Create order
            $order = Order::create([
                'user_id'              => auth()->id(),
                'guest_name'           => $validated['first_name'] . ' ' . $validated['last_name'],
                'guest_email'          => $validated['email'],
                'guest_phone'          => $validated['phone'],
                'shipping_address'     => $validated['address'] . ', ' . $validated['area'],
                'shipping_district'    => $validated['city'],
                'shipping_division'    => $validated['division'],
                'shipping_postal_code' => $validated['postcode'] ?? '',
                'shipping_phone'       => $validated['phone'],
                'subtotal'             => $subtotal,
                'discount'             => $discount,
                'shipping_charge'      => $shippingCharge,
                'tax'                  => 0,
                'total'                => $total,
                'payment_method'       => $validated['payment_method'],
                'payment_status'       => Order::PAYMENT_PENDING,
                'status'               => Order::STATUS_PENDING,
                'notes'                => $validated['notes'] ?? null,
                'coupon_id'            => $couponId,
                'coupon_code'          => $couponCode,
            ]);

            // Create order items & decrement stock
            foreach ($cartItems as $item) {
                $variantDetails = [];
                if (!empty($item->attributes['size'])) {
                    $variantDetails['size'] = $item->attributes['size'];
                }
                if (!empty($item->attributes['color'])) {
                    $variantDetails['color'] = $item->attributes['color'];
                }

                OrderItem::create([
                    'order_id'        => $order->id,
                    'product_id'      => $item->id,
                    'product_name'    => $item->name,
                    'variant_details' => !empty($variantDetails) ? json_encode($variantDetails) : null,
                    'price'           => $item->price,
                    'quantity'        => $item->quantity,
                    'total'           => $item->price * $item->quantity,
                ]);

                // Decrement stock
                Product::where('id', $item->id)->decrement('stock_quantity', $item->quantity);
            }

            // Increment coupon usage
            if ($couponId) {
                Coupon::where('id', $couponId)->increment('used_count');
            }

            DB::commit();

            // Clear cart & coupon session
            Cart::clear();
            session()->forget('coupon');

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Your order has been placed successfully!');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('checkout')->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Order success page
     */
    public function success(string $orderNumber)
    {
        // Allow guest access too – just find by order number
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // If logged in, make sure the order belongs to the user OR user is guest
        if (auth()->check() && $order->user_id && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
}
