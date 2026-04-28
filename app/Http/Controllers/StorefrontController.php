<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class StorefrontController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::query()->latest('created_at')->take(8)->get();

        return view('index', [
            'categories' => Category::with(['products' => fn($q) => $q->latest('created_at')->take(4)])->get(),
            'featuredProducts' => $featuredProducts,
            'heroProduct' => $featuredProducts->first(),
        ]);
    }

    public function caps(): View
    {
        return $this->categoryPage('Caps', 'caps', 'Top off every outfit with clean streetwear energy.');
    }

    public function tshirts(): View
    {
        return $this->categoryPage('Tshirts', 'tshirts', 'Everyday essentials built for easy layering.');
    }

    public function hoodies(): View
    {
        return $this->categoryPage('Hoodies', 'hoodies', 'Comfort-first pieces made for casual rotation.');
    }

    public function pants(): View
    {
        return $this->categoryPage('Pants', 'pants', 'Balanced fits for movement, utility, and style.');
    }

    public function shoes(): View
    {
        return $this->categoryPage('Shoes', 'shoes', 'Finish the look with dependable staples and standouts.');
    }

    public function profile(): View
    {
        return view('profile', [
            'customer' => auth()->user()?->customer,
        ]);
    }

    public function settings(): View
    {
        return view('settings', [
            'customer' => auth()->user()?->customer,
        ]);
    }

    private function categoryPage(string $categoryName, string $view, string $description): View
    {
        $category = Category::query()
            ->whereRaw('LOWER(name) = ?', [strtolower($categoryName)])
            ->first();

        return view($view, [
            'category' => $category,
            'description' => $description,
            'products' => Product::query()
                ->when($category, fn ($query) => $query->where('category_id', $category->category_id))
                ->latest('created_at')
                ->get(),
        ]);
    }
}
