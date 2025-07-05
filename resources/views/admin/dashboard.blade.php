<x-dashboard-layout>
    <div class="p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Plots</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['totalPlots'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['totalUsers'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-calendar-check text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Reservations</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['totalReservations'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-envelope text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Inquiries</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['totalInquiries'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                        <i class="fas fa-star text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Reviews</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['totalReviews'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-dollar-sign text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['totalRevenue'], 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue Trend</h3>
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>

            <!-- Plot Categories Chart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Plot Categories</h3>
                <canvas id="categoryChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- New Plots Chart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">New Plots Added</h3>
                <canvas id="plotsChart" width="400" height="200"></canvas>
            </div>

            <!-- Inquiries Chart -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Inquiries Received</h3>
                <canvas id="inquiriesChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.plots.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fas fa-plus-circle text-blue-600 text-xl mr-3"></i>
                    <span class="text-blue-800 font-medium">Add New Plot</span>
                </a>

                <a href="{{ route('admin.plots.pending') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                    <i class="fas fa-clock text-yellow-600 text-xl mr-3"></i>
                    <span class="text-yellow-800 font-medium">Pending Approvals</span>
                </a>

                <a href="{{ route('admin.inquiries.index') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <i class="fas fa-envelope text-purple-600 text-xl mr-3"></i>
                    <span class="text-purple-800 font-medium">View Inquiries</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-users text-green-600 text-xl mr-3"></i>
                    <span class="text-green-800 font-medium">Manage Users</span>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Revenue ($)',
                    data: @json($totals),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    data: @json($categoryCounts),
                    backgroundColor: [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)'
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });

        // Plots Chart
        const plotsCtx = document.getElementById('plotsChart').getContext('2d');
        new Chart(plotsCtx, {
            type: 'bar',
            data: {
                labels: @json($plotsMonths),
                datasets: [{
                    label: 'New Plots',
                    data: @json($plotsCounts),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Inquiries Chart
        const inquiriesCtx = document.getElementById('inquiriesChart').getContext('2d');
        new Chart(inquiriesCtx, {
            type: 'bar',
            data: {
                labels: @json($inquiriesMonths),
                datasets: [{
                    label: 'Inquiries',
                    data: @json($inquiriesCounts),
                    backgroundColor: 'rgba(147, 51, 234, 0.8)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-dashboard-layout>
