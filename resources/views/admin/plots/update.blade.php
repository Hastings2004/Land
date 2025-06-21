<x-dashboard-layout>
    <h2 class="text-3xl font-bold mb-6 text-black">Available Plots</h2>
                        <div class="flex flex-col sm:flex-row mb-4 gap-4 items-center justify-between">
                            <div class="w-full sm:w-auto">
                                <form action="{{ route('dashboard', ['viewType' => 'plots']) }}" method="GET" class="w-full">
                                    <div class="relative">
                                        <input type="text" name="search" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Search plots..." value="{{ request('search') }}">
                                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                </form>
                            </div>
                            <div class="flex flex-wrap gap-2 w-full sm:w-auto justify-end">
                                <a href="{{ route('dashboard', ['viewType' => 'plots', 'new_listings' => true]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Show New Listings Only</a>
                                <a href="{{ route('dashboard', ['viewType' => 'plots']) }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">Clear Filters</a>
                            </div>
                        </div>
                        <div class="p-6 rounded-xl shadow-lg">
                            @if($plots->isEmpty())
                                <div class="alert bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative">No plots available matching your criteria.</div>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($plots as $plot)
                                        <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
                                            @if($plot->is_new_listing)
                                                <div class="badge bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full absolute top-3 right-3 z-10">New</div>
                                            @endif
                                            <div class="p-4 flex-grow">
                                                <h5 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $plot->title }}</h5>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-3"><strong>Description:</strong><span>{{ Str::limit($plot->description, 100) }}</span></p>
                                                <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                                                    <li class="flex justify-between items-center py-1"><strong>Price:</strong><span>${{ number_format($plot->price, 2) }}</span></li>
                                                    <li class="flex justify-between items-center py-1"><strong>Area:</strong><span>{{ number_format($plot->area_sqm, 2) }} sqm</span></li>
                                                    <li class="flex justify-between items-center py-1"><strong>Location:</strong><span>{{ $plot->location }}</span></li>
                                                </ul>
                                            </div>
                                            <div class="p-4 border-t border-gray-200 dark:border-gray-600">
                                                <a href="{{ route('dashboard', ['viewType' => 'plot', 'id' => $plot->id]) }}" class="block w-full text-center px-4 py-2 bg-yellow-500 text-white rounded-md font-semibold text-sm uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">View Details</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-6 flex justify-center">
                                    {{ $plots->appends(request()->query())->links() }}
                                </div>
                            @endif
                        </div>
     
</x-dashboard-layout>