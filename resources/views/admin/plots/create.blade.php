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
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Upload Images</label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*" class="block w-full text-sm text-gray-700 border border-yellow-300 rounded-lg cursor-pointer bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <div id="imagePreviewGallery" class="mt-4 flex flex-wrap gap-3"></div>
                    <p class="text-xs text-gray-500 mt-2">Select all images at once (hold Ctrl or Shift). Max 10MB each.</p>
                    @error('images.*')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
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
            // const dzPreviewContainer = document.getElementById('dzPreviewContainer'); // This line is no longer needed
            // const customDropzone = document.getElementById('customDropzone'); // This line is no longer needed
            // const mainForm = document.querySelector('form[action*="admin.plots.store"]'); // This line is no longer needed

            // const myDropzone = new Dropzone(customDropzone, { // This block is no longer needed
            //     url: '#', // Prevent auto-upload
            //     autoProcessQueue: false,
            //     uploadMultiple: true,
            //     parallelUploads: 10,
            //     maxFiles: 10,
            //     maxFilesize: 10, // MB
            //     acceptedFiles: 'image/*',
            //     addRemoveLinks: false, // We'll use custom remove buttons
            //     previewsContainer: dzPreviewContainer,
            //     clickable: customDropzone,
            //     previewTemplate: `<div class='dz-preview dz-image-preview relative group w-24 h-24 rounded-lg overflow-hidden border-2 border-yellow-300 bg-white shadow-md flex items-center justify-center'>
            //         <img data-dz-thumbnail class='w-full h-full object-cover rounded-lg' />
            //         <button type='button' class='absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-80 hover:opacity-100 transition' data-dz-remove title='Remove'><i class='fas fa-times text-xs'></i></button>
            //     </div>`
            // });

            // // Custom remove button handler
            // customDropzone.addEventListener('click', function(e) {
            //     if (e.target.closest('[data-dz-remove]')) {
            //         const preview = e.target.closest('.dz-preview');
            //         if (preview) {
            //             const file = preview.file;
            //             myDropzone.removeFile(file);
            //         }
            //     }
            // });

            // // Responsive: adjust preview container layout
            // function updatePreviewLayout() {
            //     if (window.innerWidth < 640) {
            //         dzPreviewContainer.classList.add('flex-col');
            //         dzPreviewContainer.classList.remove('flex-wrap');
            //     } else {
            //         dzPreviewContainer.classList.remove('flex-col');
            //         dzPreviewContainer.classList.add('flex-wrap');
            //     }
            // }
            // window.addEventListener('resize', updatePreviewLayout);
            // updatePreviewLayout();

            // On form submit, append all Dropzone files to a hidden file input and submit natively
            // mainForm.addEventListener('submit', function(e) { // This block is no longer needed
            //     // Remove any previous hidden file input
            //     const oldInput = document.getElementById('dz-hidden-upload');
            //     if (oldInput) oldInput.remove();
            //     if (myDropzone.files.length > 0) {
            //         // Create a new hidden file input
            //         const input = document.createElement('input');
            //         input.type = 'file';
            //         input.name = 'images[]';
            //         input.id = 'dz-hidden-upload';
            //         input.multiple = true;
            //         // Create a DataTransfer to hold the files
            //         const dataTransfer = new DataTransfer();
            //         myDropzone.files.forEach(file => {
            //             if (file.status === 'added' || file.status === 'queued') {
            //                 dataTransfer.items.add(file);
            //             }
            //         });
            //         input.files = dataTransfer.files;
            //         input.style.display = 'none';
            //         mainForm.appendChild(input);
            //     }
            //     // Allow the form to submit natively
            // });
            
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

            document.getElementById('images').addEventListener('change', function(e) {
                const preview = document.getElementById('imagePreviewGallery');
                preview.innerHTML = '';
                Array.from(e.target.files).forEach(file => {
                    if (!file.type.startsWith('image/')) return;
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        const img = document.createElement('img');
                        img.src = ev.target.result;
                        img.className = 'w-24 h-24 object-cover rounded border shadow';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
    <!-- Dropzone.js CSS -->
    <!-- Dropzone.js Script -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script> -->
    <style>
        /* #customDropzone.dz-drag-hover { // This rule is no longer needed */
        /*     background-color: #fef3c7; */
        /*     border-color: #f59e0b; */
        /* } */
        /* #dzPreviewContainer .dz-preview { // This rule is no longer needed */
        /*     margin-bottom: 0 !important; */
        /*     margin-right: 0 !important; */
        /* } */
        /* #dzPreviewContainer .dz-preview .dz-progress { // This rule is no longer needed */
        /*     display: none; */
        /* } */
        /* #dzPreviewContainer .dz-preview button[data-dz-remove] { // This rule is no longer needed */
        /*     z-index: 20; */
        /* } */
        /* @media (max-width: 640px) { // This rule is no longer needed */
        /*     #customDropzone { height: 16rem; } */
        /*     #dzPreviewContainer { flex-direction: column; gap: 0.5rem; } */
        /*     #dzPreviewContainer .dz-preview { width: 5rem; height: 5rem; } */
        /* } */
    </style>
</x-dashboard-layout>