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

    public function settings()
    {
        return view('admin.settings');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name_product' => 'required|string|max:255',
            'category_id' => 'required|exists:Category,category_id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_hover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_detail_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_detail_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name_product', 'category_id', 'price', 'stock_quantity']);
        
        $images = [
            'image' => 'image_url',
            'image_hover' => 'image_hover_url',
            'image_detail_1' => 'image_detail_1_url',
            'image_detail_2' => 'image_detail_2_url'
        ];
        
        foreach ($images as $input => $column) {
            if ($request->hasFile($input)) {
                $path = $request->file($input)->store('products', 'public');
                $data[$column] = '/storage/' . $path;
            }
        }

        // Add default values for mandatory fields if missing
        $data['color'] = $request->color ?? 'Default';
        $data['size'] = $request->size ?? 'Standard';
        $data['image_url'] = $data['image_url'] ?? '/images/default-product.png';

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
            'image_hover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_detail_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_detail_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name_product', 'category_id', 'price', 'stock_quantity']);

        $images = [
            'image' => 'image_url',
            'image_hover' => 'image_hover_url',
            'image_detail_1' => 'image_detail_1_url',
            'image_detail_2' => 'image_detail_2_url'
        ];
        
        foreach ($images as $input => $column) {
            if ($request->hasFile($input)) {
                $path = $request->file($input)->store('products', 'public');
                $data[$column] = '/storage/' . $path;
                
                if ($product->$column && str_starts_with($product->$column, '/storage/')) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $product->$column));
                }
            }
        }

        if ($request->has('color')) $data['color'] = $request->color;
        if ($request->has('size')) $data['size'] = $request->size;

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        
        $columns = ['image_url', 'image_hover_url', 'image_detail_1_url', 'image_detail_2_url'];
        foreach ($columns as $col) {
            if ($product->$col && str_starts_with($product->$col, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $product->$col));
            }
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

    public function makeAdmin($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role !== 'admin') {
            $user->update(['role' => 'admin']);
            return redirect()->back()->with('success', 'User role updated to admin successfully.');
        }

        return redirect()->back()->with('error', 'User is already an admin.');
    }

    public function toggleBan($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Cannot ban an admin.');
        }

        $user->update(['is_banned' => !$user->is_banned]);
        
        $message = $user->is_banned ? 'User has been banned successfully.' : 'User has been unbanned successfully.';
        return redirect()->back()->with('success', $message);
    }
}
