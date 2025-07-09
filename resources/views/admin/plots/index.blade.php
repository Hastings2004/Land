<x-dashboard-layout>
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center px-4 py-2 bg-white text-gray-700 rounded-lg font-semibold text-sm border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-1">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Dashboard
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-500 rounded-2xl shadow-xl mb-4 transform rotate-3 hover:rotate-0 transition-transform duration-300">
            <i class="fas fa-map-marker-alt text-white text-xl"></i>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">
            @if(request('search'))
                Search Results for "{{ request('search') }}"
            @else
                Available Plots
            @endif
        </h2>
        <p class="text-gray-500">
            @if(request('search'))
                Found {{ $plots->total() }} plot(s) matching your search
            @else
                Manage and view all your land plots
            @endif
        </p>
    </div>

    <!-- Search, Sort, Filter Section + Filters Panel (Alpine.js) -->
    <div x-data="{ filtersOpen: false }" x-init="$nextTick(() => { filtersOpen = false })">
        <div class="bg-white rounded-xl shadow p-4 md:p-6 mb-8 border border-gray-100">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between md:gap-6">
            <!-- Search Form -->
            <form action="{{ route('admin.plots.index') }}" method="GET" class="w-full md:w-auto flex-1">
            <div class="relative">
                    <input type="text" name="search" 
                           class="w-full pl-12 pr-10 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 bg-gray-50 text-gray-800 placeholder-gray-500 transition-all duration-200 text-base md:text-sm" 
                           placeholder="Search plots by title, location..." 
                           value="{{ request('search') }}">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-yellow-500"></i>
                </div>
                    @if(request('search'))
                        <a href="{{ route('admin.plots.index', array_merge(request()->except(['search', 'page']))) }}" 
                               class="absolute inset-y-0 right-0 pr-4 flex items-center text-yellow-500 hover:text-yellow-700 transition-colors duration-200">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
            </div>
        </form>
            <!-- Filter Button -->
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto justify-end items-stretch md:items-center">
                <button type="button" 
                        @click="filtersOpen = !filtersOpen"
                            :aria-expanded="filtersOpen ? 'true' : 'false'"
                            aria-controls="filters-panel"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg font-semibold text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                        <i class="fas fa-filter mr-2 text-yellow-500"></i>
                    Filters
                        <i class="fas fa-chevron-down ml-2 text-xs transition-transform duration-200 text-yellow-500" :class="filtersOpen ? 'rotate-180' : ''"></i>
                </button>
                <a href="{{ route('admin.plots.index', ['new_listings' => true]) }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg font-semibold text-sm hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-star mr-2"></i>
                    New Listings
                </a>
            </div>
        </div>
    </div>
    <!-- Filters Panel -->
        <div class="mb-8">
        <form action="{{ route('admin.plots.index') }}" method="GET" 
                 id="filters-panel"
             x-show="filtersOpen" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="transform opacity-0 -translate-y-4"
             x-transition:enter-end="transform opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="transform opacity-100 translate-y-0"
             x-transition:leave-end="transform opacity-0 -translate-y-4"
                 class="bg-white rounded-xl shadow p-6 border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        <option value="">All Status</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Sold</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                    <select name="category" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        <option value="">All Categories</option>
                        <option value="residential" {{ request('category') === 'residential' ? 'selected' : '' }}>Residential</option>
                        <option value="commercial" {{ request('category') === 'commercial' ? 'selected' : '' }}>Commercial</option>
                        <option value="industrial" {{ request('category') === 'industrial' ? 'selected' : '' }}>Industrial</option>
                    </select>
                </div>
                <!-- Price Range -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Price Range</label>
                    <div class="flex gap-2">
                        <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" 
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" 
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                </div>
                <!-- Area Range -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Area Range (sqm)</label>
                    <div class="flex gap-2">
                        <input type="number" name="min_area" placeholder="Min" value="{{ request('min_area') }}" 
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        <input type="number" name="max_area" placeholder="Max" value="{{ request('max_area') }}" 
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                </div>
            </div>
            <!-- Filter Actions -->
            <div class="flex flex-col sm:flex-row gap-3 mt-6 pt-6 border-t border-gray-100">
                <button type="submit" 
                            @click="filtersOpen = false"
                            class="inline-flex items-center px-6 py-2 bg-yellow-500 text-white rounded-lg font-semibold text-sm hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-search mr-2"></i>
                    Apply Filters
                </button>
                <a href="{{ route('admin.plots.index') }}" 
                       @click="filtersOpen = false"
                       class="inline-flex items-center px-6 py-2 bg-white text-gray-700 rounded-lg font-semibold text-sm border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Clear All
                </a>
            </div>
        </form>
        </div>
    </div>

    <!-- Plots Display Section -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        @if($plots->isEmpty())
            <!-- No Plots Available -->
            <div class="text-center py-16 px-6">
                <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-map-marker-alt text-yellow-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No Plots Found</h3>
                <p class="text-gray-500 mb-6">No plots available matching your criteria.</p>
                <a href="{{ route('admin.plots.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Plot
                </a>
            </div>
        @else
            <!-- Plots Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-2 md:p-6">
                @foreach($plots as $plot)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-200 overflow-hidden group flex flex-col h-full cursor-pointer hover:-translate-y-1 hover:scale-[1.02] focus-within:shadow-2xl">
                        <!-- Plot Images Carousel -->
                        <div class="relative h-44 sm:h-48 md:h-52 bg-gray-100 overflow-hidden select-none">
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
                        <!-- Plot Info -->
                        <div class="flex-1 flex flex-col p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-gray-800 truncate">{{ $plot->title }}</h3>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    {{ ucfirst($plot->status) }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-500 mb-2 truncate">{{ $plot->location }}</div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-yellow-600 font-semibold">{{ number_format($plot->price) }} MWK</span>
                                <span class="text-xs text-gray-400">/ {{ $plot->area }} sqm</span>
                            </div>
                            <div class="flex-1"></div>
                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('admin.plots.show', $plot) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-white text-yellow-700 border border-yellow-300 rounded-lg font-semibold text-xs hover:bg-yellow-50 hover:text-yellow-900 transition-all duration-200">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                                <a href="{{ route('admin.plots.edit', $plot) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg font-semibold text-xs hover:bg-yellow-600 transition-all duration-200">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.plots.destroy', $plot) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plot?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-white text-red-600 border border-red-200 rounded-lg font-semibold text-xs hover:bg-red-50 hover:text-red-800 transition-all duration-200">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Pagination -->
            <div class="p-6">
                {{ $plots->links() }}
            </div>
        @endif
    </div>
</x-dashboard-layout>
<script>
window.prevCarouselImage = function(plotId) {
    const imgs = document.querySelectorAll('.carousel-img-' + plotId);
    const dots = document.querySelectorAll('.carousel-dot-' + plotId);
    let idx = Array.from(imgs).findIndex(img => img.classList.contains('opacity-100'));
    imgs[idx].classList.remove('opacity-100', 'z-10');
    imgs[idx].classList.add('opacity-0', 'z-0');
    dots[idx].classList.remove('bg-yellow-500');
    idx = (idx - 1 + imgs.length) % imgs.length;
    imgs[idx].classList.add('opacity-100', 'z-10');
    imgs[idx].classList.remove('opacity-0', 'z-0');
    dots[idx].classList.add('bg-yellow-500');
}
window.nextCarouselImage = function(plotId) {
    const imgs = document.querySelectorAll('.carousel-img-' + plotId);
    const dots = document.querySelectorAll('.carousel-dot-' + plotId);
    let idx = Array.from(imgs).findIndex(img => img.classList.contains('opacity-100'));
    imgs[idx].classList.remove('opacity-100', 'z-10');
    imgs[idx].classList.add('opacity-0', 'z-0');
    dots[idx].classList.remove('bg-yellow-500');
    idx = (idx + 1) % imgs.length;
    imgs[idx].classList.add('opacity-100', 'z-10');
    imgs[idx].classList.remove('opacity-0', 'z-0');
    dots[idx].classList.add('bg-yellow-500');
}
document.addEventListener('DOMContentLoaded', function() {
    @foreach($plots as $plot)
    @if($plot->plotImages->count() > 1)
    (function() {
        const plotId = {{ $plot->id }};
        const imgs = document.querySelectorAll('.carousel-img-' + plotId);
        const dots = document.querySelectorAll('.carousel-dot-' + plotId);
        dots.forEach((dot, i) => {
            dot.onclick = function(e) {
                imgs.forEach((img, j) => {
                    img.classList.toggle('opacity-100', j === i);
                    img.classList.toggle('z-10', j === i);
                    img.classList.toggle('opacity-0', j !== i);
                    img.classList.toggle('z-0', j !== i);
                    dots[j].classList.toggle('bg-yellow-500', j === i);
                });
            };
        });
    })();
    @endif
    @endforeach
});
</script>
