<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Real data from database
        $totalSales = Order::sum('total_amount') ?? 0;
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalProducts = Product::count();

        $topProducts = Product::with('category')->take(5)->get()->map(function($product) {
            return (object)[
                'name_product' => $product->name_product,
                'category' => $product->category ? $product->category->name : 'Uncategorized',
                'price' => $product->price
            ];
        });

        // Real data for chart (Last 7 months)
        $orders = Order::whereNotNull('order_date')
                    ->where('order_date', '>=', now()->subMonths(6)->startOfMonth())
                    ->get();
        
        $salesByMonth = collect();
        for ($i = 6; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('M');
            $salesByMonth->push((object)[
                'month' => $month,
                'total' => $orders->filter(function($order) use ($month) {
                    return Carbon::parse($order->order_date)->format('M') === $month;
                })->sum('total_amount')
            ]);
        }

        return view('admin.dashboard', compact('totalSales', 'totalOrders', 'totalUsers', 'totalProducts', 'topProducts', 'salesByMonth'));
    }

    public function products()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name_product' => 'required|string|max:255',
            'category_id' => 'required|exists:Category,category_id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name_product', 'category_id', 'price', 'stock_quantity']);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        Product::create($data);

        return redirect()->route('admin.products')->with('success', 'Product added successfully.');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name_product' => 'required|string|max:255',
            'category_id' => 'required|exists:Category,category_id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name_product', 'category_id', 'price', 'stock_quantity']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
            
            if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $product->image_url));
            }
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->image_url));
        }

        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:Category,name',
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.products')->with('success', 'Category added successfully.');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->count() > 0) {
            return redirect()->route('admin.products')->with('error', 'Cannot delete category because it contains products.');
        }

        $category->delete();

        return redirect()->route('admin.products')->with('success', 'Category deleted successfully.');
    }

    public function users(Request $request)
    {
        $search = $request->query('search');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    public function orders(Request $request)
    {
        $search = $request->query('search');

        $query = Order::with(['customer', 'lines.product']);

        if ($search) {
            $query->where('order_id', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email_customer', 'like', "%{$search}%");
                  });
        }

        $orders = $query->latest('order_date')->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders', 'search'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:Pending,Processing,Shipped,Delivered',
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
