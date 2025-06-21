@php use Illuminate\Support\Str; @endphp
<x-dashboard-layout>
    <h2 class="text-3xl font-bold mb-6 text-black">Available Plots</h2>
    <div class="flex flex-col sm:flex-row mb-4 gap-4 items-center justify-between">
        <div class="w-full sm:w-auto">
            <form action="{{ route('plots.search') }}" method="GET" class="w-full flex flex-wrap gap-2 items-center">
                <div class="relative flex-1 min-w-[120px]">
                    <input type="text" name="title" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Title" value="{{ request('title') }}">
                    <i class="fas fa-heading absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="relative flex-1 min-w-[120px]">
                    <input type="text" name="description" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Description" value="{{ request('description') }}">
                    <i class="fas fa-align-left absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="relative flex-1 min-w-[120px]">
                    <input type="text" name="location" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Location" value="{{ request('location') }}">
                    <i class="fas fa-map-marker-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="relative flex-1 min-w-[100px]">
                    <input type="number" step="0.01" name="price" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Price" value="{{ request('price') }}">
                    <i class="fas fa-dollar-sign absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="relative flex-1 min-w-[120px]">
                    <select name="status" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        <option value="">Any Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                        <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                    </select>
                    <i class="fas fa-check-circle absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </form>
        </div>
        <div class="flex flex-wrap gap-2 w-full sm:w-auto justify-end">
            <a href="{{ route('plots.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">Clear Filters</a>
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
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">{{ Str::limit($plot->description, 100) }}</p>
                            <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                                <li class="flex justify-between items-center py-1"><strong>Price:</strong><span>${{ number_format($plot->price, 2) }}</span></li>
                                <li class="flex justify-between items-center py-1"><strong>Area:</strong><span>{{ number_format($plot->area_sqm, 2) }} sqm</span></li>
                                <li class="flex justify-between items-center py-1"><strong>Location:</strong><span>{{ $plot->location }}</span></li>
                            </ul>
                        </div>
                        <div class="p-4 border-t border-gray-200 dark:border-gray-600">
                            <a href="{{ route('plots.show', $plot->id) }}" class="block w-full text-center px-4 py-2 bg-yellow-500 text-white rounded-md font-semibold text-sm uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">View Details</a>
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