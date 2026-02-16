<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
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

        // Prepare cart item attributes
        $attributes = [
            'image' => $product->getFirstMediaUrl('images', 'thumb') ?: asset('images/placeholder.png'),
            'slug' => $product->slug,
        ];

        if ($request->size) {
            $attributes['size'] = $request->size;
        }

        if ($request->color) {
            $attributes['color'] = $request->color;
        }

        // Add to cart
        Cart::add(
            $product->id,
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
        $product = Product::find($cartItem->id);
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

        // Check minimum amount
        if ($coupon->minimum_amount && Cart::getSubTotal() < $coupon->minimum_amount) {
            return response()->json([
                'success' => false,
                'message' => "Minimum cart amount required: ৳{$coupon->minimum_amount}"
            ], 400);
        }

        // Calculate discount
        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = (Cart::getSubTotal() * $coupon->value) / 100;
            if ($coupon->max_discount) {
                $discount = min($discount, $coupon->max_discount);
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
