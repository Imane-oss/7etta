<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Add a product to the session-based cart.
     */
    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        $id = $product->product_id;

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name_product,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_url,
                "size" => $request->input('size'),
                "color" => $request->input('color')
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
}
