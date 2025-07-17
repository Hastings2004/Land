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
                        Sold
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
                    <button type="button" 
                            onclick="makePayment({{ $reservation->id }}, {{ $reservation->plot->price }}, '{{ auth()->user()->email }}', '{{ auth()->user()->name }}')" 
                            class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 font-semibold text-xs uppercase transition">
                        <i class="fas fa-credit-card mr-2"></i> Pay Now 
                    </button>
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