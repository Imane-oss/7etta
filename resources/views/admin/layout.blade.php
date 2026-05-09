<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AdminPro Dashboard')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            /* very light gray/blue */
        }

        .sidebar-link {
            transition: all 0.2s ease-in-out;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background-color: #eef2ff;
            color: #555556;
            border-left: 4px solid #000000;
        }

        .sidebar-link:not(.active) {
            border-left: 4px solid transparent;
            color: #9b9b9c;
        }

        .glass-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>

<body class="text-gray-800 antialiased h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col h-full z-20 shadow-sm relative">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <i class="bi bi-shop text-gray-500 text-2xl mr-2"></i>
            <span class="text-xl font-bold text-gray-900 tracking-tight">Admin</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 py-4 overflow-y-auto">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-link flex items-center px-6 py-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-pie-chart-fill mr-3 text-lg"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products') }}"
                        class="sidebar-link flex items-center px-6 py-3 {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                        <i class="bi bi-box-seam-fill mr-3 text-lg"></i>
                        <span class="font-medium">Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders') }}" class="sidebar-link flex items-center px-6 py-3 {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                        <i class="bi bi-cart-fill mr-3 text-lg"></i>
                        <span class="font-medium">Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users') }}"
                        class="sidebar-link flex items-center px-6 py-3 {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <i class="bi bi-people-fill mr-3 text-lg"></i>
                        <span class="font-medium">Users</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-link flex items-center px-6 py-3">
                        <i class="bi bi-envelope-fill mr-3 text-lg"></i>
                        <span class="font-medium">Messages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings') }}" class="sidebar-link flex items-center px-6 py-3 {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="bi bi-gear-fill mr-3 text-lg"></i>
                        <span class="font-medium">Settings</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-full overflow-hidden bg-[#f8fafc]">

        <!-- Topbar -->
        <header
            class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 flex-shrink-0 z-10">
            <div>
                <!-- Empty left space -->
            </div>

            <div class="flex items-center space-x-6">


                <!-- Profile Dropdown (Alpine) -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center space-x-2 focus:outline-none group">
                        <div
                            class="h-8 w-8 rounded-full bg-black flex items-center justify-center text-white font-bold text-sm transition-all duration-300 group-hover:scale-110 group-hover:rotate-6 group-hover:shadow-md">
                            AU
                        </div>
                        <span class="text-sm font-medium text-gray-700 hidden md:block transition-colors duration-300 group-hover:text-black">Admin User <i
                                class="bi bi-chevron-down text-xs ml-1 transition-transform duration-300" :class="{'rotate-180': open}"></i></span>
                    </button>

                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i
                                class="bi bi-person mr-2"></i> Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i
                                class="bi bi-gear mr-2"></i> Settings</a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                <i class="bi bi-box-arrow-right mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f8fafc] p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>

</html>