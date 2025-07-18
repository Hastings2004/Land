<x-dashboard-layout>
    <!-- Page Header -->
    <div class="mb-8 text-center relative">
        <div class="absolute left-0 top-1/2 transform -translate-y-1/2">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 hover:border-yellow-300 transition-all duration-200 text-gray-700 hover:text-yellow-600">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
        <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-500 rounded-2xl shadow-xl mb-4 transform rotate-3 hover:rotate-0 transition-transform duration-300">
            <i class="fas fa-plus text-white text-xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Add New Plot</h1>
        <p class="text-gray-500">Create a new property listing</p>
    </div>
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-0">
            <form action="{{ route('admin.plots.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative">
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Plot Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-gray-50 text-base placeholder-gray-400" placeholder="Enter plot title">
                        @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="relative">
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                        <select name="category" id="category" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-gray-50 text-base">
                            <option value="">Select category</option>
                            <option value="residential" {{ old('category') == 'residential' ? 'selected' : '' }}>Residential</option>
                            <option value="commercial" {{ old('category') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                            <option value="industrial" {{ old('category') == 'industrial' ? 'selected' : '' }}>Industrial</option>
                </select>
                        @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
                    <div class="relative">
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-gray-50 text-base placeholder-gray-400" placeholder="Enter location">
                        @error('location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="relative">
                        <label for="area_sqm" class="block text-sm font-semibold text-gray-700 mb-1">Area (sqm)</label>
                        <input type="number" name="area_sqm" id="area_sqm" value="{{ old('area_sqm') }}" min="0" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-gray-50 text-base placeholder-gray-400" placeholder="Enter area">
                        @error('area_sqm')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="relative md:col-span-2">
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Price</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-gray-50 text-base placeholder-gray-400" placeholder="Enter price">
                        @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-gray-50 text-base placeholder-gray-400 resize-none" placeholder="Describe the plot features, amenities, and highlights">{{ old('description') }}</textarea>
                        @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input type="checkbox" name="is_new_listing" id="is_new_listing" class="h-4 w-4 text-yellow-500 border-gray-300 rounded focus:ring-yellow-400" {{ old('is_new_listing') ? 'checked' : '' }}>
                    <label for="is_new_listing" class="text-sm text-gray-700">Mark as New Listing</label>
                </div>
                <!-- Images Upload Section -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Upload Images <span class="text-xs text-gray-400">(Max 30MB each, up to 10 images)</span></label>
                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="block w-full text-sm text-gray-700 border border-gray-200 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    @error('images')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    @error('images.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <div id="image-preview" class="flex flex-wrap gap-2 mt-2"></div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-yellow-500 text-white font-semibold rounded-lg shadow hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i> Add Plot
                    </button>
                </div>
            </form>
        </div>
                </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prevent negative numbers in area and price fields
        const areaInput = document.getElementById('area_sqm');
        const priceInput = document.getElementById('price');
        [areaInput, priceInput].forEach(input => {
            input.addEventListener('input', function() {
                if (this.value && parseFloat(this.value) < 0) {
                    this.value = 0;
                }
            });
            input.addEventListener('keydown', function(e) {
                if (e.key === '-' || e.key === 'Subtract') {
                    e.preventDefault();
                }
            });
        });
    });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('images');
    const preview = document.getElementById('image-preview');
    input.addEventListener('change', function() {
        preview.innerHTML = '';
        if (this.files) {
            Array.from(this.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'h-20 w-20 object-cover rounded border';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
});
</script>
</x-dashboard-layout>