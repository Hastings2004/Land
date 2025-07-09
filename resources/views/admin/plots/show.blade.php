<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{env(key: 'APP_NAME')}} - Plot Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            @apply bg-gray-100 text-gray-800;
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
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    @auth()
    <!-- Back Button -->
    <div class="fixed top-4 left-4 z-50">
        <a href="{{ route('admin.plots.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-white/90 backdrop-blur-sm text-gray-700 rounded-lg shadow-lg hover:bg-white transition-all duration-300 border border-gray-200 hover:shadow-xl transform hover:-translate-y-1">
            <i class="fas fa-arrow-left mr-2 text-yellow-600"></i>
            <span class="font-medium">All Plots</span>
        </a>
    </div>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
        <!-- Success Message Display -->
        @if(session('success'))
            <div class="max-w-5xl mx-auto mb-4">
                <div id="success-message" class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl flex items-center shadow-lg transform transition-all duration-500">
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
            </div>
            @endif

        <!-- Header Section -->
        <div class="max-w-5xl mx-auto mb-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="p-2 bg-gradient-to-r from-yellow-500 to-amber-500 rounded-lg shadow-md">
                                <i class="fas fa-map-marker-alt text-white text-lg"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800 mb-1">{{ $plot->title }}</h1>
                                <p class="text-base text-gray-600 flex items-center">
                                    <i class="fas fa-location-dot text-yellow-600 mr-2"></i>
                                    {{ $plot->location }}
                                </p>
                            </div>
                        </div>
                        
                        @if($plot->is_new_listing)
                            <div class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-full text-xs font-semibold shadow-md animate-pulse">
                                <i class="fas fa-star mr-1"></i>
                                New Listing
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-4 lg:mt-0 lg:ml-6">
                        <div class="bg-gradient-to-r from-yellow-500 to-amber-500 rounded-xl p-4 text-white shadow-lg">
                            <div class="text-center">
                                <div class="text-2xl font-bold mb-1">K{{ number_format($plot->price, 2) }}</div>
                                <div class="text-yellow-100 text-xs">Total Price</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Plot Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Plot Information Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-amber-500 px-4 py-3">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Plot Information
                        </h2>
                    </div>
                    
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="bg-gray-50 rounded-lg p-3 hover:bg-yellow-50 transition-all duration-300 cursor-pointer group">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-200 transition-colors">
                                                <i class="fas fa-ruler-combined text-yellow-700 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 font-medium">Area</p>
                                                <p class="text-sm font-bold text-gray-800">{{ number_format($plot->area_sqm, 2) }} sqm</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-3 hover:bg-yellow-50 transition-all duration-300 cursor-pointer group">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-200 transition-colors">
                                                <i class="fas fa-tag text-yellow-700 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 font-medium">Status</p>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $plot->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    <i class="fas fa-circle mr-1 text-xs"></i>
                        {{ ucfirst($plot->status) }}
                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="bg-gray-50 rounded-lg p-3 hover:bg-yellow-50 transition-all duration-300 cursor-pointer group">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-200 transition-colors">
                                                <i class="fas fa-eye text-yellow-700 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 font-medium">Views</p>
                                                <p class="text-sm font-bold text-gray-800">{{ $plot->views ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-3 hover:bg-yellow-50 transition-all duration-300 cursor-pointer group">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-200 transition-colors">
                                                <i class="fas fa-calendar text-yellow-700 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 font-medium">Listed</p>
                                                <p class="text-sm font-bold text-gray-800">{{ $plot->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-yellow-500 px-4 py-3">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-align-left mr-2"></i>
                            Description
                        </h2>
                    </div>
                    
                    <div class="p-4">
                        <div class="prose prose-sm max-w-none">
                            <p class="text-gray-700 leading-relaxed text-sm">{{ $plot->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Plot Images Gallery -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-4 py-3">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-images mr-2"></i>
                            Plot Images
                        </h2>
                    </div>

                    <div class="p-4">
                        @if($plot->plotImages->count() > 0)
                            <!-- Carousel for multiple images -->
                            <div class="relative group w-full h-80 md:h-[28rem] bg-gray-100 flex items-center justify-center">
                                <div id="admin-carousel" class="w-full h-full relative">
                                    @foreach($plot->plotImages as $index => $image)
                                        <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?: $plot->title }}" class="admin-carousel-img absolute inset-0 w-full h-full object-cover transition-opacity duration-700 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" data-index="{{ $index }}">
                                    @endforeach
                                    @if($plot->plotImages->count() > 1)
                                        <button onclick="adminPrevImage()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-yellow-500/80 hover:bg-yellow-600 text-white rounded-full p-2 shadow-lg z-20"><i class="fas fa-chevron-left"></i></button>
                                        <button onclick="adminNextImage()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-yellow-500/80 hover:bg-yellow-600 text-white rounded-full p-2 shadow-lg z-20"><i class="fas fa-chevron-right"></i></button>
                                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-20">
                                            @foreach($plot->plotImages as $index => $image)
                                                <span class="admin-carousel-dot w-3 h-3 rounded-full bg-white border-2 border-yellow-500 cursor-pointer {{ $index === 0 ? 'bg-yellow-500' : '' }}" data-index="{{ $index }}"></span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @elseif($plot->image_path)
                            <!-- Fallback for old single image -->
                            <div class="relative group cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $plot->image_path) }}', '{{ $plot->title }}')">
                                <img src="{{ asset('storage/' . $plot->image_path) }}" alt="Plot Image" 
                                     class="w-full h-64 object-cover rounded-lg shadow-md group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-expand text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-images text-yellow-600 text-xl"></i>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-800 mb-1">No Images Available</h3>
                                <p class="text-gray-600 text-xs">This plot doesn't have any images uploaded yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <script>
                // Admin carousel logic (copied from customer view, adapted for admin)
                document.addEventListener('DOMContentLoaded', function() {
                    const images = document.querySelectorAll('.admin-carousel-img');
                    const dots = document.querySelectorAll('.admin-carousel-dot');
                    let currentIndex = 0;
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
                    window.adminPrevImage = function() {
                        let idx = currentIndex - 1;
                        if (idx < 0) idx = images.length - 1;
                        showImage(idx);
                    };
                    window.adminNextImage = function() {
                        let idx = (currentIndex + 1) % images.length;
                        showImage(idx);
                    };
                    dots.forEach((dot, i) => {
                        dot.addEventListener('click', () => showImage(i));
                    });
                    if (images.length > 0) showImage(0);
                    // Optional: auto-slide
                    if (images.length > 1) {
                        let autoSlide = setInterval(() => window.adminNextImage(), 4000);
                        document.getElementById('admin-carousel').addEventListener('mouseenter', () => clearInterval(autoSlide));
                        document.getElementById('admin-carousel').addEventListener('mouseleave', () => { autoSlide = setInterval(() => window.adminNextImage(), 4000); });
                    }
                });
                </script>

                <!-- Reviews Section -->
                <div class="bg-white rounded-xl shadow-lg border border-yellow-100 mt-8 p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-star text-yellow-500"></i> Customer Reviews
                    </h2>
                    @if($plot->reviews->isEmpty())
                        <p class="text-gray-600">No reviews yet for this plot.</p>
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
            </div>

            <!-- Right Column - Actions & Quick Info (Always on the right) -->
            <div class="space-y-4">
                <!-- Quick Actions Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-amber-500 px-4 py-3">
                        <h2 class="text-base font-bold text-white flex items-center">
                            <i class="fas fa-bolt mr-2"></i>
                            Quick Actions
                        </h2>
            </div>

                    <div class="p-4 space-y-3">
            @auth
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <a href="{{ route('admin.plots.edit', $plot) }}" 
                                   class="w-full flex items-center justify-center px-4 py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg font-semibold hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1 text-sm">
                                    <i class="fas fa-edit mr-2"></i>
                            Edit Plot
                        </a>

                                <form action="{{ route('admin.plots.destroy', $plot) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plot? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                            class="w-full flex items-center justify-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg font-semibold hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1 text-sm">
                                        <i class="fas fa-trash mr-2"></i>
                                Delete Plot
                            </button>
                        </form>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Plot Statistics Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-yellow-500 px-4 py-3">
                        <h2 class="text-base font-bold text-white flex items-center">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Statistics
                        </h2>
                    </div>
                    
                    <div class="p-4 space-y-3">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-yellow-100 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-eye text-yellow-700 text-xs"></i>
                                </div>
                                <span class="text-gray-700 font-medium text-xs">Total Views</span>
                            </div>
                            <span class="text-lg font-bold text-gray-800">{{ $plot->views ?? 0 }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-yellow-100 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-star text-yellow-700 text-xs"></i>
                                </div>
                                <span class="text-gray-700 font-medium text-xs">Reviews</span>
                            </div>
                            <span class="text-lg font-bold text-gray-800">{{ $plot->reviews->count() }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-yellow-100 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-comments text-yellow-700 text-xs"></i>
                                </div>
                                <span class="text-gray-700 font-medium text-xs">Inquiries</span>
                            </div>
                            <span class="text-lg font-bold text-gray-800">{{ $plot->inquiries ? $plot->inquiries->count() : 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <!-- Interactive JavaScript -->
    <script>
        // Add smooth scrolling and interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to cards
            const cards = document.querySelectorAll('.bg-gray-50');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.05)';
                });
            });

            // Add click effects to action buttons
            const actionButtons = document.querySelectorAll('button, a[href]');
            actionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                });
            });

            // Animate elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all cards for animation
            document.querySelectorAll('.bg-white').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
            
            // Auto-hide success message
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                // Add entrance animation
                successMessage.style.opacity = '0';
                successMessage.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    successMessage.style.opacity = '1';
                    successMessage.style.transform = 'translateY(0)';
                }, 100);
                
                // Auto-hide after 3 seconds
                setTimeout(() => {
                    hideSuccessMessage();
                }, 3000);
            }
            
            // Function to hide success message
            window.hideSuccessMessage = function() {
                const message = document.getElementById('success-message');
                if (message) {
                    message.style.transform = 'translateY(-20px)';
                    message.style.opacity = '0';
                    setTimeout(() => {
                        message.style.display = 'none';
                    }, 500);
                }
            };
        });

        // Image modal functionality
        function openImageModal(imageUrl, title) {
            // Create modal overlay
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4';
            modal.onclick = function() {
                document.body.removeChild(modal);
            };

            // Create modal content
            const modalContent = document.createElement('div');
            modalContent.className = 'relative max-w-4xl max-h-full';
            modalContent.onclick = function(e) {
                e.stopPropagation();
            };

            // Create image
            const img = document.createElement('img');
            img.src = imageUrl;
            img.alt = title;
            img.className = 'max-w-full max-h-full object-contain rounded-lg shadow-2xl';

            // Create close button
            const closeBtn = document.createElement('button');
            closeBtn.className = 'absolute top-4 right-4 bg-white bg-opacity-90 text-gray-800 rounded-full p-2 hover:bg-white transition-all duration-300 shadow-lg';
            closeBtn.innerHTML = '<i class="fas fa-times text-lg"></i>';
            closeBtn.onclick = function() {
                document.body.removeChild(modal);
            };

            // Create title
            const titleDiv = document.createElement('div');
            titleDiv.className = 'absolute bottom-4 left-4 bg-black bg-opacity-75 text-white px-4 py-2 rounded-lg';
            titleDiv.textContent = title;

            // Assemble modal
            modalContent.appendChild(img);
            modalContent.appendChild(closeBtn);
            modalContent.appendChild(titleDiv);
            modal.appendChild(modalContent);

            // Add to body
            document.body.appendChild(modal);

            // Add escape key listener
            const escapeHandler = function(e) {
                if (e.key === 'Escape') {
                    document.body.removeChild(modal);
                    document.removeEventListener('keydown', escapeHandler);
                }
            };
            document.addEventListener('keydown', escapeHandler);
        }
    </script>
</body>
</html>