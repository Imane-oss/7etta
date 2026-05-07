<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display the product detail page.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'variants', 'reviews']);

        // Get related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('product_id', '!=', $product->product_id)
            ->latest('created_at')
            ->take(4)
            ->get();

        // If less than 4, fill with other latest products
        if ($relatedProducts->count() < 4) {
            $extra = Product::where('product_id', '!=', $product->product_id)
                ->whereNotIn('product_id', $relatedProducts->pluck('product_id'))
                ->latest('created_at')
                ->take(4 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->concat($extra);
        }

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
