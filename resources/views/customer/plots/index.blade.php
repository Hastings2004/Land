<x-dashboard-layout>
<<<<<<< HEAD:resources/views/customer/index.blade.php
    <!-- Page Title -->
    <!-- Increased bottom margin for better separation from the search/filter section -->
    <h2 class="text-3xl font-bold mb-10 text-yellow-700 text-center">Available Plots</h2>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <!-- Search Form with Icon -->
        <form action="{{ route('dashboard', parameters: ['viewType' => 'plots']) }}" method="GET" class="w-full md:w-auto">
            <div class="relative">
                <input type="text" name="search" class="w-64 md:w-72 pl-10 pr-5 py-2 border border-yellow-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white text-gray-800 placeholder-yellow-500 shadow-sm" placeholder="Search plots..." value="{{ request('search') }}">
                <!-- Search Icon -->
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </form>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-3 w-full md:w-auto justify-end">
            <a href="{{ route('dashboard', ['viewType' => 'plots', 'new_listings' => true]) }}" class="inline-flex items-center px-5 py-2 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-yellow-900 uppercase tracking-widest hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                Show New Listings Only
            </a>
            <a href="{{ route('dashboard', ['viewType' => 'plots']) }}" class="inline-flex items-center px-5 py-2 bg-yellow-200 border border-transparent rounded-md font-semibold text-xs text-yellow-900 uppercase tracking-widest hover:bg-yellow-300 focus:bg-yellow-300 active:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                Clear Filters
            </a>
        </div>
    </div>

    <!-- Plots Display Section -->
    <!-- Adjusted padding for the main content area, slightly less than before for a more cohesive look -->
    <div class="p-6 rounded-2xl shadow-xl bg-white">
        @if($plots->isEmpty())
            <!-- Alert for No Plots Available (Yellow themed) -->
            <div class="alert bg-yellow-50 border border-yellow-500 text-yellow-700 px-6 py-4 rounded-lg flex items-center justify-center font-semibold">
                <!-- Info Icon for the alert -->
                <svg class="h-6 w-6 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                No plots available matching your criteria.
            </div>
        @else
            <!-- Increased gap between plot cards for more visual breathing room -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($plots as $plot)
                    <div class="relative bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col h-full border-2 border-yellow-200">
                        @if($plot->is_new_listing)
                            <!-- 'New' Badge with Sparkle Icon -->
                            <div class="badge bg-yellow-500 text-white text-xs font-bold px-4 py-1 rounded-full absolute top-4 right-4 z-10 flex items-center shadow-md">
                                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 2.5a.5.5 0 01.447.276l1.246 2.502 2.766.402a.5.5 0 01.277.854l-2 1.95.472 2.756a.5.5 0 01-.726.527L10 13.974l-2.463 1.295a.5.5 0 01-.726-.527l.472-2.756-2-1.95a.5.5 0 01.277-.854l2.766-.402L9.553 2.776A.5.5 0 0110 2.5z" clip-rule="evenodd"></path>
                                </svg>
                                New
=======
      <h2 class="text-3xl font-bold mb-6 text-black">Available Plots</h2>
                        <div class="flex flex-col sm:flex-row mb-4 gap-4 items-center justify-between">
                            <div class="w-full sm:w-auto">
                                <form action="{{ route('dashboard') }}" method="GET" class="w-full">
                                    <div class="relative">
                                        <input type="text" name="search" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Search plots..." value="{{ request('search') }}">
                                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                </form> 
                            </div>
                            <div class="flex flex-wrap gap-2 w-full sm:w-auto justify-end">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Show New Listings Only</a>
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">Clear Filters</a>
>>>>>>> 67df56b819a11eba0a9cf5598b5b84cc2d3f2ef8:resources/views/customer/plots/index.blade.php
                            </div>
                        @endif
                        <div class="p-6 flex-grow">
                            <!-- Plot Title with Property Icon -->
                            <h5 class="text-xl font-bold text-yellow-800 mb-3 flex items-center">
                                <svg class="h-6 w-6 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                {{ $plot->title }}
                            </h5>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($plot->description, 100) }}</p>
                            <ul class="text-sm text-gray-700 space-y-2">
                                <li class="flex justify-between items-center">
                                    <span><strong class="text-yellow-600">Price:</strong></span>
                                    <span>${{ number_format($plot->price, 2) }}</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span><strong class="text-yellow-600">Area:</strong></span>
                                    <span>{{ number_format($plot->area_sqm, 2) }} sqm</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span><strong class="text-yellow-600">Location:</strong></span>
                                    <span>{{ $plot->location }}</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span><strong class="text-yellow-600">Owner:</strong></span>
                                    <span>{{ $plot->owner->name ?? 'N/A' }}</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span><strong class="text-yellow-600">Listed:</strong></span>
                                    <span>{{ $plot->created_at->format('M d, Y') }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="p-6 border-t border-yellow-100 flex items-center justify-between gap-3">
                            <a href="{{ route('customer.plots.show', $plot->id) }}" class="flex-grow text-center px-4 py-2 bg-yellow-500 text-white rounded-md font-semibold text-sm uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                View Details
                            </a>
                            <!-- Save/Unsave Button with Icons -->
                            @if(Auth::user()->savedPlots->contains($plot))
                                <form action="{{ route('saved-plots.destroy', $plot->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-full text-yellow-600 hover:bg-yellow-100 font-bold flex items-center" title="Unsave Plot">
                                        <!-- Filled Bookmark Icon (Saved) -->
                                        <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                        </svg>
                                        Saved
                                    </button>
                                </form>
                            @else
<<<<<<< HEAD:resources/views/customer/index.blade.php
                                <form action="{{ route('saved-plots.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="plot_id" value="{{ $plot->id }}">
                                    <button type="submit" class="p-2 rounded-full text-yellow-400 hover:bg-yellow-200 font-bold flex items-center" title="Save Plot">
                                        <!-- Outline Bookmark Icon (Save) -->
                                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                        Save
                                    </button>
                                </form>
=======
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($plots as $plot)
                                        <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
                                            @if($plot->is_new_listing)
                                                <div class="badge bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full absolute top-3 right-3 z-10">New</div>
                                            @endif
                                            <div class="p-4 flex-grow">
                                                <h5 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $plot->title }}</h5>
                                                <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                                                    <li class="flex justify-between items-center py-1"><strong>Price:</strong><span>${{ number_format($plot->price, 2) }}</span></li>
                                                    <li class="flex justify-between items-center py-1"><strong>Area:</strong><span>{{ number_format($plot->area_sqm, 2) }} sqm</span></li>
                                                    <li class="flex justify-between items-center py-1"><strong>Location:</strong><span>{{ $plot->location }}</span></li>
                                                    <li class="flex justify-between items-center py-1"><strong>Status:</strong><span>{{ ucfirst($plot->status) }}</span></li>
                                                </ul>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">{{ Str::limit($plot->description, 100) }}</p>

                                            </div>
                                            
                                            <div class="p-4 border-t border-gray-200 dark:border-gray-600 flex items-center justify-between gap-2">
                                                <a href="{{ route('customer.plots.show', ['plot' => $plot->id]) }}" class="flex-grow text-center px-4 py-2 bg-yellow-500 text-white rounded-md font-semibold text-sm uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">View Details</a>
                                                @if(Auth::user()->savedPlots->contains($plot))
                                                    <form action="{{ route('saved-plots.destroy', ['plot_id' => $plot->id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 rounded-full text-red-500 hover:bg-red-100" title="Unsave Plot">
                                                            <i class="fas fa-bookmark text-lg"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('saved-plots.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="plot_id" value="{{ $plot->id }}">
                                                        <button type="submit" class="p-2 rounded-full text-gray-400 hover:bg-gray-200" title="Save Plot">
                                                            <i class="far fa-bookmark text-lg"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-6 flex justify-center">
                                    {{ $plots->appends(request()->query())->links() }}
                                </div>
>>>>>>> 67df56b819a11eba0a9cf5598b5b84cc2d3f2ef8:resources/views/customer/plots/index.blade.php
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Pagination Links -->
            <div class="mt-8 flex justify-center">
                {{ $plots->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-dashboard-layout>
