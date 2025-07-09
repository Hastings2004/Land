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
            <i class="fas fa-bookmark text-white text-xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">My Saved Plots</h1>
        <p class="text-gray-600">Your favorite land investments</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $savedPlots->total() }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Total Saved</div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-bookmark text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-green-600">MK{{ number_format($savedPlots->sum('price')) }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Total Value</div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-blue-600">{{ $savedPlots->where('status', 'available')->count() }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Available</div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Saved Plots Content -->
        @if($savedPlots->isEmpty())
        <!-- Beautiful Empty State -->
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="max-w-md mx-auto">
                <!-- Animated Icon -->
                <div class="relative mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                        <i class="fas fa-bookmark text-yellow-500 text-4xl"></i>
                    </div>
                    <!-- Floating Elements -->
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-300 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                    <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-yellow-400 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
                    <div class="absolute top-1/2 -right-4 w-4 h-4 bg-yellow-500 rounded-full animate-bounce" style="animation-delay: 0.6s;"></div>
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-4">Start Building Your Collection!</h2>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Save your favorite land plots to keep track of potential investments. 
                    Your saved plots will appear here for easy access and comparison.
                </p>

                <!-- Call to Action -->
                <div class="space-y-4">
                    <a href="{{ route('customer.plots.index') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl hover:from-yellow-600 hover:to-yellow-700 font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-search mr-3"></i>
                        Explore Available Plots
                    </a>

                </div>
            </div>
        </div>
        @else
        <!-- Saved Plots Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($savedPlots as $plot)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                    <!-- Plot Image -->
                    <div class="relative overflow-hidden">
                        <img src="
                            @if($plot->plotImages && $plot->plotImages->count() > 0)
                                {{ $plot->plotImages->first()->image_url }}
                            @elseif($plot->image_path)
                                {{ asset('storage/' . $plot->image_path) }}
                            @else
                                https://placehold.co/400x250
                            @endif
                        " alt="{{ $plot->title }}"
                             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-700">
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
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

                        <!-- Quick Actions Overlay -->
                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="flex space-x-2">
                                <button onclick="sharePlot({{ $plot->id }})" 
                                        class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-gray-700 hover:bg-white transition-colors duration-200">
                                    <i class="fas fa-share-alt text-sm"></i>
                                </button>
                                <button onclick="savePlot({{ $plot->id }})" 
                                        class="w-8 h-8 bg-red-500/90 rounded-full flex items-center justify-center text-white hover:bg-red-500 transition-colors duration-200">
                                    <i class="fas fa-heart text-sm"></i>
                                </button>
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
                        
                        <!-- Price -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-yellow-600">MK{{ number_format($plot->price) }}</span>
                            <span class="text-sm text-gray-500">{{ number_format($plot->area_sqm, 2) }} sqm</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-3">
                            <a href="{{ route('customer.plots.show', $plot->id) }}" 
                               class="flex-1 bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600 transition-colors duration-200 text-center font-semibold text-sm">
                                <i class="fas fa-eye mr-2"></i>View Details
                            </a>
                            <form action="{{ route('customer.saved-plots.destroy', $plot->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Remove this plot from your saved list?')"
                                        class="w-full bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition-colors duration-200 font-semibold text-sm">
                                    <i class="fas fa-trash mr-2"></i>Remove
                                </button>
                                    </form>
                                </div>
                    </div>
                </div>
                    @endforeach
        </div>

        <!-- Pagination -->
        @if($savedPlots->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $savedPlots->links() }}
            </div>
        @endif
    @endif

    <!-- Remove Plot Modal -->
    <div id="removePlotModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 max-w-sm w-full text-center">
            <div id="removePlotModalIcon" class="mb-4 text-4xl"></div>
            <div id="removePlotModalMessage" class="text-lg font-semibold mb-6"></div>
            <button onclick="closeRemovePlotModal()" class="px-6 py-2 bg-yellow-500 text-white rounded-lg font-bold hover:bg-yellow-600 transition">OK</button>
        </div>
    </div>

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

        function showRemovePlotModal(message, type = 'success') {
            const modal = document.getElementById('removePlotModal');
            const icon = document.getElementById('removePlotModalIcon');
            const msg = document.getElementById('removePlotModalMessage');
            if (type === 'success') {
                icon.innerHTML = '<i class="fas fa-check-circle text-green-500"></i>';
            } else {
                icon.innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i>';
            }
            msg.textContent = message;
            modal.classList.remove('hidden');
        }

        function closeRemovePlotModal() {
            document.getElementById('removePlotModal').classList.add('hidden');
            // Optionally reload the page to update the list
            window.location.reload();
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form[action*="saved-plots.destroy"]').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (!confirm('Remove this plot from your saved list?')) return;
                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(async response => {
                        let data;
                        try {
                            data = await response.json();
                        } catch (e) {
                            showRemovePlotModal('Failed to remove plot. Please try again.', 'error');
                            return;
                        }
                        if (data.success) {
                            showRemovePlotModal('Plot removed from saved list.', 'success');
                        } else {
                            showRemovePlotModal(data.message || 'Failed to remove plot.', 'error');
                        }
                    })
                    .catch(() => {
                        showRemovePlotModal('Failed to remove plot. Please try again.', 'error');
                    });
                });
            });
        });
    </script>
</x-dashboard-layout>
