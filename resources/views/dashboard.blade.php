<x-dashboard-layout>
    {{-- Admin Statistics Dashboard --}}
    @if(auth()->check() && auth()->user()->isAdmin() && isset($stats))
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6 gap-y-8 mb-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 border-l-4 border-blue-500 transition-transform transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="text-3xl font-extrabold text-blue-600 dark:text-blue-300">{{ $stats['totalPlots'] }}</div>
                <div class="text-gray-600 dark:text-gray-300 mt-2 font-semibold">Total Plots</div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 border-l-4 border-green-500 transition-transform transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="text-3xl font-extrabold text-green-600 dark:text-green-300">{{ $stats['totalUsers'] }}</div>
                <div class="text-gray-600 dark:text-gray-300 mt-2 font-semibold">Total Users</div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 border-l-4 border-yellow-500 transition-transform transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="text-3xl font-extrabold text-yellow-600 dark:text-yellow-300">{{ $stats['totalReservations'] }}</div>
                <div class="text-gray-600 dark:text-gray-300 mt-2 font-semibold">Total Reservations</div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 border-l-4 border-purple-500 transition-transform transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="text-3xl font-extrabold text-purple-600 dark:text-purple-300">{{ $stats['totalInquiries'] }}</div>
                <div class="text-gray-600 dark:text-gray-300 mt-2 font-semibold">Total Inquiries</div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 border-l-4 border-pink-500 transition-transform transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="text-3xl font-extrabold text-pink-600 dark:text-pink-300">{{ $stats['totalReviews'] }}</div>
                <div class="text-gray-600 dark:text-gray-300 mt-2 font-semibold">Total Reviews</div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 border-l-4 border-indigo-500 transition-transform transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-300">K{{ number_format($stats['totalRevenue'], 2) }}</div>
                <div class="text-gray-600 dark:text-gray-300 mt-2 font-semibold">Total Revenue</div>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-8 mb-8">
            <div class="flex-1 min-w-0">
                <div class="flex items-center mb-4">
                    <h3 class="text-2xl font-extrabold tracking-tight text-blue-700 dark:text-blue-300 mb-2">Revenue Per Month (Last 12 Months)</h3>
                    <div class="flex-1 border-t border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-gray-900 dark:to-gray-800 rounded-2xl shadow p-6 min-h-[400px] flex items-center justify-center">
                    <canvas id="revenueChart" height="400" width="400" style="height:100%!important;width:100%!important;max-height:400px;max-width:100%"></canvas>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center mb-4">
                    <h3 class="text-2xl font-extrabold tracking-tight text-blue-700 dark:text-blue-300 mb-2">Plot Category Distribution</h3>
                    <div class="flex-1 border-t border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="bg-gradient-to-br from-pink-50 to-purple-100 dark:from-gray-900 dark:to-gray-800 rounded-2xl shadow p-6 min-h-[400px] flex items-center justify-center">
                    <canvas id="categoryPieChart" height="400" width="400" style="height:100%!important;width:100%!important;max-height:400px;max-width:100%"></canvas>
                </div>
            </div>
        </div>
        {{-- Scatter Plot: Price vs. Area --}}
        <div class="flex flex-col lg:flex-row gap-8 mb-8">
            <div class="flex-1 min-w-0">
                <div class="flex items-center mb-4">
                    <h3 class="text-2xl font-extrabold tracking-tight text-blue-700 dark:text-blue-300 mb-2">Price vs. Area (Scatter Plot with Regression Line)</h3>
                    <div class="flex-1 border-t border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-blue-100 dark:from-gray-900 dark:to-gray-800 rounded-2xl shadow p-6 min-h-[400px] flex items-center justify-center">
                    <canvas id="scatterPlot" height="400" width="400" style="height:100%!important;width:100%!important;max-height:400px;max-width:100%"></canvas>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center mb-4">
                    <h3 class="text-2xl font-extrabold tracking-tight text-blue-700 dark:text-blue-300 mb-2">New Plots Added Per Month</h3>
                    <div class="flex-1 border-t border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="bg-gradient-to-br from-yellow-50 to-green-100 dark:from-gray-900 dark:to-gray-800 rounded-2xl shadow p-6 min-h-[400px] flex items-center justify-center">
                    <canvas id="plotsLineChart" height="400" width="400" style="height:100%!important;width:100%!important;max-height:400px;max-width:100%"></canvas>
                </div>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-8 mb-8">
            <div class="flex-1 min-w-0">
                <div class="flex items-center mb-4">
                    <h3 class="text-2xl font-extrabold tracking-tight text-blue-700 dark:text-blue-300 mb-2">Inquiries Received Per Month</h3>
                    <div class="flex-1 border-t border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-green-100 dark:from-gray-900 dark:to-gray-800 rounded-2xl shadow p-6 min-h-[400px] flex items-center justify-center">
                    <canvas id="inquiriesLineChart" height="400" width="400" style="height:100%!important;width:100%!important;max-height:400px;max-width:100%"></canvas>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center mb-4">
                    <h3 class="text-2xl font-extrabold tracking-tight text-blue-700 dark:text-blue-300 mb-2">Top Viewed Plots</h3>
                    <div class="flex-1 border-t border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="bg-gradient-to-br from-yellow-50 to-pink-100 dark:from-gray-900 dark:to-gray-800 rounded-2xl shadow p-6 min-h-[400px] flex items-center justify-center">
                    <canvas id="topViewedBarChart" height="400" width="400" style="height:100%!important;width:100%!important;max-height:400px;max-width:100%"></canvas>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($months ?? []),
                    datasets: [{
                        label: 'Revenue',
                        data: @json($totals ?? []),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) { return 'K' + value; }
                            }
                        }
                    }
                }
            });
        </script>
        <script>
            const ctxPie = document.getElementById('categoryPieChart').getContext('2d');
            const categoryPieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: @json($categoryLabels ?? []),
                    datasets: [{
                        data: @json($categoryCounts ?? []),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: { enabled: true }
                    }
                }
            });
        </script>
        <script>
            // Scatter plot with regression line
            const scatterData = @json($scatterData ?? []);
            // Calculate regression line (least squares)
            function linearRegression(data) {
                const n = data.length;
                if (n === 0) return {slope: 0, intercept: 0};
                let sumX = 0, sumY = 0, sumXY = 0, sumXX = 0;
                data.forEach(pt => {
                    sumX += pt.x;
                    sumY += pt.y;
                    sumXY += pt.x * pt.y;
                    sumXX += pt.x * pt.x;
                });
                const slope = (n * sumXY - sumX * sumY) / (n * sumXX - sumX * sumX);
                const intercept = (sumY - slope * sumX) / n;
                return {slope, intercept};
            }
            const lr = linearRegression(scatterData);
            // Find min and max x for the regression line
            const xVals = scatterData.map(pt => pt.x);
            const minX = Math.min(...xVals);
            const maxX = Math.max(...xVals);
            const regressionLine = [
                {x: minX, y: lr.slope * minX + lr.intercept},
                {x: maxX, y: lr.slope * maxX + lr.intercept}
            ];
            const ctxScatter = document.getElementById('scatterPlot').getContext('2d');
            new Chart(ctxScatter, {
                type: 'scatter',
                data: {
                    datasets: [
                        {
                            label: 'Plots',
                            data: scatterData,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            pointRadius: 6,
                        },
                        {
                            label: 'Regression Line',
                            type: 'line',
                            data: regressionLine,
                            fill: false,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            pointRadius: 0,
                            order: 0,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        x: {
                            title: { display: true, text: 'Area (sqm)' },
                            beginAtZero: true
                        },
                        y: {
                            title: { display: true, text: 'Price (K)' },
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) { return 'K' + value; }
                            }
                        }
                    }
                }
            });
        </script>
        <script>
            // New Plots Added Per Month Line Chart
            const plotsMonths = @json($plotsMonths ?? []);
            const plotsCounts = @json($plotsCounts ?? []);
            const ctxPlotsLine = document.getElementById('plotsLineChart').getContext('2d');
            new Chart(ctxPlotsLine, {
                type: 'line',
                data: {
                    labels: plotsMonths,
                    datasets: [{
                        label: 'New Plots',
                        data: plotsCounts,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Number of Plots' }
                        },
                        x: {
                            title: { display: true, text: 'Month' }
                        }
                    }
                }
            });
        </script>
        <script>
            // Inquiries Received Per Month Line Chart
            const inquiriesMonths = @json($inquiriesMonths ?? []);
            const inquiriesCounts = @json($inquiriesCounts ?? []);
            const ctxInquiriesLine = document.getElementById('inquiriesLineChart').getContext('2d');
            new Chart(ctxInquiriesLine, {
                type: 'line',
                data: {
                    labels: inquiriesMonths,
                    datasets: [{
                        label: 'Inquiries',
                        data: inquiriesCounts,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Number of Inquiries' }
                        },
                        x: {
                            title: { display: true, text: 'Month' }
                        }
                    }
                }
            });
            // Top Viewed Plots Bar Chart
            const topViewedLabels = @json($topViewedLabels ?? []);
            const topViewedCounts = @json($topViewedCounts ?? []);
            const ctxTopViewedBar = document.getElementById('topViewedBarChart').getContext('2d');
            new Chart(ctxTopViewedBar, {
                type: 'bar',
                data: {
                    labels: topViewedLabels,
                    datasets: [{
                        label: 'Views',
                        data: topViewedCounts,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Views' }
                        },
                        x: {
                            title: { display: true, text: 'Plot' }
                        }
                    }
                }
            });
        </script>
    @endif

    {{-- Conditional rendering of content based on activeView --}}

    {{-- Admin Views --}}
    @if(auth()->check() && auth()->user()->isAdmin())
        @if(isset($activeView) && $activeView === 'admin_plots_index')
            <h2 class="text-3xl font-bold mb-6 text-gray-900 dark:text-gray-100">Manage Plots (Admin)</h2>
            <div class="flex justify-end mb-4">
                <a href="{{ route('dashboard', ['viewType' => 'admin', 'id' => 'plots/create']) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Add New Plot
                </a>
            </div>
            <div class="p-6 rounded-xl shadow-lg">
                @if (session('success'))
                    @php $message = session('success'); @endphp {{-- Assign session value to a variable --}}
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ $message }}</span>
                    </div>
                @endif
                @if ($plots->isEmpty())
                    <div class="alert bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative">No plots found for administration.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Area (sqm)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">New Listing</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($Plots as $plot)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $plot->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${{ number_format($plot->price, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ number_format($plot->area_sqm, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $plot->location }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ ucfirst($plot->status) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $plot->is_new_listing ? 'Yes' : 'No' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('dashboard', ['viewType' => 'admin', 'id' => 'plots/' . $plot->id]) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 mr-2">View</a>
                                            <a href="{{ route('dashboard', ['viewType' => 'admin', 'id' => 'plots/' . $plot->id . '/edit']) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-200 mr-2">Edit</a>
                                            <form action="{{ route('admin.plots.destroy', $plot->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200" onclick="return confirm('Are you sure you want to delete this plot?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $Plots->links() }}
                    </div>
                @endif
            </div>

        
        @elseif(isset($activeView) && $activeView === 'admin_plots_edit')
            
        @elseif(isset($activeView) && $activeView === 'admin_plots_show')
            <h2 class="text-3xl font-bold mb-6 text-gray-900 dark:text-gray-100">Plot Details (Admin) - {{ $plot->title }}</h2>
            <div class="p-6 rounded-xl shadow-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2"><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Title:</strong> {{ $plot->title }}</p></div>
                    <div class="col-span-2"><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Description:</strong></p><p class="text-gray-900 dark:text-gray-100 mt-1">{{ $plot->description }}</p></div>
                    <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Price:</strong> ${{ number_format($plot->price, 2) }}</p></div>
                    <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Area:</strong> {{ number_format($plot->area_sqm, 2) }} sqm</p></div>
                    <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Location:</strong> {{ $plot->location }}</p></div>
                    <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Status:</strong> {{ ucfirst($plot->status) }}</p></div>
                    <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>New Listing:</strong> {{ $plot->is_new_listing ? 'Yes' : 'No' }}</p></div>
                    <div class="col-span-2"><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Created At:</strong> {{ $plot->created_at->format('M d, Y H:i A') }}</p></div>
                    <div class="col-span-2"><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Last Updated:</strong> {{ $plot->updated_at->format('M d, Y H:i A') }}</p></div>
                </div>
                <div class="mt-6 flex justify-start">
                    <a href="{{ route('dashboard', ['viewType' => 'admin', 'id' => 'plots/' . $plot->id . '/edit']) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mr-2">Edit</a>
                    <a href="{{ route('dashboard', ['viewType' => 'admin', 'id' => 'plots']) }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">Back to List</a>
                </div>
            </div>
        @else {{-- Customer Views (or default if not admin) --}}
                  @endif
    @endif
</main>
</div>


</x-dashboard-layout>   