<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{env(key: 'APP_NAME')}} - Edit Plot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }
        .form-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 4px 24px 0 rgba(31, 38, 135, 0.08);
            padding: 2rem;
            max-width: 60rem;
            margin: 2.5rem auto;
        }
        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #b45309;
            margin-bottom: 0.25rem;
        }
        .form-subtitle {
            color: #a16207;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-weight: 500;
            color: #a16207;
            margin-bottom: 0.25rem;
        }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.6rem 1rem;
            border: 1.5px solid #fde68a;
            border-radius: 0.75rem;
            background: #fff;
            font-size: 1rem;
            color: #92400e;
            margin-bottom: 0.5rem;
            transition: border 0.2s, box-shadow 0.2s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: #f59e0b;
            outline: none;
            box-shadow: 0 0 0 2px #fde68a;
            background: #fff;
        }
        .form-section {
            margin-bottom: 1.25rem;
        }
        .form-checkbox {
            accent-color: #f59e0b;
            margin-right: 0.5rem;
        }
        .form-error {
            color: #dc2626;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .btn-yellow {
            background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 100%);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 0.75rem;
            padding: 0.7rem 1.5rem;
            font-size: 1rem;
            box-shadow: 0 2px 8px 0 rgba(251, 191, 36, 0.08);
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
        }
        .btn-yellow:hover, .btn-yellow:focus {
            background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%);
            box-shadow: 0 4px 16px 0 rgba(251, 191, 36, 0.16);
            transform: translateY(-2px) scale(1.03);
        }
        .btn-gray {
            background: #f3f4f6;
            color: #92400e;
            font-weight: 600;
            border: none;
            border-radius: 0.75rem;
            padding: 0.7rem 1.5rem;
            font-size: 1rem;
            transition: background 0.2s, color 0.2s;
        }
        .btn-gray:hover, .btn-gray:focus {
            background: #e5e7eb;
            color: #b45309;
        }
        .image-preview {
            position: relative;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 2px 8px 0 rgba(251, 191, 36, 0.08);
            margin-bottom: 0.5rem;
        }
        .image-preview img {
            width: 100%;
            height: 90px;
            object-fit: cover;
            border-radius: 0.75rem;
        }
        .remove-image {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #f59e0b;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.85;
            cursor: pointer;
            transition: background 0.2s, opacity 0.2s;
        }
        .remove-image:hover {
            background: #b45309;
            opacity: 1;
        }

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
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
        }
        @media (max-width: 600px) {
            .form-card { padding: 1rem 0.25rem; }
            .form-title { font-size: 1.1rem; }
            .form-actions { flex-direction: column; gap: 0.5rem; }
        }
    </style>
</head>
<body>
    @auth()
    <!-- Back Button -->
    <div class="fixed top-4 left-4 z-50">
        <a href="{{ route('admin.plots.show', $plot) }}" 
           class="inline-flex items-center px-3 py-2 bg-white text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition-all duration-200 border border-gray-200">
            <i class="fas fa-arrow-left mr-2 text-yellow-600"></i>
            <span class="text-sm font-medium">Back to Plot Details</span>
        </a>
    </div>
    
    <div class="min-h-screen flex items-center justify-center">
        <div class="form-card">
            <div class="mb-4 text-center">
                <div class="form-title">Edit Plot</div>
                <div class="form-subtitle">Update details for <span class="font-semibold">{{ $plot->title }}</span></div>
            </div>
            <form action="{{ route('admin.plots.update', $plot) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('PUT')

                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-section">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $plot->title) }}" required class="form-input">
                        @error('title')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-section">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $plot->location) }}" required class="form-input">
                        @error('location')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-section">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="3" required class="form-textarea">{{ old('description', $plot->description) }}</textarea>
                    @error('description')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <!-- Images -->
                <div class="form-section">
                    <label class="form-label">Images</label>
                    <div class="drag-area" id="drag-area">
                        <div style="margin-bottom: 0.5rem;">
                            <i class="fas fa-cloud-upload-alt text-yellow-500 text-2xl mb-2"></i>
                        </div>
                        <div class="text-sm text-yellow-700 mb-1">Drag & drop or click to select images</div>
                        <input type="file" id="image-upload" name="images[]" multiple accept="image/*" class="hidden">
                        <button type="button" onclick="document.getElementById('image-upload').click()" class="btn-yellow mt-2" style="font-size:0.95rem;padding:0.5rem 1.25rem;">Choose Images</button>
                    </div>
                    <div id="image-preview-container" class="gallery">
                        @foreach($plot->plotImages as $plotImage)
                            <div class="image-preview group">
                                <img src="{{ $plotImage->image_url }}" alt="Plot Image">
                                <button type="button" class="remove-image" onclick="removeExistingImage(this)"><i class="fas fa-trash"></i></button>
                                <input type="hidden" name="existing_images[]" value="{{ $plotImage->image_path }}">

                            </div>
                        @endforeach
                        @if($plot->plotImages->isEmpty() && $plot->image_path)
                            <div class="image-preview group">
                                <img src="{{ asset('storage/' . $plot->image_path) }}" alt="Plot Image">
                                <button type="button" class="remove-image" onclick="removeExistingImage(this)"><i class="fas fa-trash"></i></button>
                                <input type="hidden" name="existing_images[]" value="{{ $plot->image_path }}">

                            </div>
                        @endif
                        <!-- Hidden file input for images -->
                        <input type="file" name="images[]" id="images" multiple class="hidden" />
                    </div>
                    <script>
                    // Make upload button or drag area clickable to open file input
                    document.addEventListener('DOMContentLoaded', function() {
                        const fileInput = document.getElementById('images');
                        const uploadBtn = document.querySelector('button[onclick*="image-upload"]');
                        const dragArea = document.getElementById('drag-area');
                        if (uploadBtn) {
                            uploadBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                fileInput.click();
                            });
                        }
                        if (dragArea) {
                            dragArea.addEventListener('click', function() {
                                fileInput.click();
                            });
                        }
                    });
                    </script>

                <!-- Price & Area -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-section">
                        <label for="price" class="form-label">Price (K)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $plot->price) }}" required step="0.01" min="0" class="form-input">
                        @error('price')<div class="form-error">{{ $message }}</div>@enderror
            </div>
                    <div class="form-section">
                        <label for="area_sqm" class="form-label">Area (sqm)</label>
                        <input type="number" name="area_sqm" id="area_sqm" value="{{ old('area_sqm', $plot->area_sqm) }}" required step="0.01" min="0" class="form-input">
                        @error('area_sqm')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            </div>

                <!-- Status & Listing -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Status field removed: status is managed automatically by the system -->
                    <div class="form-section">
                        <label class="form-label">Listing Type</label>
                        <label style="display:flex;align-items:center;gap:0.5rem;">
                            <input type="checkbox" name="is_new_listing" id="is_new_listing" value="1" {{ old('is_new_listing', $plot->is_new_listing) ? 'checked' : '' }} class="form-checkbox">
                            <span style="color:#b45309;font-weight:500;">New Listing</span>
                </label>
                        @error('is_new_listing')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
            </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-yellow"><i class="fas fa-save mr-2"></i>Update Plot</button>
                    <a href="{{ route('admin.plots.show', $plot) }}" class="btn-gray"><i class="fas fa-times mr-2"></i>Cancel</a>
            </div>
        </form>
            @if(session('success'))
                <div id="success-message" class="mt-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl flex items-center shadow-lg transform transition-all duration-500">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-check text-white text-lg"></i>
                    </div>
                    <div>
                        <div class="font-bold text-green-900">Success!</div>
                        <div class="text-sm text-green-700">{{ session('success') }}</div>
                    </div>
                    <button onclick="hideSuccessMessage()" class="ml-auto text-green-600 hover:text-green-800 transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
    @endauth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dragArea = document.getElementById('drag-area');
            const fileInput = document.getElementById('image-upload');
            const previewContainer = document.getElementById('image-preview-container');
            let filesArray = [];

            // Drag-and-drop events
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dragArea.addEventListener(eventName, preventDefaults, false);
            });
            function preventDefaults(e) { e.preventDefault(); e.stopPropagation(); }
            ['dragenter', 'dragover'].forEach(eventName => { dragArea.addEventListener(eventName, highlight, false); });
            ['dragleave', 'drop'].forEach(eventName => { dragArea.addEventListener(eventName, unhighlight, false); });
            function highlight(e) { dragArea.classList.add('dragover'); }
            function unhighlight(e) { dragArea.classList.remove('dragover'); }
            dragArea.addEventListener('drop', handleDrop, false);
            function handleDrop(e) { const dt = e.dataTransfer; const files = dt.files; handleFiles(files); }
            fileInput.addEventListener('change', function() { handleFiles(this.files); this.value = ''; });

            function handleFiles(fileList) {
                let validFiles = [];
                for (let i = 0; i < fileList.length; i++) {
                    const file = fileList[i];
                    if (!file.type.startsWith('image/')) continue;
                    if (file.size > 10 * 1024 * 1024) continue;
                    // Prevent duplicates by name+size
                    if (!filesArray.some(f => f.name === file.name && f.size === file.size)) {
                        validFiles.push(file);
                    }
                }
                filesArray = filesArray.concat(validFiles);
                renderPreview();
            }

            function renderPreview() {
                // Remove all previews of new images (keep existing images)
                const previews = previewContainer.querySelectorAll('.image-preview[data-new]');
                previews.forEach(p => p.remove());
                filesArray.forEach((file, idx) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.createElement('div');
                        preview.className = 'image-preview group';
                        preview.setAttribute('data-new', '1');
                        preview.innerHTML = `
                            <img src="${e.target.result}" alt="Preview">
                            <button type="button" class="remove-image" onclick="removeNewImage(${idx})"><i class="fas fa-trash"></i></button>
                        `;
                        previewContainer.appendChild(preview);
                    };
                    reader.readAsDataURL(file);
                });
                updateFileInput();
            }

            window.removeNewImage = function(idx) {
                filesArray.splice(idx, 1);
                renderPreview();
            };

            function updateFileInput() {
                // Update the file input's file list to match filesArray
                const dt = new DataTransfer();
                filesArray.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
            }

            window.removeExistingImage = function(button) {
                const preview = button.closest('.image-preview');
                const hiddenInput = preview.querySelector('input[name="existing_images[]"]');
                if (hiddenInput) { hiddenInput.name = 'removed_images[]'; }
                preview.remove();
            };

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

            // Success message logic remains unchanged
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.opacity = '0';
                successMessage.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    successMessage.style.opacity = '1';
                    successMessage.style.transform = 'translateY(0)';
                }, 100);
                setTimeout(() => { hideSuccessMessage(); }, 3000);
            }
            window.hideSuccessMessage = function() {
                const message = document.getElementById('success-message');
                if (message) {
                    message.style.transform = 'translateY(-20px)';
                    message.style.opacity = '0';
                    setTimeout(() => { message.style.display = 'none'; }, 500);
                }
            };
        });
    </script>
</body>
</html>