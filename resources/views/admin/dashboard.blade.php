@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
    <button class="bg-[#4f46e5] hover:bg-[#4338ca] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center shadow-sm">
        <i class="bi bi-download mr-2"></i> Generate Report
    </button>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Sales -->
    <div class="glass-card p-6 relative overflow-hidden">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Sales</p>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">${{ number_format($totalSales, 2) }}</h3>
                <p class="text-sm text-green-600 flex items-center font-medium">
                    <i class="bi bi-arrow-up-short text-lg mr-1"></i> +12.5% from last month
                </p>
            </div>
            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl">
                <i class="bi bi-currency-dollar"></i>
            </div>
        </div>
    </div>

    <!-- Orders -->
    <div class="glass-card p-6 relative overflow-hidden">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Orders</p>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ number_format($totalOrders) }}</h3>
                <p class="text-sm text-green-600 flex items-center font-medium">
                    <i class="bi bi-arrow-up-short text-lg mr-1"></i> +5.2% from last month
                </p>
            </div>
            <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-lg">
                <i class="bi bi-bag-fill"></i>
            </div>
        </div>
    </div>

    <!-- Users -->
    <div class="glass-card p-6 relative overflow-hidden">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Users</p>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ number_format($totalUsers) }}</h3>
                <p class="text-sm text-green-600 flex items-center font-medium">
                    <i class="bi bi-arrow-up-short text-lg mr-1"></i> +2.1% from last month
                </p>
            </div>
            <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 text-lg">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>

    <!-- Products -->
    <div class="glass-card p-6 relative overflow-hidden">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Products</p>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ number_format($totalProducts) }}</h3>
                <p class="text-sm text-gray-400 flex items-center font-medium">
                    <i class="bi bi-dash text-lg mr-1"></i> No change
                </p>
            </div>
            <div class="h-10 w-10 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-600 text-lg">
                <i class="bi bi-box-seam-fill"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Chart -->
    <div class="lg:col-span-2 glass-card p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-900">Sales Overview</h2>
            <select class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 border p-1 px-2 text-gray-600 outline-none">
                <option>Last Month</option>
                <option>This Year</option>
            </select>
        </div>
        <div class="relative h-72 w-full">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Top Products -->
    <div class="glass-card p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Top Products</h2>
        <div class="space-y-5">
            @foreach($topProducts as $product)
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 mb-0.5 uppercase tracking-wider">Product</p>
                    <h4 class="font-bold text-gray-900 text-sm">{{ $product->name_product }}</h4>
                    <span class="text-xs text-gray-500">{{ $product->category }}</span>
                </div>
                <div class="text-right font-bold text-gray-900">
                    ${{ number_format($product->price, 0) }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Gradient for line chart
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.15)'); // indigo-600 with opacity
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesByMonth->pluck('month')),
            datasets: [{
                label: 'Sales',
                data: @json($salesByMonth->pluck('total')),
                borderColor: '#4f46e5', // indigo-600
                backgroundColor: gradient,
                borderWidth: 2,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#4f46e5',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4 // smooth curve
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    padding: 10,
                    titleFont: { size: 13 },
                    bodyFont: { size: 14, weight: 'bold' },
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return '$' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6',
                        drawBorder: false,
                    },
                    ticks: {
                        color: '#6b7280',
                        font: { size: 11 },
                        padding: 10,
                        callback: function(value) {
                            if (value === 0) return 0;
                            if (value >= 1000) return value/1000 + 'k';
                            return value;
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        color: '#6b7280',
                        font: { size: 11 },
                        padding: 10
                    }
                }
            }
        }
    });
});
</script>
@endpush