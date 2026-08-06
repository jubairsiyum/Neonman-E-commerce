<?php

namespace App\Http\Controllers;

use App\Models\DeliveryZone;
use App\Models\Product;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
    /**
     * Get cart data as JSON (for sidebar/AJAX)
     */
    public function data()
    {
        $items = Cart::getContent()->map(function ($item) {
            $product = \App\Models\Product::find($item->attributes->get('product_id'));
            return [
                'id' => $item->id,
                'name' => $item->name,
                'price' => (float) $item->price,
                'quantity' => (int) $item->quantity,
                'attributes' => [
                    'slug' => $item->attributes->get('slug') ?? $product?->slug ?? '#',
                    'image' => $item->attributes->get('image') ?? ($product && $product->hasMedia('images') ? $product->getFirstMediaUrl('images') : asset('images/placeholder-product.jpg')),
                    'size' => $item->attributes->get('size'),
                    'color' => $item->attributes->get('color'),
                ],
            ];
        });

        $subTotal = (float) Cart::getSubTotal();
        $deliveryZones = DeliveryZone::active()->get()->map(fn ($zone) => [
            'id' => $zone->id,
            'name' => $zone->name,
            'charge' => (float) $zone->charge,
            'free_shipping_threshold' => $zone->free_shipping_threshold ? (float) $zone->free_shipping_threshold : null,
        ]);
        $selectedZoneId = session('delivery_zone_id', $deliveryZones->isNotEmpty() ? $deliveryZones->first()['id'] : null);
        $selectedZone = $deliveryZones->firstWhere('id', $selectedZoneId) ?? $deliveryZones->first();
        $shippingFee = $selectedZone
            ? (($selectedZone['free_shipping_threshold'] && $subTotal >= $selectedZone['free_shipping_threshold']) ? 0 : $selectedZone['charge'])
            : 0;
        $discount = session('coupon.discount', 0);
        $total = $subTotal + $shippingFee - $discount;

        return response()->json([
            'items' => $items->values(),
            'item_count' => $items->sum('quantity'),
            'sub_total' => $subTotal,
            'shipping_fee' => $shippingFee,
            'discount' => $discount,
            'total' => $total,
            'coupon_code' => session('coupon.code'),
            'delivery_zones' => $deliveryZones,
            'selected_zone_id' => $selectedZoneId,
        ]);
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $product = Product::with('media')->findOrFail($request->product_id);

        // Check if product is active
        if (!$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This product is not available.'
            ], 400);
        }

        // Check stock
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available.'
            ], 400);
        }

        // Build unique cart ID from product + variants to allow separate line items
        $cartId = (string) $product->id;
        if ($request->size) {
            $cartId .= '-' . $request->size;
        }
        if ($request->color) {
            $cartId .= '-' . $request->color;
        }

        // Prepare cart item attributes
        $attributes = [
            'product_id' => $product->id,
            'image' => $product->getFirstMediaUrl('images', 'thumb') ?: asset('images/placeholder.png'),
            'slug' => $product->slug,
        ];

        if ($request->size) {
            $attributes['size'] = $request->size;
        }

        if ($request->color) {
            $attributes['color'] = $request->color;
        }

        // Add to cart with unique composite ID
        Cart::add(
            $cartId,
            $product->name,
            $product->effective_price,
            $request->quantity,
            $attributes
        );

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => Cart::getContent()->count(),
            'cart_total' => Cart::getTotal()
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::get($id);
        
        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.'
            ], 404);
        }

        // Check stock
        $product = Product::find($cartItem->attributes->get('product_id'));
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available.'
            ], 400);
        }

        Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'cart_count' => Cart::getContent()->count(),
            'cart_total' => Cart::getTotal(),
            'item_total' => $cartItem->price * $request->quantity
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        Cart::remove($id);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart_count' => Cart::getContent()->count(),
            'cart_total' => Cart::getTotal()
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        Cart::clear();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully.',
            'cart_count' => 0,
            'cart_total' => 0
        ]);
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = \App\Models\Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code.'
            ], 400);
        }

        // Check usage limit
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon usage limit reached.'
            ], 400);
        }

        // Check minimum purchase
        if ($coupon->minimum_purchase && Cart::getSubTotal() < $coupon->minimum_purchase) {
            return response()->json([
                'success' => false,
                'message' => "Minimum cart amount required: ৳{$coupon->minimum_purchase}"
            ], 400);
        }

        // Calculate discount
        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = (Cart::getSubTotal() * $coupon->value) / 100;
            if ($coupon->maximum_discount) {
                $discount = min($discount, $coupon->maximum_discount);
            }
        } else {
            $discount = $coupon->value;
        }

        // Store coupon in session
        session([
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'discount' => $discount,
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => $discount,
            'new_total' => Cart::getSubTotal() - $discount
        ]);
    }

    /**
     * Remove applied coupon
     */
    public function removeCoupon()
    {
        session()->forget('coupon');

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed.',
            'cart_total' => Cart::getTotal()
        ]);
    }
}
