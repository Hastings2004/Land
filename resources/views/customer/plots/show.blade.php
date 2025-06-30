<x-dashboard-layout>
    <div class="max-w-4xl mx-auto py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if(session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <img src="{{ $plot->image_path ? asset('storage/' . $plot->image_path) : 'https://placehold.co/1200x400' }}" alt="{{ $plot->title }}" class="w-full h-64 object-cover">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $plot->title }}</h1>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                        @switch($plot->status)
                            @case('available') bg-green-200 text-green-800 @break
                            @case('reserved') bg-yellow-200 text-yellow-800 @break
                            @case('sold') bg-red-200 text-red-800 @break
                        @endswitch">
                        {{ ucfirst($plot->status) }}
                    </span>
                </div>
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
                <div class="mt-8 border-t pt-6">
                    @if($plot->status === 'available')
                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plot_id" value="{{ $plot->id }}">
                            <button type="submit" class="w-full px-6 py-3 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition-colors">
                                Reserve this Plot
                            </button>
                        </form>
                    @elseif($plot->activeReservation && $plot->activeReservation->user_id === Auth::id())
                        <div class="text-center p-4 bg-yellow-100 border border-yellow-300 rounded-lg">
                            <p class="font-semibold text-yellow-800">You have reserved this plot.</p>
                            <p class="text-sm text-yellow-700">This reservation expires on {{ $plot->activeReservation->expires_at->format('M d, Y \a\t H:i A') }}.</p>
                            <a href="{{ route('reservations.index') }}" class="mt-2 inline-block text-yellow-600 hover:underline">View My Reservations</a>
                        </div>
                    @else
                        <div class="text-center p-4 bg-gray-100 border border-gray-300 rounded-lg">
                            <p class="font-semibold text-gray-800">This plot is not available for reservation.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Customer Reviews</h2>
            
            @if($plot->reviews->isEmpty())
                <p class="text-gray-600">No reviews yet. Be the first to review this plot!</p>
            @else
                <div class="flex items-center mb-4">
                    <div class="text-yellow-500 flex items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= round($plot->reviews->avg('rating')) ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                    </div>
                    <span class="ml-2 text-gray-600">({{ number_format($plot->reviews->avg('rating'), 1) }} out of 5)</span>
                </div>

                <div class="space-y-4">
                    @foreach($plot->reviews as $review)
                        <div class="p-4 border rounded-lg">
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

        <!-- Review Form -->
        @auth
            @php
                $canReview = Auth::user()->reservations()->where('plot_id', $plot->id)->where('status', 'completed')->exists();
                $hasReviewed = $plot->reviews()->where('user_id', Auth::id())->exists();
            @endphp

            @if($canReview && !$hasReviewed)
                <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Leave a Review</h2>
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plot_id" value="{{ $plot->id }}">
                        
                        <div class="mb-4">
                            <label for="rating" class="block text-sm font-medium text-gray-700">Your Rating</label>
                            <select name="rating" id="rating" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700">Your Comment</label>
                            <textarea name="comment" id="comment" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-3 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition-colors">Submit Review</button>
                        </div>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</x-dashboard-layout> 