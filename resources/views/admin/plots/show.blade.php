<x-dashboard-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h2 class="text-3xl font-bold mb-6 text-gray-500 dark:text-black-100">Plot Details: {{ $plot->title }}</h2>

        <div class="p-6 rounded-xl shadow-lg bg-white dark:bg-gray-700">
            @if($plot->is_new_listing)
                <span class="badge bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full mb-4 inline-block">New Listing</span>
            @endif

            <h5 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $plot->title }}</h5>
            <p class="text-gray-600 dark:text-gray-400 text-base mb-6">
                <strong>Description:</strong> {{ $plot->description }}
            </p>

            <ul class="text-base text-gray-700 dark:text-gray-300 space-y-3 mb-6">
                <li class="flex justify-between items-center py-1 border-b border-gray-200 dark:border-gray-600">
                    <strong class="font-semibold">Price:</strong>
                    <span>K{{ number_format($plot->price, 2) }}</span>
                </li>
                <li class="flex justify-between items-center py-1 border-b border-gray-200 dark:border-gray-600">
                    <strong class="font-semibold">Area:</strong>
                    <span>{{ number_format($plot->area_sqm, 2) }} sqm</span>
                </li>
                <li class="flex justify-between items-center py-1 border-b border-gray-200 dark:border-gray-600">
                    <strong class="font-semibold">Location:</strong>
                    <span>{{ $plot->location }}</span>
                </li>
                <li class="flex justify-between items-center py-1">
                    <strong class="font-semibold">Status:</strong>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $plot->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($plot->status) }}
                    </span>
                </li>
            </ul>

            <!-- Reviews Section -->
            <div class="mt-8 border-t pt-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Customer Reviews</h3>
                
                @if($plot->reviews->isEmpty())
                    <p class="text-gray-600">This plot has no reviews yet.</p>
                @else
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-500 flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= round($plot->reviews->avg('rating')) ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                        <span class="ml-2 text-gray-600">({{ number_format($plot->reviews->avg('rating'), 1) }} average from {{ $plot->reviews->count() }} reviews)</span>
                    </div>

                    <div class="space-y-4">
                        @foreach($plot->reviews as $review)
                            <div class="p-4 border rounded-lg bg-gray-50">
                                <div class="flex items-center mb-2">
                                    <p class="font-semibold">{{ $review->user->username }}</p>
                                    <div class="text-yellow-500 flex items-center ml-4">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $review->comment }}</p>
                                <p class="text-xs text-gray-500 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Admin Actions --}}
            @auth
                {{-- Replace 'Auth::user()->isAdmin()' with your actual admin check --}}
                @if(auth()->check() && auth()->user()->isAdmin()) {{-- Assuming 'is_admin' column on User model --}}
                    <div class="flex flex-wrap gap-4 mt-8 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('plots.edit', $plot) }}" 
                           class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Plot
                        </a>

                        <form action="{{ route('plots.destroy', $plot) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plot?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-5 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Delete Plot
                            </button>
                        </form>
                    </div>
                @endif
            @endauth

            <div class="mt-6 text-center">
                <a href="{{ route('plots.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to Plots List
                </a>
            </div>
        </div>
    </div>
</x-dashboard-layout>