@extends('layout.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['users'] ?? 'n/a' }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Orders</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['orders'] ?? 'n/a' }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Revenue</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white">Rs {{ number_format($stats['revenue'] ?? 0, 2) }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Products</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['products'] ?? 'n/a' }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Avg Order Value</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white">Rs {{ number_format($stats['avgOrderValue'] ?? 0, 2) }}</div>
        </div>
    </div>

    <!-- Analytics Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium mb-4 dark:text-white">Orders (Last 30 Days)</h2>
            <canvas id="ordersChart" height="120"></canvas>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium mb-4 dark:text-white">Revenue (Last 30 Days)</h2>
            <canvas id="revenueChart" height="120"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium mb-4 dark:text-white">Order Status Breakdown</h2>
            <div class="flex justify-center">
                <canvas id="orderStatusChart" width="250" height="250"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium mb-4 dark:text-white">Payment Methods</h2>
            <canvas id="paymentMethodChart" height="200"></canvas>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium mb-4 dark:text-white">Recent Orders</h2>
            <div class="overflow-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-500 dark:text-gray-400 border-b dark:border-gray-700">
                            <th class="py-3">ID</th>
                            <th class="py-3">Customer</th>
                            <th class="py-3 text-right">Amount</th>
                            <th class="py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="dark:text-gray-300">
                        @forelse ($recentOrders as $order)
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <td class="py-3">#{{ $order->id }}</td>
                                <td class="py-3">{{ optional($order->user)->name ?? 'Guest' }}</td>
                                <td class="py-3 text-right font-medium">Rs {{ number_format($order->total, 2) }}</td>
                                <td class="py-3">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $order->status->value == 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($order->status->value == 'delivered'
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($order->status->value) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">No recent orders</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Recent Products -->
    <div class="mt-4">
        <h2 class="font-semibold mb-3 dark:text-white">Recent Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($recentProducts ?? [] as $product)
                <x-ui.cards.product-card :product="$product" :url="route('admin.products.show', $product->id)" />
            @endforeach
        </div>
    </div>

    <!-- Recent Users -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="mb-3 p-3">
            <h2 class="font-semibold dark:text-white">Recent Users</h2>
            <p class="text-sm text-gray-400">Recently Joined Users</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="border-t border-gray-200 dark:border-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="p-4 text-sm">ID</th>
                        <th class="p-4 text-sm">Name</th>
                        <th class="p-4 text-sm">Email</th>
                        <th class="p-4 text-sm">Role</th>
                        <th class="p-4 text-sm">Joined</th>
                    </tr>
                </thead>
                <tbody class="dark:text-gray-300">
                    @foreach ($recentUsers ?? [] as $user)
                        <tr class="border-t border-gray-300 dark:border-gray-700">
                            <td class="p-4 text-sm">{{ $user->id }}</td>
                            <td class="p-4 text-sm">{{ $user->name }}</td>
                            <td class="p-4 text-sm">{{ $user->email }}</td>
                            <td class="p-4 text-sm">{{ $user->role_name }}</td>
                            <td class="p-4 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function() {
            const chartColors = {
                primary: '#fb923c',
                secondary: '#3b82f6',
                success: '#10b981',
                warning: '#f59e0b',
                danger: '#ef4444',
                info: '#6366f1'
            };

            // Orders Chart
            const ordersCtx = document.getElementById('ordersChart').getContext('2d');
            new Chart(ordersCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($ordersLabels) !!},
                    datasets: [{
                        label: 'Orders',
                        data: {!! json_encode($ordersData) !!},
                        borderColor: chartColors.primary,
                        backgroundColor: 'rgba(251,146,60,0.1)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($ordersLabels) !!},
                    datasets: [{
                        label: 'Revenue (Rs)',
                        data: {!! json_encode($revenueData) !!},
                        borderColor: chartColors.success,
                        backgroundColor: 'rgba(16,185,129,0.1)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Order Status Chart
            const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
            const statusData = {!! json_encode($orderStatuses) !!};
            new Chart(orderStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusData),
                    datasets: [{
                        data: Object.values(statusData),
                        backgroundColor: [chartColors.warning, chartColors.info, chartColors.primary,
                            chartColors.success, chartColors.danger
                        ]
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });

            // Payment Methods Chart
            const paymentMethodCtx = document.getElementById('paymentMethodChart').getContext('2d');
            const paymentData = {!! json_encode($paymentMethods) !!};
            new Chart(paymentMethodCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(paymentData).map(label => label.replace('_', ' ').toUpperCase()),
                    datasets: [{
                        label: 'Transactions',
                        data: Object.values(paymentData),
                        backgroundColor: chartColors.secondary,
                        borderRadius: 4,
                        barThickness: 60
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.1)'
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    }
                }
            });
        })();
    </script>

@endsection
