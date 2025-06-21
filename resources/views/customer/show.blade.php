<x-dashboard-layout>
     @if (isset($activeView) && $activeView === 'single_plot')
                        {{-- Content from customer/plots/show.blade.php --}}
                                        @elseif (isset($activeView) && $activeView === 'all_plots')
                        {{-- Content from customer/plots/index.blade.php --}}
                                       @else
                        {{-- Default dashboard overview content --}}
                        <h2 class="text-3xl font-bold mb-6">My Dashboard - Overview</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <div class="card bg-white p-6 rounded-xl shadow-lg flex items-center justify-between">
                                <div><p class="text-gray-500 text-sm font-medium">Available Plots</p><p class="text-4xl font-bold text-indigo-700 mt-2">205</p></div>
                                <div class="text-indigo-400 text-5xl"><i class="fas fa-map-marker-alt"></i></div>
                            </div>
                            <div class="card bg-white p-6 rounded-xl shadow-lg flex items-center justify-between">
                                <div><p class="text-gray-500 text-sm font-medium">New Listings (30 Days)</p><p class="text-4xl font-bold text-green-600 mt-2">22</p></div>
                                <div class="text-green-400 text-5xl"><i class="fas fa-chart-line"></i></div>
                            </div>
                            <div class="card bg-white p-6 rounded-xl shadow-lg flex items-center justify-between">
                                <div><p class="text-gray-500 text-sm font-medium">Your Inquiries (Pending)</p><p class="text-4xl font-bold text-orange-600 mt-2">3</p></div>
                                <div class="text-orange-400 text-5xl"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                            <div class="card bg-white p-6 rounded-xl shadow-lg flex items-center justify-between">
                                <div><p class="text-gray-500 text-sm font-medium">Avg. Plot Price (per sqm)</p><p class="text-4xl font-bold text-purple-700 mt-2">K 50,000</p></div>
                                <div class="text-purple-400 text-5xl"><i class="fas fa-dollar-sign"></i></div>
                            </div>
                        </div>
                        
                        
                        <div class="bg-white p-6 rounded-xl shadow-lg">
                            <h3 class="text-xl font-semibold mb-4">Recent Plot Listings & Your Inquiries</h3>
                            <div class="bg-gray-50 p-4 rounded-lg border border-dashed border-gray-300 text-gray-500">
                                <p>Details of recent plot listings and your inquiries will be displayed here.</p>
                                <ul class="mt-4 space-y-2">
                                    <li class="p-2 bg-white rounded-md border border-gray-200"><a href="{{ route('dashboard', ['viewType' => 'plot', 'id' => 1]) }}" class="text-blue-600 hover:underline">Plot A - New Listing (View Details)</a></li>
                                    <li class="p-2 bg-white rounded-md border border-gray-200">Inquiry for Plot B - Pending (Check Status)</li>
                                    <li class="p-2 bg-white rounded-md border border-gray-200"><a href="{{ route('dashboard', ['viewType' => 'plot', 'id' => 3]) }}" class="text-blue-600 hover:underline">Plot C - Price Updated (View Details)</a></li>
                                    <li class="p-2 bg-white rounded-md border border-gray-200"><a href="{{ route('dashboard', ['viewType' => 'plots']) }}" class="text-blue-600 hover:underline">View All Available Plots</a></li>
                                </ul>
                            </div>
                        </div>
                    @endif
     
    
</x-dashboard-layout>