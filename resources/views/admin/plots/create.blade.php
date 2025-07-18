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
                    <div class="drag-area" id="drag-area">
                        <div style="margin-bottom: 0.5rem;">
                            <i class="fas fa-cloud-upload-alt text-yellow-500 text-2xl mb-2"></i>
                        </div>
                        <div class="text-sm text-yellow-700 mb-1">Drag & drop or click to select images</div>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                        <button type="button" id="choose-images-btn" class="btn-yellow mt-2" style="font-size:0.95rem;padding:0.5rem 1.25rem;">Choose Images</button>
                    </div>
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
    <style>
        .drag-area {
            border: 2px dashed #fde68a;
            background: #fff;
            border-radius: 0.75rem;
            padding: 1.2rem;
            text-align: center;
            margin-bottom: 1rem;
            transition: border 0.2s, background 0.2s;
        }
        .drag-area.dragover {
            border-color: #f59e0b;
            background: #fef3c7;
        }
        .btn-yellow {
            background: #f59e0b;
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-yellow:hover, .btn-yellow:focus {
            background: #b45309;
        }
        .image-preview {
            position: relative;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 2px 8px 0 rgba(251, 191, 36, 0.08);
            margin-bottom: 0.5rem;
        }
        .image-preview img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 0.75rem;
        }
        .remove-image-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            background: #f59e0b;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0.85;
            z-index: 2;
            transition: background 0.2s, opacity 0.2s;
        }
        .remove-image-btn:hover {
            background: #b45309;
            opacity: 1;
        }
    </style>
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

        let selectedFiles = [];
        const chooseBtn = document.getElementById('choose-images-btn');
        const imagesInput = document.getElementById('images');
        const dragArea = document.getElementById('drag-area');
        const preview = document.getElementById('image-preview');

        // Prevent browser from opening image in new tab when dropped outside drop area
        window.addEventListener('dragover', function(e) { e.preventDefault(); });
        window.addEventListener('drop', function(e) { e.preventDefault(); });

        chooseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            imagesInput.click();
        });

        function updateInputFiles() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            imagesInput.files = dataTransfer.files;
        }

        function showPreview() {
            preview.innerHTML = '';
            selectedFiles.forEach((file, idx) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgDiv = document.createElement('div');
                        imgDiv.className = 'image-preview relative';
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        imgDiv.appendChild(img);
                        // Add remove button
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.innerHTML = '&times;';
                        removeBtn.className = 'remove-image-btn';
                        removeBtn.onclick = function() {
                            selectedFiles.splice(idx, 1);
                            updateInputFiles();
                            showPreview();
                        };
                        imgDiv.appendChild(removeBtn);
                        preview.appendChild(imgDiv);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        imagesInput.addEventListener('change', function(e) {
            // Add new files to selectedFiles, avoiding duplicates
            const newFiles = Array.from(imagesInput.files);
            newFiles.forEach(file => {
                if (!selectedFiles.some(f => f.name === file.name && f.size === file.size && f.lastModified === file.lastModified)) {
                    selectedFiles.push(file);
                }
            });
            updateInputFiles();
            showPreview();
        });

        // Drag & drop
        dragArea.addEventListener('drop', function(e) {
            e.preventDefault();
            dragArea.classList.remove('dragover');
            const droppedFiles = Array.from(e.dataTransfer.files);
            droppedFiles.forEach(file => {
                if (!selectedFiles.some(f => f.name === file.name && f.size === file.size && f.lastModified === file.lastModified)) {
                    selectedFiles.push(file);
                }
            });
            updateInputFiles();
            showPreview();
        });

        // Initial preview (in case of browser autofill)
        showPreview();
    });
    </script>
</x-dashboard-layout>