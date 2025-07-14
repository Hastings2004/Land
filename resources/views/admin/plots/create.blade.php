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
                    <div id="drop-area" class="flex flex-col items-center justify-center border-2 border-dashed border-yellow-400 rounded-lg p-6 bg-yellow-50 hover:bg-yellow-100 transition cursor-pointer mb-4">
                        <i class="fas fa-cloud-upload-alt text-yellow-500 text-3xl mb-2"></i>
                        <span class="text-gray-700 font-semibold mb-1">Drag & drop images here or</span>
                        <label for="images" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition-all duration-200 cursor-pointer">
                            <i class="fas fa-upload mr-2"></i>
                            <span>Select Images</span>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                        </label>
                        <span id="selected-files" class="text-sm text-gray-500 mt-2"></span>
                    </div>
                    <div id="image_preview" class="relative flex items-center justify-center mt-4 min-h-[120px] w-full">
                        <!-- Carousel navigation will be injected here by JS if needed -->
                    </div>
                    <div id="image-upload-error" class="text-red-500 text-xs mt-2 hidden"></div>
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
        const imageInput = document.getElementById('images');
        const imagePreviewContainer = document.getElementById('image_preview');
        const errorDiv = document.getElementById('image-upload-error');
        const selectedFilesSpan = document.getElementById('selected-files');
        const dropArea = document.getElementById('drop-area');
        let filesArray = [];
        // Drag-and-drop events
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropArea.classList.add('bg-yellow-100');
            });
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropArea.classList.remove('bg-yellow-100');
            });
        });
        dropArea.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        });
        imageInput.addEventListener('change', function() {
            handleFiles(this.files);
            this.value = '';
        });
        function handleFiles(fileList) {
            errorDiv.classList.add('hidden');
            let errorMessages = [];
            let validFiles = [];
            for (let i = 0; i < fileList.length; i++) {
                const file = fileList[i];
                if (!file.type.startsWith('image/')) {
                    errorMessages.push(`"${file.name}" is not an image file.`);
                    continue;
                }
                if (file.size > 30 * 1024 * 1024) {
                    errorMessages.push(`"${file.name}" is larger than 30MB.`);
                    continue;
                }
                if (filesArray.length + validFiles.length >= 10) {
                    errorMessages.push('You can upload up to 10 images.');
                    break;
                }
                validFiles.push(file);
            }
            if (errorMessages.length > 0) {
                errorDiv.textContent = errorMessages.join(' ');
                errorDiv.classList.remove('hidden');
            }
            filesArray = filesArray.concat(validFiles);
            renderPreview();
            selectedFilesSpan.textContent = filesArray.length > 0 ? `${filesArray.length} image(s) selected` : '';
        }
        function renderPreview() {
            imagePreviewContainer.innerHTML = '';
            if (filesArray.length === 0) return;
            let currentIndex = 0;
            const carousel = document.createElement('div');
            carousel.className = 'relative w-full flex items-center justify-center';
            const imgWrapper = document.createElement('div');
            imgWrapper.className = 'w-full flex items-center justify-center';
            const img = document.createElement('img');
            img.className = 'rounded-xl shadow-lg object-contain max-h-60 max-w-full';
            img.src = URL.createObjectURL(filesArray[currentIndex]);
            imgWrapper.appendChild(img);
            carousel.appendChild(imgWrapper);
            if (filesArray.length > 1) {
                const prevBtn = document.createElement('button');
                prevBtn.type = 'button';
                prevBtn.className = 'absolute left-2 top-1/2 -translate-y-1/2 bg-white bg-opacity-80 rounded-full p-2 shadow hover:bg-yellow-100 focus:outline-none';
                prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
                prevBtn.onclick = function() {
                    currentIndex = (currentIndex - 1 + filesArray.length) % filesArray.length;
                    img.src = URL.createObjectURL(filesArray[currentIndex]);
                };
                carousel.appendChild(prevBtn);
                const nextBtn = document.createElement('button');
                nextBtn.type = 'button';
                nextBtn.className = 'absolute right-2 top-1/2 -translate-y-1/2 bg-white bg-opacity-80 rounded-full p-2 shadow hover:bg-yellow-100 focus:outline-none';
                nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
                nextBtn.onclick = function() {
                    currentIndex = (currentIndex + 1) % filesArray.length;
                    img.src = URL.createObjectURL(filesArray[currentIndex]);
                };
                carousel.appendChild(nextBtn);
            }
                    // Remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
            removeBtn.className = 'absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 shadow hover:bg-red-600 focus:outline-none';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.onclick = function() {
                filesArray.splice(currentIndex, 1);
                renderPreview();
                selectedFilesSpan.textContent = filesArray.length > 0 ? `${filesArray.length} image(s) selected` : '';
            };
            carousel.appendChild(removeBtn);
            imagePreviewContainer.appendChild(carousel);
        }
        // On form submit, append filesArray to the input
        document.querySelector('form').addEventListener('submit', function(e) {
            if (filesArray.length > 0) {
                // Remove the input and add a new one with the files
                const input = document.getElementById('images');
                    const dt = new DataTransfer();
                filesArray.forEach(file => dt.items.add(file));
                input.files = dt.files;
            }
        });
    });
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
    </script>
</x-dashboard-layout>