<x-dashboard-layout>
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-yellow-300 rounded-lg shadow-sm hover:bg-yellow-50 hover:border-yellow-400 focus:ring-2 focus:ring-yellow-400 transition-all duration-200 text-yellow-600 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>
            Back
        </a>
    </div>
    <!-- Page Header -->
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-2xl shadow-xl mb-4 transform rotate-3 hover:rotate-0 transition-transform duration-300">
            <i class="fas fa-calendar-check text-yellow-500 text-xl"></i>
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
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['completed'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Completed</div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-thumbs-up text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-gray-600">{{ $stats['expired'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Expired</div>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hourglass-end text-gray-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Cancelled</div>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
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
                                        <img src="{{ $reservation->plot->plotImages && $reservation->plot->plotImages->count() > 0 ? $reservation->plot->plotImages->first()->image_url : ($reservation->plot->image_path ? asset('storage/' . $reservation->plot->image_path) : 'https://placehold.co/300x200') }}"
                                             alt="{{ $reservation->plot->title }}"
                                             class="w-72 h-48 object-cover rounded-lg shadow-sm">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $reservation->plot->title }}</h3>
                                            <div class="flex items-center mb-2">
                                                <i class="fas fa-map-marker-alt text-yellow-500 mr-2"></i>
                                                <span class="text-gray-600">{{ $reservation->plot->location }}</span>
                                            </div>
                                            <div class="flex items-center mb-2">
                                                <i class="fas fa-ruler-combined text-yellow-500 mr-2"></i>
                                                <span class="text-gray-600">Area: {{ number_format($reservation->plot->area_sqm, 2) }} sqm</span>
                                            </div>
                                            <div class="flex items-center mb-2">
                                                <i class="fas fa-tag text-yellow-500 mr-2"></i>
                                                <span class="text-gray-600">Category: {{ ucfirst($reservation->plot->category) }}</span>
                                            </div>
                                            <p class="text-xl font-bold text-yellow-600 mb-2">MWK {{ number_format($reservation->plot->price, 2) }}</p>
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
                                            @php
                                                $minutesLeft = $reservation->expires_at ? now()->diffInMinutes($reservation->expires_at, false) : null;
                                            @endphp
                                            @if($minutesLeft !== null && $minutesLeft <= 120 && $minutesLeft > 0)
                                                <div class="mt-2 text-xs text-red-600 font-semibold flex items-center">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Grace period: {{ $minutesLeft }} minutes left to pay!
                                                </div>
                                            @endif
                                            @if($minutesLeft !== null && $minutesLeft > 0)
                                                <div class="mt-1 text-xs text-gray-500">
                                                    Time left: {{ $minutesLeft }} minutes
                                                </div>
                                            @endif
                                        @elseif($reservation->status === 'completed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-thumbs-up mr-2"></i>
                                                Completed
                                            </span>
                                        @elseif($reservation->status === 'cancelled')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-2"></i>
                                                Cancelled
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
                                            <form action="{{ route('customer.reservations.pay', $reservation) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 font-semibold text-xs uppercase transition">
                                                    <i class="fas fa-credit-card mr-2"></i> Pay Now
                                                </button>
                                            </form>
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