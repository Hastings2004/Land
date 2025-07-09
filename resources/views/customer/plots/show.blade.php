@php
    if (auth()->check() && auth()->user()->role === 'admin') {
        echo view('errors.403', ['message' => 'Admins cannot access the customer plot view.']);
        return;
    }
@endphp

<x-dashboard-layout>
    <!-- Back Button (Very Top) -->
    <div class="w-full flex items-start justify-start px-4 pt-6 pb-2">
        <button onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ route('customer.plots.index') }}'" 
                class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-lg shadow transition-colors duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </button>
    </div>
    <div class="max-w-4xl mx-auto py-8">
        {{-- Remove unconditional success/error/info alerts at the top --}}

        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-yellow-200">
            <!-- Responsive Image Carousel -->
            <div class="relative group w-full h-80 md:h-[28rem] bg-gray-100 flex items-center justify-center">
                @if($plot->plotImages->count() > 0)
                    <div id="carousel" class="w-full h-full relative">
                        @foreach($plot->plotImages as $index => $image)
                            <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?: $plot->title }}" class="carousel-img absolute inset-0 w-full h-full object-cover transition-opacity duration-700 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" data-index="{{ $index }}">
                        @endforeach
                        <!-- Carousel Controls -->
                        @if($plot->plotImages->count() > 1)
                            <button onclick="prevImage()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-yellow-500/80 hover:bg-yellow-600 text-white rounded-full p-2 shadow-lg z-20"><i class="fas fa-chevron-left"></i></button>
                            <button onclick="nextImage()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-yellow-500/80 hover:bg-yellow-600 text-white rounded-full p-2 shadow-lg z-20"><i class="fas fa-chevron-right"></i></button>
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-20">
                                @foreach($plot->plotImages as $index => $image)
                                    <span class="carousel-dot w-3 h-3 rounded-full bg-white border-2 border-yellow-500 cursor-pointer {{ $index === 0 ? 'bg-yellow-500' : '' }}" data-index="{{ $index }}"></span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    @if($plot->image_path)
                        <img src="{{ asset('storage/' . $plot->image_path) }}" alt="{{ $plot->title }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://placehold.co/1200x400" alt="{{ $plot->title }}" class="w-full h-full object-cover">
                    @endif
                @endif
            </div>
            <div class="p-8 md:p-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-yellow-500"></i> {{ $plot->title }}
                    </h1>
                    <span class="px-4 py-2 text-lg font-semibold rounded-full shadow-md bg-yellow-100 text-yellow-700 border border-yellow-300">
                        {{ ucfirst($plot->status) }}
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-lg">
                            <i class="fas fa-tag text-yellow-500"></i>
                            <span class="font-semibold">Category:</span>
                            <span class="text-gray-700">{{ ucfirst($plot->category) }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-lg">
                            <i class="fas fa-ruler-combined text-yellow-500"></i>
                            <span class="font-semibold">Area:</span>
                            <span class="text-gray-700">{{ number_format($plot->area_sqm, 2) }} sqm</span>
                        </div>
                        <div class="flex items-center gap-2 text-lg">
                            <i class="fas fa-map-marker-alt text-yellow-500"></i>
                            <span class="font-semibold">Location:</span>
                            <span class="text-gray-700">{{ $plot->location }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-lg">
                            <i class="fas fa-calendar text-yellow-500"></i>
                            <span class="font-semibold">Posted:</span>
                            <span class="text-gray-700">{{ $plot->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end justify-between gap-4">
                        <div class="flex items-center gap-2 text-3xl font-bold text-yellow-600">
                            <i class="fas fa-money-bill-wave"></i>
                            MK{{ number_format($plot->price) }}
                        </div>
                        <div class="flex items-center gap-2 text-gray-500">
                            <i class="fas fa-eye"></i> {{ $plot->views ?? 0 }} views
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Description</h3>
                    <p class="text-gray-700 text-base leading-relaxed">{{ $plot->description }}</p>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mt-8">
                    @if($plot->status === 'available')
                        <form action="{{ route('customer.reservations.store') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="plot_id" value="{{ $plot->id }}">
                            <button type="submit" class="w-full px-6 py-3 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition-colors text-lg shadow-md">Reserve this Plot</button>
                        </form>
                    @elseif($plot->activeReservation && $plot->activeReservation->user_id === Auth::id())
                        <div class="flex-1 text-center p-4 bg-yellow-100 border border-yellow-300 rounded-lg">
                            <p class="font-semibold text-yellow-800">You have reserved this plot.</p>
                            <p class="text-sm text-yellow-700">This reservation expires on {{ $plot->activeReservation->expires_at->format('M d, Y \a\t H:i A') }}.</p>
                            <a href="{{ route('customer.reservations.index') }}" class="mt-2 inline-block text-yellow-600 hover:underline">View My Reservations</a>
                        </div>
                    @else
                        <div class="flex-1 text-center p-4 bg-gray-100 border border-gray-300 rounded-lg">
                            <p class="font-semibold text-gray-800">This plot is not available for reservation.</p>
                        </div>
                    @endif
                    <a href="{{ route('customer.inquiries.create') }}?plot_id={{ $plot->id }}" class="flex-1 px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors text-lg shadow-md text-center flex items-center justify-center">
                        <i class="fas fa-envelope mr-2"></i> Inquire about this Plot
                    </a>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6 border border-yellow-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-star text-yellow-500"></i> Customer Reviews
            </h2>
            @if(session('review_error'))
                <div id="review-error-popout" class="fixed left-1/2 top-0 mt-6 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-xl shadow-2xl z-50 animate-bounce-in flex items-center justify-center" style="max-width: 90vw; min-width: 260px; width: fit-content; font-size: 1rem;">
                    <i class="fas fa-exclamation-triangle mr-3 text-lg"></i>
                    <span class="font-semibold">{{ session('review_error') }}</span>
                </div>
                <script>
                    setTimeout(function() {
                        var el = document.getElementById('review-error-popout');
                        if (el) el.style.display = 'none';
                    }, 5000);
                </script>
            @elseif(session('success'))
                <div id="review-success-popout" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 animate-bounce-in flex items-center" style="max-width: 350px; width: auto;">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <script>
                    setTimeout(function() {
                        var el = document.getElementById('review-success-popout');
                        if (el) el.style.display = 'none';
                    }, 3000);
                </script>
            @endif
            {{-- Remove the old top alert for success if review_error is present --}}
            @if(session('success') && !session('review_error'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
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
            @if(auth()->user()->role === 'customer')
                @php
                    // 1. Check if the user has already left a review
            $hasReviewed = $plot->reviews()->where('user_id', Auth::id())->exists();

            // 2. Check if the user has a completed reservation for this plot
            $hasCompletedReservation = auth()->user()->reservations()
                ->where('plot_id', $plot->id)
                ->where('status', 'completed')
                ->exists();

            // The user can review only if they have a completed reservation AND haven't reviewed yet.
            $canReview = $hasCompletedReservation && !$hasReviewed;
                @endphp
                @if($canReview)
                    <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Leave a Review</h2>
                        <form id="reviewForm" action="{{ url('customer/reviews') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="plot_id" value="{{ $plot->id }}">
                            <input type="hidden" name="rating" id="starRatingInput" value="5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Your Rating</label>
                                <div id="starRating" class="flex items-center space-x-1 text-2xl cursor-pointer select-none">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-yellow-400 star transition-transform duration-150 hover:scale-125 focus:scale-125 outline-none" data-value="{{ $i }}" tabindex="0"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="relative">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Your Comment</label>
                                <textarea name="comment" id="comment" rows="5" maxlength="500" class="block w-full p-4 border border-gray-300 rounded-xl shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-400 focus:outline-none resize-none transition-all duration-200 text-gray-800 placeholder-gray-400" placeholder="Share your experience or feedback here..."></textarea>
                                <span id="charCount" class="absolute top-3 right-4 text-xs text-gray-400 bg-white bg-opacity-80 px-2 rounded select-none pointer-events-none">0/500</span>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="px-6 py-3 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-400 transition-all duration-200 shadow-md">Submit Review</button>
                            </div>
                        </form>
                    </div>
                    <script>
                    // Interactive star rating
                    const stars = document.querySelectorAll('#starRating .star');
                    const ratingInput = document.getElementById('starRatingInput');
                    let currentRating = 5;
                    stars.forEach((star, idx) => {
                        star.addEventListener('mouseenter', () => highlightStars(idx + 1));
                        star.addEventListener('mouseleave', () => highlightStars(currentRating));
                        star.addEventListener('click', () => {
                            currentRating = idx + 1;
                            ratingInput.value = currentRating;
                            highlightStars(currentRating);
                        });
                        star.addEventListener('focus', () => highlightStars(idx + 1));
                        star.addEventListener('blur', () => highlightStars(currentRating));
                        star.addEventListener('keydown', (e) => {
                            if (e.key === 'Enter' || e.key === ' ') {
                                currentRating = idx + 1;
                                ratingInput.value = currentRating;
                                highlightStars(currentRating);
                            }
                        });
                    });
                    function highlightStars(rating) {
                        stars.forEach((star, i) => {
                            star.classList.toggle('text-yellow-400', i < rating);
                            star.classList.toggle('text-gray-300', i >= rating);
                        });
                    }
                    highlightStars(currentRating);
                    // Live character count
                    const commentBox = document.getElementById('comment');
                    const charCount = document.getElementById('charCount');
                    commentBox.addEventListener('input', function() {
                        charCount.textContent = this.value.length + '/500';
                    });
                    // Toast confirmation (optional, can be removed if not needed)
                    document.getElementById('reviewForm').addEventListener('submit', function(e) {
                        setTimeout(() => {
                            showReviewToast('Thank you for your review!');
                        }, 100);
                    });
                    function showReviewToast(message) {
                        const toast = document.createElement('div');
                        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-bounce-in';
                        toast.innerHTML = `<div class='flex items-center'><i class='fas fa-check-circle mr-2'></i>${message}</div>`;
                        document.body.appendChild(toast);
                        setTimeout(() => {
                            toast.classList.add('opacity-0');
                            setTimeout(() => { toast.remove(); }, 500);
                        }, 2500);
                    }
                    </script>
                @endif
            @endif
        @endauth
    </div>
</x-dashboard-layout>

<script>
// Carousel interactivity
let currentIndex = 0;
const images = document.querySelectorAll('.carousel-img');
const dots = document.querySelectorAll('.carousel-dot');
function showImage(idx) {
    images.forEach((img, i) => {
        img.classList.toggle('opacity-100', i === idx);
        img.classList.toggle('z-10', i === idx);
        img.classList.toggle('opacity-0', i !== idx);
        img.classList.toggle('z-0', i !== idx);
    });
    dots.forEach((dot, i) => {
        dot.classList.toggle('bg-yellow-500', i === idx);
        dot.classList.toggle('bg-white', i !== idx);
    });
    currentIndex = idx;
}
function prevImage() {
    let idx = currentIndex - 1;
    if (idx < 0) idx = images.length - 1;
    showImage(idx);
}
function nextImage() {
    let idx = (currentIndex + 1) % images.length;
    showImage(idx);
}
dots.forEach((dot, i) => {
    dot.addEventListener('click', () => showImage(i));
});
let autoSlide = setInterval(() => nextImage(), 4000);
document.getElementById('carousel').addEventListener('mouseenter', () => clearInterval(autoSlide));
document.getElementById('carousel').addEventListener('mouseleave', () => { autoSlide = setInterval(() => nextImage(), 4000); });
showImage(0);
</script> 