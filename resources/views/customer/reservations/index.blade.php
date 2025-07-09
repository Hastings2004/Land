<x-dashboard-layout>
    <!-- Page Header -->
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-2xl shadow-xl mb-4 transform rotate-3 hover:rotate-0 transition-transform duration-300">
            <i class="fas fa-calendar-check text-white text-xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">My Reservations</h1>
        <p class="text-gray-600">Track your land plot reservations</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['total'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Total Reservations</div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Active</div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['pending'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Pending</div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservations List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-list text-yellow-500 mr-2"></i>
                My Reservations
            </h2>
        </div>

        @if($reservations->count() > 0)
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($reservations as $reservation)
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                <!-- Plot Information -->
                                <div class="flex-1 mb-4 lg:mb-0">
                                    <div class="flex items-start space-x-4">
                                        <img src="{{ $reservation->plot->image_path ? asset('storage/' . $reservation->plot->image_path) : 'https://placehold.co/80x80' }}"
                                             alt="{{ $reservation->plot->title }}"
                                             class="w-20 h-20 object-cover rounded-lg shadow-sm">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $reservation->plot->title }}</h3>
                                            <p class="text-gray-600 mb-2 flex items-center">
                                                <i class="fas fa-map-marker-alt text-yellow-500 mr-2"></i>
                                                {{ $reservation->plot->location }}
                                            </p>
                                            <p class="text-xl font-bold text-yellow-600">${{ number_format($reservation->plot->price) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status and Actions -->
                                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                                    <!-- Status Badge -->
                                    <div class="flex-shrink-0">
                                        @if($reservation->status === 'active')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                Active
                                            </span>
                                        @elseif($reservation->status === 'pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-2"></i>
                                                Pending
                                            </span>
                                        @elseif($reservation->status === 'approved')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-thumbs-up mr-2"></i>
                                                Approved
                                            </span>
                                        @elseif($reservation->status === 'rejected')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-2"></i>
                                                Rejected
                                            </span>
                                        @elseif($reservation->status === 'expired')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-hourglass-end mr-2"></i>
                                                Expired
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                {{ ucfirst($reservation->status) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Date Information -->
                                    <div class="text-sm text-gray-500">
                                        <div>Reserved: {{ $reservation->created_at->format('M d, Y') }}</div>
                                        @if($reservation->expires_at)
                                            <div class="text-xs">
                                                Expires: {{ $reservation->expires_at->format('M d, Y') }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('customer.plots.show', $reservation->plot) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200 text-sm font-medium">
                                            <i class="fas fa-eye mr-2"></i>
                                            View Plot
                                        </a>
                                        
                                        @if($reservation->status === 'active')
                                            <form action="{{ route('customer.reservations.destroy', $reservation) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to cancel this reservation?')"
                                                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 text-sm font-medium">
                                                    <i class="fas fa-times mr-2"></i>
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $reservations->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-times text-yellow-500 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Reservations Yet</h3>
                <p class="text-gray-500 mb-6">You haven't made any plot reservations yet.</p>
                <a href="{{ route('customer.plots.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200 font-medium">
                    <i class="fas fa-search mr-2"></i>
                    Browse Plots
                </a>
            </div>
        @endif
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce-in">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

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
    </script>
</x-dashboard-layout> 