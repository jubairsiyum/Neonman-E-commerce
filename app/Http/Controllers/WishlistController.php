<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Toggle product in wishlist
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = $request->product_id;
        $wishlist = session('wishlist', []);

        if (in_array($productId, $wishlist)) {
            // Remove from wishlist
            $wishlist = array_diff($wishlist, [$productId]);
            $message = 'Removed from wishlist';
            $inWishlist = false;
        } else {
            // Add to wishlist
            $wishlist[] = $productId;
            $message = 'Added to wishlist!';
            $inWishlist = true;
        }

        session(['wishlist' => array_values($wishlist)]);

        return response()->json([
            'success' => true,
            'message' => $message,
            'in_wishlist' => $inWishlist,
            'wishlist_count' => count($wishlist)
        ]);
    }

    /**
     * Remove specific item from wishlist
     */
    public function remove($productId)
    {
        $wishlist = session('wishlist', []);
        $wishlist = array_diff($wishlist, [$productId]);
        session(['wishlist' => array_values($wishlist)]);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from wishlist.',
            'wishlist_count' => count($wishlist)
        ]);
    }

    /**
     * Clear entire wishlist
     */
    public function clear()
    {
        session()->forget('wishlist');

        return response()->json([
            'success' => true,
            'message' => 'Wishlist cleared successfully.',
            'wishlist_count' => 0
        ]);
    }

    /**
     * Move item from wishlist to cart
     */
    public function moveToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if (!$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This product is not available.'
            ], 400);
        }

        if ($product->stock_quantity < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock.'
            ], 400);
        }

        // Add to cart using CartController
        $request->merge(['product_id' => $productId, 'quantity' => 1]);
        $cartController = new CartController();
        $cartResponse = $cartController->add($request);

        if ($cartResponse->getData()->success) {
            // Remove from wishlist
            $wishlist = session('wishlist', []);
            $wishlist = array_diff($wishlist, [$productId]);
            session(['wishlist' => array_values($wishlist)]);

            return response()->json([
                'success' => true,
                'message' => 'Product moved to cart successfully!',
                'wishlist_count' => count($wishlist),
                'cart_count' => $cartResponse->getData()->cart_count
            ]);
        }

        return $cartResponse;
    }
}
