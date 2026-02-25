<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function shop(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', true);

        // Category filter
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereHas('category', function($q) use ($request) {
                $q->whereIn('slug', $request->categories);
            });
        }

        // Price filter
        if ($request->has('price')) {
            switch($request->price) {
                case '0-500':
                    $query->where('price', '<=', 500);
                    break;
                case '500-1000':
                    $query->whereBetween('price', [500, 1000]);
                    break;
                case '1000-2000':
                    $query->whereBetween('price', [1000, 2000]);
                    break;
                case '2000+':
                    $query->where('price', '>=', 2000);
                    break;
            }
        }

        // Stock filter
        if ($request->has('in_stock')) {
            $query->where('in_stock', true);
        }

        // Featured filter
        if ($request->has('featured')) {
            $query->where('is_featured', true);
        }

        // Sorting
        switch($request->get('sort', 'latest')) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        return view('shop', compact('products'));
    }

    public function product($slug)
    {
        $product = Product::with(['category', 'variants'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related products from same category
        $relatedProducts = Product::with('category')
            ->where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('product', compact('product', 'relatedProducts'));
    }

    public function newArrivals()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->where('is_new_arrival', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('new-arrivals', compact('products'));
    }

    public function bestSellers()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->where('is_best_seller', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('best-sellers', compact('products'));
    }
}
