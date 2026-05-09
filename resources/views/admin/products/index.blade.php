@extends('admin.layout')

@section('title', 'Products Management')

@section('content')
<div x-data="{ addProductModalOpen: false, manageCategoriesModalOpen: false, editProductModalOpen: false, editProduct: { id: '', name_product: '', category_id: '', price: '', stock_quantity: '', image_url: '', image_hover_url: '', image_detail_1_url: '', image_detail_2_url: '' } }">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Products Management</h1>
        <div class="flex space-x-3">
            <button @click="manageCategoriesModalOpen = true" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center shadow-sm">
                <i class="bi bi-list-ul mr-2"></i> Categories
            </button>
            <button @click="addProductModalOpen = true" class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center shadow-sm">
                <i class="bi bi-plus-lg mr-2"></i> Add Product
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Products Table -->
    <div class="glass-card overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="p-4 pl-6">Photo</th>
                    <th class="p-4">Product</th>
                    <th class="p-4">Category</th>
                    <th class="p-4">Price</th>
                    <th class="p-4">Stock</th>
                    <th class="p-4 pr-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 pl-6">
                        @if($product->image_url)
                        <img src="{{ url($product->image_url) }}" 
                             alt="{{ $product->name_product }}" 
                             class="w-12 h-12 rounded-lg object-cover shadow-sm border border-gray-100"
                             onerror="console.log('Failed to load image:', this.src); this.onerror=null; this.src='/images/logo.png';">
                        @else
                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 border border-dashed border-gray-200">
                            <i class="bi bi-image text-xl"></i>
                        </div>
                        @endif
                    </td>
                    <td class="p-4">
                        <span class="font-medium text-gray-900 text-sm">{{ $product->name_product }}</span>
                    </td>
                    <td class="p-4 text-sm text-gray-700">{{ $product->category ? $product->category->name : 'N/A' }}</td>
                    <td class="p-4 text-sm font-bold text-gray-900">${{ number_format($product->price, 2) }}</td>
                    <td class="p-4">
                        @if($product->stock_quantity > 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            In Stock ({{ $product->stock_quantity }})
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Out of Stock
                        </span>
                        @endif
                    </td>
                    <td class="p-4 pr-6 text-right space-x-2 flex justify-end">
                        <button @click="editProduct = { id: {{ $product->product_id }}, name_product: '{{ addslashes($product->name_product) }}', category_id: '{{ $product->category_id }}', price: '{{ $product->price }}', stock_quantity: '{{ $product->stock_quantity }}', image_url: '{{ $product->image_url }}', image_hover_url: '{{ $product->image_hover_url }}', image_detail_1_url: '{{ $product->image_detail_1_url }}', image_detail_2_url: '{{ $product->image_detail_2_url }}' }; editProductModalOpen = true" class="text-blue-500 hover:text-blue-700 transition-colors mr-2"><i class="bi bi-pencil-fill"></i></button>
                        <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Manage Categories Modal -->
    <div x-show="manageCategoriesModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="manageCategoriesModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="manageCategoriesModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="manageCategoriesModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Manage Categories</h3>
                        <button @click="manageCategoriesModalOpen = false" class="text-gray-400 hover:text-gray-500"><i class="bi bi-x-lg"></i></button>
                    </div>
                    
                    <form action="{{ route('admin.categories.store') }}" method="POST" class="flex mb-4">
                        @csrf
                        <input type="text" name="name" required placeholder="New category name..." class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
                        <button type="submit" class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-r-md text-sm font-medium transition-colors">Add</button>
                    </form>

                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @forelse($categories as $category)
                        <div class="flex justify-between items-center p-3 border border-gray-200 rounded-md">
                            <span class="text-sm text-gray-700">{{ $category->name }}</span>
                            <form action="{{ route('admin.categories.destroy', $category->category_id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700"><i class="bi bi-trash-fill"></i></button>
                            </form>
                        </div>
                        @empty
                        <div class="text-center text-sm text-gray-500 py-2">No categories yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Product Modal -->
    <div x-show="addProductModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="addProductModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="addProductModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="addProductModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Add New Product</h3>
                        <button @click="addProductModalOpen = false" class="text-gray-400 hover:text-gray-500"><i class="bi bi-x-lg"></i></button>
                    </div>
                    
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Product Name</label>
                                <input type="text" name="name_product" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Category</label>
                                <select name="category_id" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-white">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Price ($)</label>
                                <input type="number" step="0.01" name="price" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Stock Quantity</label>
                                <input type="number" name="stock_quantity" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-gray-50">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Product Images</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-1">Main Image</label>
                                    <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-1">Hover Image</label>
                                    <input type="file" name="image_hover" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-1">Detail Image 1</label>
                                    <input type="file" name="image_detail_1" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-1">Detail Image 2</label>
                                    <input type="file" name="image_detail_2" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-xl border-t border-gray-200">
                    <button type="submit" form="addProductForm" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black sm:ml-3 sm:w-auto sm:text-sm">
                        Save Product
                    </button>
                    <button type="button" @click="addProductModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div x-show="editProductModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="editProductModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="editProductModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="editProductModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Edit Product</h3>
                        <button @click="editProductModalOpen = false" class="text-gray-400 hover:text-gray-500"><i class="bi bi-x-lg"></i></button>
                    </div>
                    
                    <form :action="'{{ route('admin.products.update', '') }}/' + editProduct.id" method="POST" enctype="multipart/form-data" id="editProductForm">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Product Name</label>
                                <input type="text" name="name_product" x-model="editProduct.name_product" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Category</label>
                                <select name="category_id" x-model="editProduct.category_id" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-white">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Price ($)</label>
                                <input type="number" step="0.01" name="price" x-model="editProduct.price" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Stock Quantity</label>
                                <input type="number" name="stock_quantity" x-model="editProduct.stock_quantity" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-gray-50">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Product Images</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Main Image -->
                                <div class="flex items-center space-x-4">
                                    <template x-if="editProduct.image_url">
                                        <div class="relative">
                                            <img :src="editProduct.image_url.startsWith('http') || editProduct.image_url.startsWith('/') ? editProduct.image_url : '/' + editProduct.image_url" class="w-16 h-16 rounded-lg object-cover border border-gray-200 shadow-sm">
                                            <span class="absolute -top-2 -right-2 bg-gray-100 text-gray-500 rounded-full p-1 text-[10px] border border-gray-200">Main</span>
                                        </div>
                                    </template>
                                    <div class="flex-1">
                                        <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-1">Main Image</label>
                                        <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-gray-50">
                                    </div>
                                </div>
                                <!-- Hover Image -->
                                <div class="flex items-center space-x-4">
                                    <template x-if="editProduct.image_hover_url">
                                        <div class="relative">
                                            <img :src="editProduct.image_hover_url.startsWith('http') || editProduct.image_hover_url.startsWith('/') ? editProduct.image_hover_url : '/' + editProduct.image_hover_url" class="w-16 h-16 rounded-lg object-cover border border-gray-200 shadow-sm">
                                            <span class="absolute -top-2 -right-2 bg-gray-100 text-gray-500 rounded-full p-1 text-[10px] border border-gray-200">Hover</span>
                                        </div>
                                    </template>
                                    <div class="flex-1">
                                        <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-1">Hover Image</label>
                                        <input type="file" name="image_hover" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-gray-50">
                                    </div>
                                </div>
                                <!-- Detail Image 1 -->
                                <div class="flex items-center space-x-4">
                                    <template x-if="editProduct.image_detail_1_url">
                                        <div class="relative">
                                            <img :src="editProduct.image_detail_1_url.startsWith('http') || editProduct.image_detail_1_url.startsWith('/') ? editProduct.image_detail_1_url : '/' + editProduct.image_detail_1_url" class="w-16 h-16 rounded-lg object-cover border border-gray-200 shadow-sm">
                                            <span class="absolute -top-2 -right-2 bg-gray-100 text-gray-500 rounded-full p-1 text-[10px] border border-gray-200">Det 1</span>
                                        </div>
                                    </template>
                                    <div class="flex-1">
                                        <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-1">Detail Image 1</label>
                                        <input type="file" name="image_detail_1" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-gray-50">
                                    </div>
                                </div>
                                <!-- Detail Image 2 -->
                                <div class="flex items-center space-x-4">
                                    <template x-if="editProduct.image_detail_2_url">
                                        <div class="relative">
                                            <img :src="editProduct.image_detail_2_url.startsWith('http') || editProduct.image_detail_2_url.startsWith('/') ? editProduct.image_detail_2_url : '/' + editProduct.image_detail_2_url" class="w-16 h-16 rounded-lg object-cover border border-gray-200 shadow-sm">
                                            <span class="absolute -top-2 -right-2 bg-gray-100 text-gray-500 rounded-full p-1 text-[10px] border border-gray-200">Det 2</span>
                                        </div>
                                    </template>
                                    <div class="flex-1">
                                        <label class="block text-[10px] text-gray-400 uppercase tracking-wider mb-1">Detail Image 2</label>
                                        <input type="file" name="image_detail_2" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-black focus:border-black bg-gray-50">
                                    </div>
                                </div>
                            </div>
                            <p class="text-[10px] text-gray-500 mt-2">Leave blank to keep current images</p>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-xl border-t border-gray-200">
                    <button type="submit" form="editProductForm" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black sm:ml-3 sm:w-auto sm:text-sm">
                        Update Product
                    </button>
                    <button type="button" @click="editProductModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
