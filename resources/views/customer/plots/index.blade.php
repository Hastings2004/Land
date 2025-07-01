<x-dashboard-layout>
    <!-- Page Title -->
    <!-- Increased bottom margin for better separation from the search/filter section -->
    <h2 class="text-3xl font-bold mb-10 text-yellow-700 text-center">Available Plots</h2>

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
                            </div>
                        @endif
                        <!-- Plot Image -->
                        <div class="w-full h-48 flex items-center justify-center mb-4 bg-yellow-50 rounded-lg overflow-hidden border border-yellow-100">
                            @if(!empty($plot->image_path))
                                <img src="{{ asset('storage/' . $plot->image_path) }}" alt="Plot Image" class="object-cover w-full h-full">
                            @else
                                <img src="https://via.placeholder.com/400x200?text=No+Image" alt="No Image" class="object-cover w-full h-full">
                            @endif
                        </div>
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
                                    <span><strong class="text-yellow-600">Category:</strong></span>
                                    <span>{{ $plot->category }}</span>
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
