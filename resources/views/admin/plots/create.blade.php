<x-dashboard-layout>
    <!-- Page Header -->
    <div class="mb-8 text-center relative">
        <!-- Back Button -->
        <div class="absolute left-0 top-1/2 transform -translate-y-1/2">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 hover:border-yellow-300 transition-all duration-200 text-gray-700 hover:text-yellow-600">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>
        <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-500 rounded-2xl shadow-xl mb-4 transform rotate-3 hover:rotate-0 transition-transform duration-300">
            <i class="fas fa-plus text-white text-xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Add New Plot</h1>
        <p class="text-gray-500">Create a new property listing</p>
    </div>

    <!-- Form Container -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-0">
            <form action="{{ route('admin.plots.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
                <!-- Section Header -->
                <div class="text-center mb-6">
                    <div class="flex justify-center mb-2">
                        <div class="w-16 h-16 flex items-center justify-center rounded-full bg-yellow-100 shadow">
                            <i class="fas fa-map-marked-alt text-yellow-500 text-3xl"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Add New Plot</h2>
                    <p class="text-gray-500 text-sm">Create a new property listing</p>
                </div>
                <!-- Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                    <div class="relative">
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Plot Title</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400">
                                <i class="fas fa-heading"></i>
                            </span>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                   class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-gray-50 text-base placeholder-gray-400"
                           placeholder="Enter plot title">
                        </div>
                    @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Category -->
                    <div class="relative">
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400">
                                <i class="fas fa-layer-group"></i>
                            </span>
                        <select name="category" id="category" 
                                    class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-gray-50 text-base">
                            <option value="">Select category</option>
                            <option value="residential" {{ old('category') == 'residential' ? 'selected' : '' }}>Residential</option>
                            <option value="commercial" {{ old('category') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                            <option value="industrial" {{ old('category') == 'industrial' ? 'selected' : '' }}>Industrial</option>
                </select>
                        </div>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
            </div>
                    <!-- Location -->
                    <div class="relative">
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                                   class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-gray-50 text-base placeholder-gray-400"
                               placeholder="Enter location">
                        </div>
                        @error('location')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Area -->
                    <div class="relative">
                        <label for="area_sqm" class="block text-sm font-semibold text-gray-700 mb-1">Area (sqm)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400">
                                <i class="fas fa-ruler-combined"></i>
                            </span>
                            <input type="number" name="area_sqm" id="area_sqm" value="{{ old('area_sqm') }}"
                                   class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-gray-50 text-base placeholder-gray-400"
                                   placeholder="Enter area">
                        </div>
                        @error('area_sqm')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Price -->
                    <div class="relative md:col-span-2">
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Price</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400">
                                <i class="fas fa-dollar-sign"></i>
                            </span>
                            <input type="number" name="price" id="price" value="{{ old('price') }}"
                                   class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-gray-50 text-base placeholder-gray-400"
                                   placeholder="Enter price">
                        </div>
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                        <div class="relative">
                            <span class="absolute left-3 top-4 text-yellow-400">
                                <i class="fas fa-align-left"></i>
                            </span>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 bg-gray-50 text-base placeholder-gray-400 resize-none"
                                      placeholder="Describe the plot features, amenities, and highlights">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Images Upload Section -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Upload Images <span class="text-xs text-gray-400">(Max 30MB each, multiple allowed)</span>
                    </label>
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
                    <div id="image_preview" class="flex flex-wrap gap-4 mt-4"></div>
                    <div id="image-upload-error" class="text-red-500 text-xs mt-2 hidden"></div>
                </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('images');
        const imagePreviewContainer = document.getElementById('image_preview');
        const errorDiv = document.getElementById('image-upload-error');
        const selectedFilesSpan = document.getElementById('selected-files');
        const dropArea = document.getElementById('drop-area');
        let filesArray = [];
        let dragSrcIndex = null;

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

        // File input change
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
                // Prevent duplicates by name+size
                if (!filesArray.some(f => f.name === file.name && f.size === file.size)) {
                    validFiles.push(file);
                }
            }
            filesArray = filesArray.concat(validFiles);
            updatePreview();
            if (filesArray.length > 0) {
                selectedFilesSpan.textContent = filesArray.length === 1 ? filesArray[0].name : `${filesArray.length} files selected`;
            } else {
                selectedFilesSpan.textContent = '';
            }
            if (errorMessages.length > 0) {
                errorDiv.innerHTML = errorMessages.join('<br>');
                errorDiv.classList.remove('hidden');
            }
        }

        function updatePreview() {
            imagePreviewContainer.innerHTML = '';
            filesArray.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgDiv = document.createElement('div');
                    imgDiv.className = 'relative w-24 h-24 rounded-lg overflow-hidden border border-yellow-300 shadow-sm bg-white flex items-center justify-center m-1 group';
                    imgDiv.setAttribute('draggable', 'true');
                    imgDiv.setAttribute('data-idx', idx);
                    // Drag events for reordering
                    imgDiv.addEventListener('dragstart', function(ev) {
                        dragSrcIndex = idx;
                        ev.dataTransfer.effectAllowed = 'move';
                        this.classList.add('opacity-50');
                    });
                    imgDiv.addEventListener('dragend', function(ev) {
                        this.classList.remove('opacity-50');
                    });
                    imgDiv.addEventListener('dragover', function(ev) {
                        ev.preventDefault();
                        this.classList.add('ring-2', 'ring-yellow-400');
                    });
                    imgDiv.addEventListener('dragleave', function(ev) {
                        this.classList.remove('ring-2', 'ring-yellow-400');
                    });
                    imgDiv.addEventListener('drop', function(ev) {
                        ev.preventDefault();
                        this.classList.remove('ring-2', 'ring-yellow-400');
                        if (dragSrcIndex !== null && dragSrcIndex !== idx) {
                            const moved = filesArray.splice(dragSrcIndex, 1)[0];
                            filesArray.splice(idx, 0, moved);
                            updatePreview();
                        }
                        dragSrcIndex = null;
                    });
                    // Image
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'object-cover w-full h-full pointer-events-none';
                    img.alt = 'Preview';
                    imgDiv.appendChild(img);
                    // Remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'absolute top-1 right-1 bg-white bg-opacity-80 rounded-full p-1 text-red-500 hover:bg-red-100 transition group-hover:scale-110';
                    removeBtn.title = 'Remove';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    removeBtn.onclick = function(e) {
                        e.preventDefault();
                        filesArray.splice(idx, 1);
                        updatePreview();
                        if (filesArray.length > 0) {
                            selectedFilesSpan.textContent = filesArray.length === 1 ? filesArray[0].name : `${filesArray.length} files selected`;
                        } else {
                            selectedFilesSpan.textContent = '';
                        }
                    };
                    imgDiv.appendChild(removeBtn);
                    imagePreviewContainer.appendChild(imgDiv);
                };
                reader.readAsDataURL(file);
            });
        }

        // On form submit, append all files in filesArray to FormData
        const form = document.querySelector('form[action*="admin.plots.store"]');
        form.addEventListener('submit', function(e) {
            if (filesArray.length > 0) {
                // Remove any existing file inputs
                const oldInputs = form.querySelectorAll('input[type="file"][name="images[]"]');
                oldInputs.forEach(i => i.remove());
                // Create a new input for each file
                filesArray.forEach((file, idx) => {
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'images[]';
                    fileInput.files = dt.files;
                    fileInput.style.display = 'none';
                    form.appendChild(fileInput);
                });
            }
        });
    });
    </script>
                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" id="submitBtn"
                            class="w-full bg-yellow-500 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition-all duration-200 text-lg flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i>
                        <span id="submitText">Create Plot</span>
                        <div id="loadingSpinner" class="hidden ml-2">
                            <svg class="animate-spin h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Message Toast -->
    @if(session('success'))
    <div id="successToast" class="fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-500 ease-in-out">
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl border-l-4 border-green-400 max-w-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white"></i>
                    </div>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-semibold">{{ session('success') }}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button onclick="closeSuccessToast()" class="text-white hover:text-green-100 transition-colors duration-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- Progress bar -->
            <div class="mt-3 bg-white bg-opacity-20 rounded-full h-1">
                <div id="progressBar" class="bg-white h-1 rounded-full transition-all duration-3000 ease-linear" style="width: 100%"></div>
            </div>
        </div>
    </div>
    @endif

    <!-- Interactive JavaScript -->
    <script>
        // Form validation and interaction
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const inputs = form.querySelectorAll('input, textarea, select');
            
            // Real-time validation feedback
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });
                
                input.addEventListener('input', function() {
                    clearFieldError(this);
                });
            });
            
            // Form submission with loading state and AJAX
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (validateForm()) {
                    // Show loading state
                    submitBtn.disabled = true;
                    submitText.textContent = 'Creating Plot...';
                    loadingSpinner.classList.remove('hidden');
                    
                    // Create FormData for AJAX submission
                    const formData = new FormData(form);
                    
                    // Submit form via AJAX
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success toast
                            showSuccessToast(data.message);
                            
                            // Reset form only on success
                            form.reset();
                            // Clear Dropzone files
                            // myDropzone.removeAllFiles(true); // This line is no longer needed
                            
                            // Redirect after 3 seconds
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 3000);
                        } else {
                            // Show error message if provided
                            const errorMessage = data.message || 'An error occurred. Please check your inputs and try again.';
                            showErrorToast(errorMessage);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Show error toast
                        showErrorToast('An error occurred. Please check your inputs and try again.');
                    })
                    .finally(() => {
                        // Reset button state
                        submitBtn.disabled = false;
                        submitText.textContent = 'Create Plot';
                        loadingSpinner.classList.add('hidden');
                    });
                }
            });
            
            // Multiple file input preview with drag & drop
            // This section is now handled by Dropzone.js, so we can remove the old file input and preview JS.
            
            // Validation functions
            function validateField(field) {
                const value = field.value.trim();
                const fieldName = field.name;
                
                clearFieldError(field);
                
                switch(fieldName) {
                    case 'title':
                        if (value.length < 3) {
                            showFieldError(field, 'Title must be at least 3 characters long');
                            return false;
                        }
                        break;
                    case 'description':
                        if (value.length < 10) {
                            showFieldError(field, 'Description must be at least 10 characters long');
                            return false;
                        }
                        break;
                    case 'price':
                        if (value <= 0) {
                            showFieldError(field, 'Price must be greater than 0');
                            return false;
                        }
                        break;
                    case 'area_sqm':
                        if (value <= 0) {
                            showFieldError(field, 'Area must be greater than 0');
                            return false;
                        }
                        break;
                    case 'category':
                        if (!value) {
                            showFieldError(field, 'Please select a category');
                            return false;
                        }
                        break;
                    case 'location':
                        if (value.length < 3) {
                            showFieldError(field, 'Location must be at least 3 characters long');
                            return false;
                        }
                        break;
                    case 'images[]':
                        // Validate images if any are selected
                        // This validation is now handled by Dropzone.js's maxFilesize and acceptedFiles options.
                        break;
                }
                
                return true;
            }
            
            function validateForm() {
                const inputs = document.querySelectorAll('input, textarea, select');
                let isValid = true;
                
                inputs.forEach(input => {
                    if (!validateField(input)) {
                        isValid = false;
                    }
                });
                
                return isValid;
            }
            
            function showFieldError(field, message) {
                field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-200');
                
                let errorDiv = field.parentNode.querySelector('.field-error');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'field-error text-red-500 text-sm mt-1 flex items-center';
                    field.parentNode.appendChild(errorDiv);
                }
                
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${message}`;
            }
            
            function clearFieldError(field) {
                field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-200');
                
                const errorDiv = field.parentNode.querySelector('.field-error');
                if (errorDiv) {
                    errorDiv.remove();
                }
            }
            
            // Dropzone.js Script
            // Dropzone.autoDiscover = false; // This line is no longer needed
            // const myDropzone = new Dropzone("#dropzone", { // This line is no longer needed
            //     url: "#", // Prevent auto-upload // This line is no longer needed
            //     autoProcessQueue: false, // This line is no longer needed
            //     uploadMultiple: true, // This line is no longer needed
            //     parallelUploads: 10, // This line is no longer needed
            //     maxFiles: 10, // This line is no longer needed
            //     maxFilesize: 10, // MB // This line is no longer needed
            //     acceptedFiles: 'image/*', // This line is no longer needed
            //     addRemoveLinks: true, // This line is no longer needed
            //     dictRemoveFile: 'Remove', // This line is no longer needed
            //     previewsContainer: "#dropzone", // This line is no longer needed
            //     clickable: true, // This line is no longer needed
            // }); // This line is no longer needed

            // On form submit, append all Dropzone files to a hidden file input and submit natively
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form[action*="admin.plots.store"]');
                form.addEventListener('submit', function(e) {
                // Remove any previous hidden file input
                const oldInput = document.getElementById('dz-hidden-upload');
                if (oldInput) oldInput.remove();
                    // The new file input is now directly in the form, so we don't need to append it.
                    // The formData will automatically include all files from the new input.
                });
            });
            
            function showSuccessToast(message) {
                // Remove existing toast if any
                const existingToast = document.getElementById('successToast');
                if (existingToast) {
                    existingToast.remove();
                }
                
                // Create new toast
                const toast = document.createElement('div');
                toast.id = 'successToast';
                toast.className = 'fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-500 ease-in-out';
                
                toast.innerHTML = `
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl border-l-4 border-green-400 max-w-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-semibold">${message}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <button onclick="closeSuccessToast()" class="text-white hover:text-green-100 transition-colors duration-200">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Progress bar -->
                        <div class="mt-3 bg-white bg-opacity-20 rounded-full h-1">
                            <div id="progressBar" class="bg-white h-1 rounded-full transition-all duration-3000 ease-linear" style="width: 100%"></div>
                        </div>
                    </div>
                `;
                
                // Add to page
                document.body.appendChild(toast);
                
                // Slide in
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);
                
                // Animate progress bar
                setTimeout(() => {
                    const progressBar = document.getElementById('progressBar');
                    if (progressBar) {
                        progressBar.style.width = '0%';
                    }
                }, 100);
                
                // Auto-hide after 3 seconds
                setTimeout(() => {
                    closeSuccessToast();
                }, 3000);
            }
            
            function showErrorToast(message) {
                // Remove existing toasts
                const existingToasts = document.querySelectorAll('[id$="Toast"]');
                existingToasts.forEach(toast => toast.remove());
                
                // Create error toast
                const toast = document.createElement('div');
                toast.id = 'errorToast';
                toast.className = 'fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-500 ease-in-out';
                
                toast.innerHTML = `
                    <div class="bg-gradient-to-r from-red-500 to-pink-600 text-white px-6 py-4 rounded-xl shadow-2xl border-l-4 border-red-400 max-w-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-semibold">${message}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <button onclick="closeErrorToast()" class="text-white hover:text-red-100 transition-colors duration-200">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                // Add to page
                document.body.appendChild(toast);
                
                // Slide in
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    closeErrorToast();
                }, 5000);
            }
            
            function closeErrorToast() {
                const toast = document.getElementById('errorToast');
                if (toast) {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => {
                        toast.remove();
                    }, 500);
                }
            }
            
            function closeSuccessToast() {
                const toast = document.getElementById('successToast');
                if (toast) {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => {
                        toast.remove();
                    }, 500);
                }
            }
            
            // Auto-hide success toast after 3 seconds
            document.addEventListener('DOMContentLoaded', function() {
                const toast = document.getElementById('successToast');
                const progressBar = document.getElementById('progressBar');
                
                if (toast && progressBar) {
                    // Slide in the toast
                    setTimeout(() => {
                        toast.classList.remove('translate-x-full');
                    }, 100);
                    
                    // Animate progress bar
                    setTimeout(() => {
                        progressBar.style.width = '0%';
                    }, 100);
                    
                    // Auto-hide after 3 seconds
                    setTimeout(() => {
                        closeSuccessToast();
                    }, 3000);
                }
            });
            
            // Responsive adjustments
            function adjustFormLayout() {
                const form = document.querySelector('.max-w-2xl');
                if (window.innerWidth < 640) {
                    form.classList.remove('max-w-2xl');
                    form.classList.add('max-w-full', 'px-4');
                } else {
                    form.classList.remove('max-w-full', 'px-4');
                    form.classList.add('max-w-2xl');
                }
            }
            
            window.addEventListener('resize', adjustFormLayout);
            adjustFormLayout();
        });
    </script>
    <!-- Dropzone.js CSS -->
    <!-- Dropzone.js Script -->
    <!-- Dropzone.js CSS -->
    <style>
        /* The styles for Dropzone.js are no longer needed as the new file input is simpler. */
        /*
        .dropzone {
            border: 2px dashed #f59e0b;
            background: #fef9c3;
            border-radius: 1rem;
            min-height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            cursor: pointer;
        }
        .dropzone .dz-message {
            color: #b45309;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .dropzone .dz-preview .dz-image img {
            border-radius: 0.5rem;
        }
        #dzPreviewContainer .dz-preview {
            margin-bottom: 0 !important;
            margin-right: 0 !important;
        }
        #dzPreviewContainer .dz-preview .dz-progress {
            display: none;
        }
        #dzPreviewContainer .dz-preview button[data-dz-remove] {
            z-index: 20;
        }
        @media (max-width: 640px) {
            #customDropzone { height: 16rem; }
            #dzPreviewContainer { flex-direction: column; gap: 0.5rem; }
            #dzPreviewContainer .dz-preview { width: 5rem; height: 5rem; }
        }
        */
    </style>
</x-dashboard-layout>