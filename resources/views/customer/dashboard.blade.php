<x-dashboard-layout>
    <div class="p-6">
        <!-- Premium Welcome Banner -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 mb-8 border border-yellow-300 relative overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <!-- Left Side - Greeting -->
                <div class="text-left">
                    <div class="mb-4">
                        <h1 class="text-3xl md:text-4xl font-bold text-yellow-500 mb-2 leading-tight">
                            <span id="greeting" class="bg-gradient-to-r from-yellow-400 to-yellow-500 bg-clip-text text-transparent">Good Morning</span>, {{ auth()->user()->username }} <span id="wave-emoji">👋</span>
                        </h1>
                        <p class="text-gray-800 text-base font-medium">
                            Welcome to your investment journey
                        </p>
                    </div>
                </div>

                <!-- Right Side - Quote -->
                <div class="text-right">
                    <p class="text-yellow-500 text-lg font-medium italic mb-3 leading-relaxed" id="quote">
                        "The best investment you can make is in yourself."
                    </p>
                    <p class="text-gray-700 font-bold text-base" id="quote-author">
                        Warren Buffett
                    </p>
            </div>
        </div>
    </div>

        <!-- Interactive Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Saved Plots Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-yellow-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer metrics-card" onclick="window.location.href='{{ route('customer.saved-plots.index') }}'">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl">
                            <i class="fas fa-bookmark text-yellow-600 text-2xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-yellow-600 metrics-number" id="saved-plots-count">{{ $stats['savedPlots'] }}</div>
                        <div class="text-xs text-yellow-500 font-medium">Saved</div>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Saved Plots</h3>
                <p class="text-gray-600 text-sm">Your favorite land investments</p>
                </div>

                <!-- Reservations Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-yellow-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer metrics-card" onclick="window.location.href='{{ route('customer.reservations.index') }}'">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 rounded-xl">
                        <i class="fas fa-calendar-check text-green-600 text-2xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-green-600 metrics-number" id="reservations-count">{{ $stats['reservations'] }}</div>
                        <div class="text-xs text-green-500 font-medium">Active</div>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Reservations</h3>
                <p class="text-gray-600 text-sm">Your current bookings</p>
                </div>

                <!-- Inquiries Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-yellow-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer metrics-card" onclick="window.location.href='{{ route('customer.inquiries.index') }}'">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl">
                        <i class="fas fa-envelope text-blue-600 text-2xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-blue-600 metrics-number" id="inquiries-count">{{ $stats['inquiries'] }}</div>
                        <div class="text-xs text-blue-500 font-medium">Sent</div>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Inquiries</h3>
                <p class="text-gray-600 text-sm">Your messages to agents</p>
            </div>
            </div>

        <!-- Quick Actions Section - Moved here after metrics -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-yellow-200 mb-8">
            <div class="flex items-center mb-6">
                <div class="p-3 bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-xl shadow-md">
                    <i class="fas fa-bolt text-yellow-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">Quick Actions</h3>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 gap-4 md:gap-6">
                <!-- Browse Plots -->
                <div class="quick-action-card group" onclick="navigateTo('{{ route('customer.plots.index') }}')">
                    <div class="p-4 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl mb-3 group-hover:from-yellow-200 group-hover:to-yellow-300 transition-all duration-300">
                        <i class="fas fa-search text-yellow-500 text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 text-sm mb-1 group-hover:text-yellow-600 transition-colors duration-300">Browse Plots</h4>
                    <p class="text-gray-500 text-xs">Find your perfect land</p>
                    <div class="mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <i class="fas fa-arrow-right text-yellow-500 text-xs"></i>
                    </div>
                </div>

                <!-- New Inquiry -->
                <div class="quick-action-card group" onclick="navigateTo('{{ route('customer.inquiries.create') }}')">
                    <div class="p-4 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl mb-3 group-hover:from-yellow-200 group-hover:to-yellow-300 transition-all duration-300">
                        <i class="fas fa-plus text-yellow-500 text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 text-sm mb-1 group-hover:text-yellow-600 transition-colors duration-300">New Inquiry</h4>
                    <p class="text-gray-500 text-xs">Ask about properties</p>
                    <div class="mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <i class="fas fa-arrow-right text-yellow-500 text-xs"></i>
                    </div>
                </div>

                <!-- View Profile -->
                <div class="quick-action-card group" onclick="navigateTo('{{ route('profile.edit') }}')">
                    <div class="p-4 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl mb-3 group-hover:from-yellow-200 group-hover:to-yellow-300 transition-all duration-300">
                        <i class="fas fa-user text-yellow-500 text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 text-sm mb-1 group-hover:text-yellow-600 transition-colors duration-300">My Profile</h4>
                    <p class="text-gray-500 text-xs">Update information</p>
                    <div class="mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <i class="fas fa-arrow-right text-yellow-500 text-xs"></i>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="quick-action-card group" onclick="contactSupport()">
                    <div class="p-4 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl mb-3 group-hover:from-yellow-200 group-hover:to-yellow-300 transition-all duration-300">
                        <i class="fas fa-headset text-yellow-500 text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 text-sm mb-1 group-hover:text-yellow-600 transition-colors duration-300">Support</h4>
                    <p class="text-gray-500 text-xs">Get help</p>
                    <div class="mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <i class="fas fa-arrow-right text-yellow-500 text-xs"></i>
                    </div>
                    </div>
                </div>
            </div>

        <!-- Recommended Plots Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-yellow-200 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-star text-yellow-500 mr-3 animate-pulse"></i>
                    Recommended Plots
                </h3>
                <a href="{{ route('customer.plots.index') }}" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium flex items-center group-hover:scale-105 transition-all duration-300">
                    View All <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>
            
            @if($recommendedPlots->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4 md:gap-6">
                    @foreach($recommendedPlots as $plot)
                        <div class="recommended-plot-card bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group cursor-pointer" 
                             onclick="window.location.href='{{ route('customer.plots.show', $plot->id) }}'">
                            <!-- Plot Image Carousel -->
                            <div class="relative mb-4 overflow-hidden rounded-lg">
                                @if($plot->plotImages && $plot->plotImages->count() > 1)
                                    <div class="carousel relative w-full h-48 md:h-52 lg:h-48" data-plot-id="{{ $plot->id }}">
                                        @foreach($plot->plotImages as $index => $image)
                                            <img src="{{ $image->image_url }}" alt="{{ $plot->title }}" class="carousel-img-{{ $plot->id }} w-full h-48 md:h-52 lg:h-48 object-cover rounded-lg shadow-sm absolute inset-0 transition-opacity duration-500 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" data-index="{{ $index }}">
                                        @endforeach
                                        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex space-x-1 z-10">
                                            @foreach($plot->plotImages as $index => $image)
                                                <button type="button" class="carousel-dot-{{ $plot->id }} w-2 h-2 rounded-full bg-yellow-400 mx-1 focus:outline-none {{ $index === 0 ? 'ring-2 ring-yellow-600' : '' }}" data-index="{{ $index }}"></button>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($plot->plotImages && $plot->plotImages->count() > 0)
                                    <img src="{{ $plot->plotImages->first()->image_url }}"
                                         alt="{{ $plot->title }}"
                                         class="w-full h-48 md:h-52 lg:h-48 object-cover rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-700">
                                @elseif($plot->image_path)
                                    <img src="{{ asset('storage/' . $plot->image_path) }}"
                                         alt="{{ $plot->title }}"
                                         class="w-full h-48 md:h-52 lg:h-48 object-cover rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <img src="https://placehold.co/300x200"
                                         alt="{{ $plot->title }}"
                                         class="w-full h-48 md:h-52 lg:h-48 object-cover rounded-lg shadow-sm group-hover:scale-110 transition-transform duration-700">
                                @endif
                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg"></div>
                                <!-- Category Badge -->
                                <div class="absolute top-3 left-3 z-10">
                                    <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-lg group-hover:bg-yellow-600 transition-colors duration-300">
                                        {{ ucfirst($plot->category) }}
                                    </span>
                                </div>
                                <!-- Views Badge -->
                                <div class="absolute top-3 right-3 z-10">
                                    <span class="bg-black bg-opacity-70 text-white text-xs px-3 py-1 rounded-full flex items-center shadow-lg backdrop-blur-sm">
                                        <i class="fas fa-eye mr-1"></i>
                                        {{ $plot->views }}
                                    </span>
                                </div>
                                <!-- Quick Action Overlay -->
                                <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                    <div class="flex space-x-2">
                                        <button onclick="event.stopPropagation(); savePlot({{ $plot->id }})" 
                                                class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg font-medium text-sm transition-all duration-300 flex items-center justify-center shadow-lg">
                                            <i class="fas fa-bookmark mr-1"></i>
                                            Save
                                        </button>
                                        <button onclick="event.stopPropagation(); sharePlot({{ $plot->id }})" 
                                                class="bg-white hover:bg-gray-100 text-gray-700 px-3 py-2 rounded-lg font-medium text-sm transition-all duration-300 flex items-center justify-center shadow-lg">
                                            <i class="fas fa-share-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Plot Details -->
                            <div class="space-y-3">
                                <h4 class="font-bold text-gray-900 text-lg group-hover:text-yellow-600 transition-colors duration-300 line-clamp-2">
                                    {{ $plot->title }}
                                </h4>
                                <p class="text-sm text-gray-600 flex items-center line-clamp-1">
                                    <i class="fas fa-map-marker-alt text-yellow-500 mr-2 flex-shrink-0"></i>
                                    <span class="truncate">{{ $plot->location }}</span>
                                </p>
                                <div class="flex items-center justify-between text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <i class="fas fa-ruler-combined text-yellow-500 mr-1"></i>
                                        {{ number_format($plot->area_sqm) }} sqm
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar-alt text-yellow-500 mr-1"></i>
                                        {{ $plot->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <!-- Admin Name -->
                                {{-- <div class="flex items-center text-xs text-gray-500">
                                    <i class="fas fa-user-shield text-yellow-500 mr-1"></i>
                                    Posted by: <span class="ml-1 font-semibold text-yellow-700">{{ $plot->admin->name ?? 'Admin' }}</span>
                                </div> --}}
                                <!-- Price Section -->
                                <div class="flex items-center justify-between pt-3 border-t border-yellow-200">
                                    <div class="flex-1">
                                        <p class="text-2xl font-bold text-yellow-600 group-hover:scale-105 transition-transform duration-300">K{{ number_format($plot->price) }}</p>
                                        <p class="text-xs text-gray-500">Total Price</p>
                                    </div>
                                    <!-- Status Indicator -->
                                    <div class="flex items-center">
                                        @if($plot->status === 'available')
                                            <span class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                            <span class="text-xs text-green-600 font-medium">Available</span>
                                        @elseif($plot->status === 'reserved')
                                            <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2 animate-pulse"></span>
                                            <span class="text-xs text-yellow-600 font-medium">Reserved</span>
                                        @elseif($plot->status === 'sold')
                                            <span class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                                            <span class="text-xs text-red-600 font-medium">Sold</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Latest Review Snippet -->
                                @if($plot->reviews && $plot->reviews->count() > 0)
                                    @php $review = $plot->reviews->sortByDesc('created_at')->first(); @endphp
                                    <div class="mt-2 bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded flex items-start gap-2">
                                        <i class="fas fa-star text-yellow-500 mt-1"></i>
                                        <div>
                                            <div class="flex items-center gap-1">
                                                <span class="font-semibold text-yellow-700 text-sm">{{ $review->user->name ?? 'Customer' }}</span>
                                                <span class="text-xs text-gray-400">&middot; {{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="flex items-center mb-1">
                                                @for($i=0; $i<$review->rating; $i++)
                                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                                @endfor
                                                @for($i=$review->rating; $i<5; $i++)
                                                    <i class="far fa-star text-yellow-200 text-xs"></i>
                                                @endfor
                                            </div>
                                            <p class="text-gray-700 text-xs line-clamp-2">{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                        <i class="fas fa-star text-yellow-500 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 text-lg mb-2">No recommended plots available</p>
                    <p class="text-gray-400 text-sm mb-6">Start exploring plots to get personalized recommendations!</p>
                    <a href="{{ route('customer.plots.index') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-search mr-2"></i>
                        Browse All Plots
                    </a>
                </div>
            @endif
        </div>

        <!-- Recent Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Recent Saved Plots -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-yellow-200">
                    <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-bookmark text-yellow-500 mr-3"></i>
                            Recent Saved Plots
                        </h3>
                        <a href="{{ route('customer.saved-plots.index') }}" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium flex items-center">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    @if($recentSavedPlots->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentSavedPlots as $plot)
                                <div class="flex items-center space-x-4 p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl hover:shadow-md transition-all duration-300">
                                    <img src="
                                        @if($plot->plotImages && $plot->plotImages->count() > 0)
                                            {{ $plot->plotImages->first()->image_url }}
                                        @elseif($plot->image_path)
                                            {{ asset('storage/' . $plot->image_path) }}
                                        @else
                                            https://placehold.co/300x200
                                        @endif
                                    " alt="{{ $plot->title }}"
                                    class="w-28 h-20 object-cover rounded-xl shadow-sm">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 text-lg">{{ $plot->title }}</h4>
                                        @if(Str::contains($plot->location, 'Area'))
                                            <p class="text-sm text-yellow-700 font-bold flex items-center mb-1">
                                                <i class="fas fa-map-marker-alt text-yellow-500 mr-1"></i>
                                                {{ collect(explode(',', $plot->location))->filter(fn($part) => Str::contains($part, 'Area'))->implode(', ') }}
                                            </p>
                                        @endif
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-map-marker-alt text-yellow-500 mr-1"></i>
                                            {{ $plot->location }}
                                        </p>
                                        <p class="text-lg font-bold text-yellow-600">K{{ number_format($plot->price) }}</p>
                                    </div>
                                    <a href="{{ route('customer.plots.show', $plot->id) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        View
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-bookmark text-yellow-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 text-lg">No saved plots yet</p>
                            <p class="text-gray-400 text-sm">Start exploring and save your favorite plots!</p>
                        <a href="{{ route('customer.plots.index') }}" class="mt-4 inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Browse Plots
                        </a>
                        </div>
                    @endif
                </div>

                <!-- Active Reservations -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-yellow-200">
                    <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-calendar-check text-green-500 mr-3"></i>
                            Active Reservations
                        </h3>
                    <a href="{{ route('customer.reservations.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium flex items-center">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    @if($activeReservations->count() > 0)
                        <div class="space-y-4">
                            @foreach($activeReservations as $reservation)
                            <div class="p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border-l-4 border-green-500">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <img src="{{ $reservation->plot->image_path ? asset('storage/' . $reservation->plot->image_path) : 'https://placehold.co/60x60' }}"
                                             alt="{{ $reservation->plot->title }}"
                                             class="w-12 h-12 object-cover rounded-lg">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900">{{ $reservation->plot->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $reservation->plot->location }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm">
                                            <p class="text-gray-600">Expires: {{ $reservation->expires_at->format('M d, Y') }}</p>
                                        <p class="text-green-600 font-semibold">{{ $reservation->expires_at->diffForHumans() }}</p>
                                        </div>
                                        <a href="{{ route('customer.plots.show', $reservation->plot->id) }}"
                                       class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm font-medium transition-colors">
                                            View
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-calendar-check text-green-500 text-xl"></i>
                        </div>
                        <p class="text-gray-500">No active reservations</p>
                        <a href="{{ route('customer.plots.index') }}" class="mt-3 inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Browse Plots
                        </a>
                    </div>
                @endif
            </div>
                        </div>
    </div>

    <!-- Save Plot Modal -->
    <div id="savePlotModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm w-full text-center">
            <div id="savePlotModalIcon" class="mb-4 text-4xl"></div>
            <div id="savePlotModalMessage" class="text-lg font-semibold mb-6"></div>
            <button onclick="closeSavePlotModal()" class="px-6 py-2 bg-yellow-500 text-white rounded-lg font-bold hover:bg-yellow-600 transition">OK</button>
        </div>
    </div>

    <style>
        .quick-action-card {
            @apply bg-white rounded-xl p-4 border border-gray-200 hover:border-yellow-300 hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2;
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .quick-action-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-bounce-in {
            animation: bounceIn 0.6s ease-out;
        }

        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }

        /* Responsive adjustments for quick actions */
        @media (max-width: 640px) {
            .quick-action-card {
                min-height: 120px;
                padding: 0.75rem;
            }
        }

        @media (max-width: 768px) {
            .quick-action-card {
                min-height: 130px;
            }
        }

        /* Recommended Plots Card Styles */
        .recommended-plot-card {
            position: relative;
            overflow: hidden;
        }

        .recommended-plot-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .recommended-plot-card:hover::before {
            left: 100%;
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Responsive adjustments for recommended plots */
        @media (max-width: 640px) {
            .recommended-plot-card {
                margin-bottom: 1rem;
            }
            
            .recommended-plot-card img {
                height: 200px;
            }
        }

        @media (max-width: 768px) {
            .recommended-plot-card {
                margin-bottom: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .recommended-plot-card:hover {
                transform: translateY(-8px) scale(1.02);
            }
        }

        /* Metrics Cards Jumping Animation */
        @keyframes jump {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            50% {
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
        }

        .metrics-card {
            animation: jump 2s ease-in-out infinite, pulse-glow 3s ease-in-out infinite;
        }

        .metrics-card:nth-child(1) {
            animation-delay: 0s;
        }

        .metrics-card:nth-child(2) {
            animation-delay: 0.3s;
        }

        .metrics-card:nth-child(3) {
            animation-delay: 0.6s;
        }

        .metrics-number {
            animation: pulse 2s ease-in-out infinite;
        }
    </style>

    <script>
        // Notification function for quick actions and other messages
        function showNotification(message, type = 'info') {
            let notification = document.getElementById('custom-notification');
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'custom-notification';
                notification.style.position = 'fixed';
                notification.style.top = '30px';
                notification.style.right = '30px';
                notification.style.zIndex = 9999;
                notification.style.minWidth = '200px';
                notification.style.padding = '16px 24px';
                notification.style.borderRadius = '8px';
                notification.style.boxShadow = '0 4px 12px rgba(0,0,0,0.08)';
                notification.style.fontWeight = 'bold';
                notification.style.fontSize = '16px';
                notification.style.transition = 'opacity 0.3s';
                notification.style.opacity = 0;
                document.body.appendChild(notification);
            }
            notification.textContent = message;
            notification.style.background = type === 'success' ? '#facc15' : (type === 'error' ? '#f87171' : '#38bdf8');
            notification.style.color = type === 'error' ? '#fff' : '#1e293b';
            notification.style.opacity = 1;
            setTimeout(() => {
                notification.style.opacity = 0;
            }, 1800);
        }

        // Navigation function with loading state
        function navigateTo(url) {
            showNotification('Navigating...', 'info');
            setTimeout(() => {
                window.location.href = url;
            }, 500);
        }

        // Time-based greeting and emoji
        function updateGreeting() {
            const hour = new Date().getHours();
            const greetingElement = document.getElementById('greeting');
            const waveEmojiElement = document.getElementById('wave-emoji');
            
            let greeting, waveEmoji;
            
            if (hour >= 5 && hour < 12) {
                greeting = 'Good Morning';
                waveEmoji = '👋';
            } else if (hour >= 12 && hour < 17) {
                greeting = 'Good Afternoon';
                waveEmoji = '👋';
            } else if (hour >= 17 && hour < 21) {
                greeting = 'Good Evening';
                waveEmoji = '👋';
            } else {
                greeting = 'Good Night';
                waveEmoji = '👋';
            }
            
            greetingElement.textContent = greeting;
            waveEmojiElement.textContent = waveEmoji;
        }

        // Rotating quotes
        const quotes = [
            {
                text: "The best investment you can make is in yourself.",
                author: "Warren Buffett"
            },
            {
                text: "Land is the only thing in the world worth working for, worth fighting for, worth dying for.",
                author: "Margaret Mitchell"
            },
            {
                text: "Real estate cannot be lost or stolen, nor can it be carried away.",
                author: "Franklin D. Roosevelt"
            },
            {
                text: "Buy land, they're not making it anymore.",
                author: "Mark Twain"
            },
            {
                text: "The land is where our roots are. The children must be taught to feel and live in harmony with the Earth.",
                author: "Maria Montessori"
            },
            {
                text: "Every piece of land has a story to tell.",
                author: "Unknown"
            },
            {
                text: "Land is the basis of all wealth.",
                author: "John Locke"
            },
            {
                text: "The earth is what we all have in common.",
                author: "Wendell Berry"
            }
        ];

        let currentQuoteIndex = 0;

        function updateQuote() {
            const quoteElement = document.getElementById('quote');
            const authorElement = document.getElementById('quote-author');
            
            const quote = quotes[currentQuoteIndex];
            quoteElement.textContent = `"${quote.text}"`;
            authorElement.textContent = quote.author;
            
            currentQuoteIndex = (currentQuoteIndex + 1) % quotes.length;
        }

        // Contact support function
        function contactSupport() {
            openContactModal();
        }

        // Show Save Plot Modal
        function showSavePlotModal(message, type = 'success', reloadOnClose = false) {
            const modal = document.getElementById('savePlotModal');
            const icon = document.getElementById('savePlotModalIcon');
            const msg = document.getElementById('savePlotModalMessage');
            if (type === 'success') {
                icon.innerHTML = '<i class="fas fa-check-circle text-green-500"></i>';
            } else if (type === 'info') {
                icon.innerHTML = '<i class="fas fa-info-circle text-blue-500"></i>';
            } else {
                icon.innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i>';
            }
            msg.textContent = message;
            modal.classList.remove('hidden');
            // Attach reload handler if needed
            const okBtn = modal.querySelector('button');
            okBtn.onclick = function() {
                modal.classList.add('hidden');
                if (reloadOnClose) {
                    window.location.reload();
                }
            };
        }

        // Close Save Plot Modal
        function closeSavePlotModal() {
            document.getElementById('savePlotModal').classList.add('hidden');
        }

        // Save plot function
        function savePlot(plotId) {
            const formData = new FormData();
            formData.append('plot_id', plotId);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('{{ route("customer.saved-plots.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                // Handle common error status codes
                if (response.status === 419) {
                    showSavePlotModal('Session expired. Please refresh the page and log in again.', 'error', false);
                    return;
                }
                if (response.status === 401) {
                    showSavePlotModal('You must be logged in to save a plot.', 'error', false);
                    return;
                }
                if (response.status === 403) {
                    showSavePlotModal('Permission denied. Please log in as a customer.', 'error', false);
                    return;
                }
                if (response.status === 500) {
                    showSavePlotModal('Server error. Please try again later.', 'error', false);
                    return;
                }
                if (response.status === 302) {
                    showSavePlotModal('Session expired. Please log in again.', 'error', false);
                    return;
                }
                let data;
                try {
                    data = await response.json();
                } catch (e) {
                    // If status is 200 but not JSON, assume success (workaround for backend redirect/HTML)
                    if (response.status === 200) {
                        showSavePlotModal('Plot saved successfully!', 'success', true);
                        return;
                    } else {
                        showSavePlotModal('Unexpected error. Please refresh the page and try again.', 'error', false);
                        return;
                    }
                }
                if (data.success) {
                    showSavePlotModal('Plot saved successfully!', 'success', true);
                } else {
                    showSavePlotModal(data.message || 'You have already saved this plot.', 'info', false);
                }
            })
            .catch(error => {
                showSavePlotModal('Network error. Please check your connection and try again.', 'error', false);
            });
        }

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
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showNotification('Link copied to clipboard!', 'success');
            }
        }

        // Add loading animation to plot cards
        function addLoadingAnimation() {
            const cards = document.querySelectorAll('.recommended-plot-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('animate-fade-in');
            });
        }

        // Real-time metrics update function
        function updateMetrics() {
            // Simulate real-time updates (in a real app, this would be an AJAX call)
            fetch('/api/customer/metrics')
                .then(response => response.json())
                .then(data => {
                    // Animate count updates
                    animateCount('saved-plots-count', data.savedPlots);
                    animateCount('reservations-count', data.reservations);
                    animateCount('inquiries-count', data.inquiries);
                })
                .catch(error => {
                    console.log('Metrics update failed:', error);
                });
        }

        // Animate count changes
        function animateCount(elementId, newValue) {
            const element = document.getElementById(elementId);
            const currentValue = parseInt(element.textContent);
            const increment = (newValue - currentValue) / 20;
            let current = currentValue;
            
            const timer = setInterval(() => {
                current += increment;
                if ((increment > 0 && current >= newValue) || (increment < 0 && current <= newValue)) {
                    element.textContent = newValue;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 50);
        }

        // Initialize and set up intervals
        document.addEventListener('DOMContentLoaded', function() {
            updateGreeting();
            updateQuote();
            addLoadingAnimation();
            
            // Update greeting every minute
            setInterval(updateGreeting, 60000);
            
            // Change quote every 10 seconds
            setInterval(updateQuote, 10000);
            
            // Update metrics every 30 seconds
            setInterval(updateMetrics, 30000);
        });

        document.addEventListener('DOMContentLoaded', function() {
            @foreach($recommendedPlots as $plot)
            @if($plot->plotImages && $plot->plotImages->count() > 1)
            (function() {
                const plotId = {{ $plot->id }};
                const imgs = document.querySelectorAll('.carousel-img-' + plotId);
                const dots = document.querySelectorAll('.carousel-dot-' + plotId);
                let idx = 0;
                let timer;
                function showImg(i) {
                    imgs[idx].classList.remove('opacity-100', 'z-10');
                    imgs[idx].classList.add('opacity-0', 'z-0');
                    dots[idx].classList.remove('ring-2', 'ring-yellow-600');
                    idx = i;
                    imgs[idx].classList.add('opacity-100', 'z-10');
                    imgs[idx].classList.remove('opacity-0', 'z-0');
                    dots[idx].classList.add('ring-2', 'ring-yellow-600');
                }
                function nextImg() {
                    showImg((idx + 1) % imgs.length);
                }
                timer = setInterval(nextImg, 3000);
                dots.forEach((dot, i) => {
                    dot.onclick = function(e) {
                        e.stopPropagation();
                        showImg(i);
                        clearInterval(timer);
                        timer = setInterval(nextImg, 3000);
                    };
                });
            })();
            @endif
            @endforeach
        });
    </script>
</x-dashboard-layout>
