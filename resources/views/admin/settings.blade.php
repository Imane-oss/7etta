@extends('admin.layout')

@section('title', 'Store Settings')

@section('content')
<div class="max-w-7xl mx-auto pb-12">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Settings</h1>
        </div>
        <button type="submit" form="settings-form" class="bg-gray-900 hover:bg-black text-white px-6 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm flex items-center gap-2 border border-transparent focus:ring-4 focus:ring-gray-200">
            <i class="bi bi-check2-circle text-lg leading-none"></i>
            Save Changes
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Main Content -->
    <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Main Settings -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Admin Profile -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                            <i class="bi bi-person-circle text-lg"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Admin Profile</h2>
                    </div>
                    <div class="p-6 flex flex-col sm:flex-row gap-8">
                        <div class="flex-shrink-0">
                            <div class="relative group">
                                <div class="h-24 w-24 rounded-full bg-black border-4 border-white shadow-md flex items-center justify-center overflow-hidden">
                                    @if(auth()->user()->profile_photo_path)
                                        <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-3xl font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <label class="absolute inset-0 flex items-center justify-center bg-black/50 text-white rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                                    <i class="bi bi-camera text-xl"></i>
                                    <input type="file" name="admin_photo" class="hidden" accept="image/*">
                                </label>
                            </div>
                        </div>
                        <div class="flex-1 space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Full Name</label>
                                    <input type="text" name="admin_name" value="{{ auth()->user()->name }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:bg-white focus:border-gray-900 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Account Email</label>
                                    <input type="email" name="admin_email" value="{{ auth()->user()->email }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:bg-white focus:border-gray-900 transition-all">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- General Details -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="bi bi-shop text-lg"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">General Details</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Store Name</label>
                                <input type="text" name="store_name" value="{{ $siteSettings['store_name'] ?? '7ETTA' }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:bg-white focus:border-gray-900 transition-all placeholder-gray-400">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Contact Email</label>
                                <input type="email" name="contact_email" value="{{ $siteSettings['contact_email'] ?? 'support@example.com' }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:bg-white focus:border-gray-900 transition-all placeholder-gray-400">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Store Address</label>
                            <input type="text" name="store_address" value="{{ $siteSettings['store_address'] ?? '' }}" placeholder="Full street address" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:bg-white focus:border-gray-900 transition-all placeholder-gray-400">
                        </div>
                    </div>
                </div>

                <!-- Payment & Shipping -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                            <i class="bi bi-credit-card text-lg"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Payment & Shipping</h2>
                    </div>
                    <div class="p-6 space-y-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Standard Shipping Price ($)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-medium">$</span>
                                    <input type="number" step="0.01" name="shipping_price" value="15.00" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl pl-8 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:bg-white focus:border-gray-900 transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Free Shipping Threshold ($)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-medium">$</span>
                                    <input type="number" step="0.01" name="shipping_threshold" value="100.00" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl pl-8 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:bg-white focus:border-gray-900 transition-all">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-4">Active Payment Methods</label>
                            <div class="flex flex-wrap gap-6">
                                
                                <label class="flex items-center cursor-pointer group">
                                    <div class="relative">
                                        <input type="checkbox" class="sr-only peer" checked>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 group-hover:bg-gray-300 peer-checked:group-hover:bg-blue-700 transition-colors"></div>
                                    </div>
                                    <div class="ml-3 flex items-center gap-2">
                                        <div class="h-6 w-10 bg-[#00457C] rounded flex items-center justify-center shadow-sm">
                                            <i class="bi bi-paypal text-white text-xs"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">PayPal</span>
                                    </div>
                                </label>

                                <label class="flex items-center cursor-pointer group">
                                    <div class="relative">
                                        <input type="checkbox" class="sr-only peer" checked>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600 group-hover:bg-gray-300 peer-checked:group-hover:bg-orange-700 transition-colors"></div>
                                    </div>
                                    <div class="ml-3 flex items-center gap-2">
                                        <div class="h-6 w-10 bg-orange-500 rounded flex items-center justify-center shadow-sm">
                                            <i class="bi bi-truck text-white text-xs"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Cash on Delivery</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Branding & Extras -->
            <div class="space-y-8">
                
                <!-- Branding -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center">
                            <i class="bi bi-palette text-lg"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Branding</h2>
                    </div>
                    <div class="p-6">
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">Store Logo</label>
                        <div class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-gray-200 border-dashed rounded-xl hover:border-gray-400 hover:bg-gray-50 transition-colors cursor-pointer group relative">
                            <div class="space-y-2 text-center">
                                <div class="mx-auto h-16 w-16 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform overflow-hidden">
                                    @if(isset($siteSettings['store_logo']))
                                        <img src="{{ url($siteSettings['store_logo']) }}" class="h-full w-full object-contain">
                                    @else
                                        <i class="bi bi-image text-2xl text-blue-500"></i>
                                    @endif
                                </div>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <span class="relative cursor-pointer rounded-md font-medium text-gray-900 focus-within:outline-none">
                                        <span>Upload Logo</span>
                                        <input type="file" name="store_logo" class="sr-only">
                                    </span>
                                </div>
                                <p class="text-xs text-gray-400">PNG or JPG, max 2MB</p>
                            </div>
                        </div>
                        <div class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center">
                            @if(isset($siteSettings['store_logo']))
                                <img src="{{ url($siteSettings['store_logo']) }}" class="h-8 object-contain">
                            @else
                                <span class="font-bold text-xl tracking-tight text-gray-900">{{ $siteSettings['store_name'] ?? '7ETTA' }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Notifications (New) -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center">
                            <i class="bi bi-bell text-lg"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Notifications</h2>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">New Orders</p>
                                <p class="text-xs text-gray-500">Get notified when a sale is made</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gray-900"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Customer Messages</p>
                                <p class="text-xs text-gray-500">Alerts for new contact inquiries</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gray-900"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Security (New) -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                            <i class="bi bi-shield-lock text-lg"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Security</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="flex items-center gap-3">
                                <i class="bi bi-phone text-gray-500 text-lg"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Two-Factor Auth</p>
                                    <p class="text-xs text-gray-500">Enhanced account security</p>
                                </div>
                            </div>
                            <button type="button" class="text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-gray-50 px-3 py-1.5 rounded-lg transition-colors shadow-sm">
                                Enable
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
