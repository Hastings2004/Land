<x-dashboard-layout>
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('customer.dashboard') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Dashboard
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-2xl shadow-xl mb-4 transform rotate-3 hover:rotate-0 transition-transform duration-300">
            <i class="fas fa-map-marked-alt text-white text-xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Available Plots</h1>
        <p class="text-gray-600">Discover amazing land investment opportunities</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('info'))
        <div class="fixed top-4 right-4 bg-blue-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce-in">
            <div class="flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                {{ session('info') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce-in">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $statistics['total_plots'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Total Plots</div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map-marked-alt text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ $statistics['available_plots'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Available</div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-blue-600">MK{{ number_format($statistics['avg_price']) }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Avg Price</div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-purple-600">{{ $statistics['new_listings'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">New Listings</div>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
            <!-- Search Bar -->
            <div class="w-full lg:w-96">
                <form action="{{ route('customer.plots.index') }}" method="GET" class="relative">
                    <input type="text" name="search"
                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 bg-gray-50 text-gray-900 placeholder-gray-500 transition-all duration-200"
                        placeholder="Search plots by title, location..."
                        value="{{ request('search') }}">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </form>
            </div>

            <!-- Filters -->
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700">Filter:</span>
                <select name="category" onchange="this.form.submit()" class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 bg-white text-gray-700">
                    <option value="">All Categories</option>
                    <option value="residential" {{ request('category') == 'residential' ? 'selected' : '' }}>Residential</option>
                    <option value="commercial" {{ request('category') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                    <option value="agricultural" {{ request('category') == 'agricultural' ? 'selected' : '' }}>Agricultural</option>
                    <option value="industrial" {{ request('category') == 'industrial' ? 'selected' : '' }}>Industrial</option>
                </select>
                <select name="status" onchange="this.form.submit()" class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 bg-white text-gray-700">
                    <option value="">All Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                </select>
            </div>

            <!-- Sort Options -->
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700">Sort:</span>
                <select name="sort" onchange="this.form.submit()" class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 bg-white text-gray-700">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="area" {{ request('sort') == 'area' ? 'selected' : '' }}>Area</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Plots Content -->
        @if($plots->isEmpty())
        <!-- Beautiful Empty State -->
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="max-w-md mx-auto">
                <!-- Animated Icon -->
                <div class="relative mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                        <i class="fas fa-map-marked-alt text-yellow-500 text-4xl"></i>
                    </div>
                    <!-- Floating Elements -->
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-300 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                    <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-yellow-400 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
                    <div class="absolute top-1/2 -right-4 w-4 h-4 bg-yellow-500 rounded-full animate-bounce" style="animation-delay: 0.6s;"></div>
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-4">No Plots Found</h2>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    We couldn't find any plots matching your search criteria. 
                    Try adjusting your filters or check back later for new listings.
                </p>

                <!-- Feature Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-4 rounded-lg border border-yellow-200">
                        <i class="fas fa-search text-yellow-500 text-xl mb-2"></i>
                        <h3 class="font-semibold text-gray-800 text-sm">Search Plots</h3>
                        <p class="text-gray-600 text-xs">Find your perfect land</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                        <i class="fas fa-bookmark text-green-500 text-xl mb-2"></i>
                        <h3 class="font-semibold text-gray-800 text-sm">Save Favorites</h3>
                        <p class="text-gray-600 text-xs">Bookmark plots you love</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
                        <i class="fas fa-envelope text-blue-500 text-xl mb-2"></i>
                        <h3 class="font-semibold text-gray-800 text-sm">Ask Questions</h3>
                        <p class="text-gray-600 text-xs">Get expert advice</p>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="space-y-4">
                    <a href="{{ route('customer.plots.index') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl hover:from-yellow-600 hover:to-yellow-700 font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-refresh mr-3"></i>
                        Clear Filters
                    </a>
                </div>
            </div>
            </div>
        @else
        <!-- Plots Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($plots as $plot)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                    <!-- Plot Images Carousel -->
                    <div class="relative overflow-hidden">
                        <div class="plot-carousel-{{ $plot->id }} w-full h-48">
                            @if($plot->plotImages->isNotEmpty())
                                <div class="relative w-full h-full">
                                    @foreach($plot->plotImages as $index => $image)
                                        <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?: $plot->title }}" class="carousel-img-{{ $plot->id }} absolute inset-0 w-full h-full object-cover transition-opacity duration-700 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" data-index="{{ $index }}">
                                    @endforeach
                                    @if($plot->plotImages->count() > 1)
                                        <button type="button" onclick="window.prevCarouselImage({{ $plot->id }})" class="absolute left-2 top-1/2 -translate-y-1/2 bg-yellow-500/80 hover:bg-yellow-600 text-white rounded-full p-2 shadow-lg z-20"><i class="fas fa-chevron-left"></i></button>
                                        <button type="button" onclick="window.nextCarouselImage({{ $plot->id }})" class="absolute right-2 top-1/2 -translate-y-1/2 bg-yellow-500/80 hover:bg-yellow-600 text-white rounded-full p-2 shadow-lg z-20"><i class="fas fa-chevron-right"></i></button>
                                        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex space-x-2 z-20">
                                            @foreach($plot->plotImages as $index => $image)
                                                <span class="carousel-dot-{{ $plot->id }} w-2 h-2 rounded-full bg-white border-2 border-yellow-500 cursor-pointer {{ $index === 0 ? 'bg-yellow-500' : '' }}" data-index="{{ $index }}"></span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @elseif($plot->image_path)
                                <img src="{{ asset('storage/' . $plot->image_path) }}" alt="Plot Image" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-yellow-50">
                                    <div class="text-center">
                                        <i class="fas fa-image text-yellow-300 text-3xl mb-2"></i>
                                        <p class="text-xs text-gray-400">No Image</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Image Navigation Dots (if multiple images) -->
                        @if($plot->plotImages->count() > 1)
                            <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-1">
                                @foreach($plot->plotImages as $index => $image)
                                    <button onclick="showImage({{ $plot->id }}, {{ $index }})" 
                                            class="w-2 h-2 rounded-full bg-white/50 hover:bg-white transition-colors duration-200 image-dot-{{ $plot->id }}-{{ $index }} {{ $index === 0 ? 'bg-white' : '' }}"></button>
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Image Counter (if multiple images) -->
                        @if($plot->plotImages->count() > 1)
                            <div class="absolute top-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded-full">
                                <span class="image-counter-{{ $plot->id }}">1</span>/{{ $plot->plotImages->count() }}
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-4 left-4">
                            @if($plot->status === 'available')
                                <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-lg">
                                    Available
                                </span>
                            @elseif($plot->status === 'reserved')
                                <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-lg">
                                    Reserved
                                </span>
                            @elseif($plot->status === 'sold')
                                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-lg">
                                    Sold
                                </span>
                            @endif
                        </div>

                        <!-- New Badge -->
                        @if($plot->is_new_listing)
                            <div class="absolute top-4 right-4">
                                <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-lg flex items-center">
                                    <i class="fas fa-star mr-1"></i>New
                                </span>
                        </div>
                        @endif

                        <!-- Quick Actions Overlay -->
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="flex space-x-2">
                                <button onclick="sharePlot({{ $plot->id }})" 
                                        class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-gray-700 hover:bg-white transition-colors duration-200">
                                    <i class="fas fa-share-alt text-sm"></i>
                                </button>
                            @if(Auth::user()->savedPlots->contains($plot))
                                    <form action="{{ route('customer.saved-plots.destroy', $plot->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" 
                                                class="w-8 h-8 bg-red-500/90 rounded-full flex items-center justify-center text-white hover:bg-red-500 transition-colors duration-200">
                                            <i class="fas fa-heart text-sm"></i>
                                    </button>
                                </form>
                            @else
                                    <form action="{{ route('customer.saved-plots.store') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="plot_id" value="{{ $plot->id }}">
                                        <button type="submit" 
                                                class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-gray-700 hover:bg-white transition-colors duration-200">
                                            <i class="far fa-heart text-sm"></i>
                                    </button>
                                </form>
                            @endif
                            </div>
                        </div>
                    </div>

                    <!-- Plot Details -->
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-yellow-600 transition-colors duration-300">
                            {{ $plot->title }}
                        </h3>
                        <p class="text-gray-600 mb-3 flex items-center">
                            <i class="fas fa-map-marker-alt text-yellow-500 mr-2"></i>
                            {{ $plot->location }}
                        </p>
                        
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($plot->description, 80) }}</p>
                        
                        <!-- Plot Info -->
                        <div class="grid grid-cols-2 gap-3 mb-4 text-sm">
                            <div class="flex items-center">
                                <i class="fas fa-ruler-combined text-yellow-500 mr-2"></i>
                                <span class="text-gray-700">{{ number_format($plot->area_sqm, 2) }} sqm</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-tag text-yellow-500 mr-2"></i>
                                <span class="text-gray-700">{{ ucfirst($plot->category) }}</span>
                            </div>
                        </div>
                        
                        <!-- Price -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-yellow-600">MK{{ number_format($plot->price) }}</span>
                            <span class="text-sm text-gray-500">{{ $plot->created_at->format('M d, Y') }}</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-3">
                            <a href="{{ route('customer.plots.show', $plot->id) }}" 
                               class="flex-1 bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600 transition-colors duration-200 text-center font-semibold text-sm">
                                <i class="fas fa-eye mr-2"></i>View Details
                            </a>
                            <a href="{{ route('customer.inquiries.create') }}?plot_id={{ $plot->id }}" 
                               class="flex-1 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors duration-200 text-center font-semibold text-sm">
                                <i class="fas fa-envelope mr-2"></i>Inquire
                            </a>
                        </div>
                        </div>
                    </div>
                @endforeach
            </div>

        <!-- Pagination -->
        @if($plots->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $plots->appends(request()->query())->links() }}
            </div>
        @endif
    @endif

    <style>
        .animate-bounce-in {
            animation: bounceIn 0.6s ease-out;
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .5;
            }
        }

        /* Carousel styles */
        .carousel-slide {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .carousel-slide.active {
            opacity: 1;
        }

        /* Image hover pause */
        .plot-carousel:hover .carousel-slide {
            transition-duration: 0.3s;
        }
    </style>

    <script>
        // Auto-hide success/error messages after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.querySelectorAll('.fixed');
            messages.forEach(function(message) {
                setTimeout(function() {
                    message.style.transition = 'opacity 0.5s ease-out';
                    message.style.opacity = '0';
                    setTimeout(function() {
                        message.style.display = 'none';
                    }, 500);
                }, 3000);
            });
        });

        // Share plot function
        function sharePlot(plotId) {
            const plotUrl = `${window.location.origin}/customer/plots/${plotId}`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Check out this land plot!',
                    text: 'I found an amazing land plot that might interest you.',
                    url: plotUrl
                })
                .then(() => showNotification('Shared successfully!', 'success'))
                .catch((error) => {
                    console.log('Error sharing:', error);
                    copyToClipboard(plotUrl);
                });
            } else {
                copyToClipboard(plotUrl);
            }
        }

        // Copy to clipboard function
        function copyToClipboard(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    showNotification('Link copied to clipboard!', 'success');
                });
            } else {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showNotification('Link copied to clipboard!', 'success');
            }
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg animate-bounce-in ${
                type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
                    <span>${message}</span>
    </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Image carousel functions
        function showImage(plotId, imageIndex) {
            const carousel = document.querySelector(`.plot-carousel-${plotId}`);
            const slides = carousel.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll(`.image-dot-${plotId}-${imageIndex}`);
            const counter = document.querySelector(`.image-counter-${plotId}`);
            
            // Hide all slides
            slides.forEach(slide => {
                slide.classList.remove('active');
                slide.style.opacity = '0';
            });
            
            // Remove active class from all dots
            document.querySelectorAll(`[class*="image-dot-${plotId}-"]`).forEach(dot => {
                dot.classList.remove('bg-white');
                dot.classList.add('bg-white/50');
            });
            
            // Show selected slide
            slides[imageIndex].classList.add('active');
            slides[imageIndex].style.opacity = '1';
            
            // Update dot
            dots.forEach(dot => {
                dot.classList.add('bg-white');
                dot.classList.remove('bg-white/50');
            });
            
            // Update counter
            if (counter) {
                counter.textContent = imageIndex + 1;
            }
        }

        // Auto-advance carousel for plots with multiple images
        function startCarousel(plotId, totalImages) {
            if (totalImages <= 1) return;
            
            let currentIndex = 0;
            setInterval(() => {
                currentIndex = (currentIndex + 1) % totalImages;
                showImage(plotId, currentIndex);
            }, 4000); // Change image every 4 seconds
        }

        // Initialize carousels when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Start auto-advance for plots with multiple images
            @foreach($plots as $plot)
                @if($plot->plotImages->count() > 1)
                    startCarousel({{ $plot->id }}, {{ $plot->plotImages->count() }});
                @endif
            @endforeach
        });
    </script>
</x-dashboard-layout>
