<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\DeliveryZone;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Payment\PaymentGatewayManager;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'required|string|max:100',
            'email'            => 'required|email|max:255',
            'phone'            => 'required|string|max:20',
            'address'          => 'required|string|max:500',
            'division'         => 'required|string|max:100',
            'city'             => 'required|string|max:100',
            'area'             => 'required|string|max:100',
            'postcode'         => 'nullable|string|max:20',
            'delivery_zone_id' => 'required|exists:delivery_zones,id',
            'notes'            => 'nullable|string|max:1000',
            'payment_method'   => 'required|in:cod,bkash',
        ]);

        // Calculate totals
        $subtotal = Cart::getSubTotal();
        $deliveryZone = DeliveryZone::findOrFail($validated['delivery_zone_id']);
        $shippingCharge = $deliveryZone->calculateShipping($subtotal);

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
        $isBkash = $validated['payment_method'] === 'bkash';

        // For bKash: verify gateway is available BEFORE creating order
        if ($isBkash) {
            if (!PaymentGatewayManager::isAvailable('bkash')) {
                return redirect()->route('checkout')
                    ->with('error', 'bKash payment is currently unavailable. Please choose Cash on Delivery or try again later.');
            }
        }

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
                'delivery_zone_id'     => $deliveryZone->id,
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

            // bKash — initiate payment and redirect to bKash page
            if ($isBkash) {
                try {
                    $gateway = PaymentGatewayManager::resolve('bkash');
                    $result = $gateway->createPayment($order);

                    if ($result['success'] && isset($result['redirect_url'])) {
                        return redirect()->away($result['redirect_url']);
                    }

                    // Gateway failed — order exists but unpaid, redirect to payment page
                    Log::warning('bKash create payment failed', [
                        'order' => $order->order_number,
                        'result' => $result,
                    ]);

                    return redirect()->route('checkout.payment-pending', $order->order_number)
                        ->with('error', 'Could not connect to bKash. Please try paying again or choose a different method.');

                } catch (\Exception $e) {
                    Log::error('bKash payment initiation exception', [
                        'order' => $order->order_number,
                        'error' => $e->getMessage(),
                    ]);

                    return redirect()->route('checkout.payment-pending', $order->order_number)
                        ->with('error', 'bKash payment service is currently unavailable. Please try again later.');
                }
            }

            // COD — direct success
            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Your order has been placed successfully!');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Order placement failed', ['error' => $e->getMessage()]);
            return redirect()->route('checkout')->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Order success page
     */
    public function success(string $orderNumber)
    {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        if (auth()->check() && $order->user_id && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Payment pending page — for bKash orders waiting for payment
     */
    public function paymentPending(string $orderNumber)
    {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('checkout.payment-pending', compact('order'));
    }

    /**
     * Retry bKash payment for an existing unpaid order
     */
    public function retryBkashPayment(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('payment_status', Order::PAYMENT_PENDING)
            ->firstOrFail();

        if (!PaymentGatewayManager::isAvailable('bkash')) {
            return redirect()->route('checkout.payment-pending', $order->order_number)
                ->with('error', 'bKash is currently unavailable.');
        }

        try {
            $gateway = PaymentGatewayManager::resolve('bkash');
            $result = $gateway->createPayment($order);

            if ($result['success'] && isset($result['redirect_url'])) {
                return redirect()->away($result['redirect_url']);
            }

            return redirect()->route('checkout.payment-pending', $order->order_number)
                ->with('error', 'Could not connect to bKash. Please try again.');

        } catch (\Exception $e) {
            Log::error('bKash retry payment failed', [
                'order' => $order->order_number,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('checkout.payment-pending', $order->order_number)
                ->with('error', 'bKash payment service is currently unavailable.');
        }
    }
}
