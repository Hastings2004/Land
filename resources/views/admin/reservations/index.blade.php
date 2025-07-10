<x-dashboard-layout>
    <!-- Page Header -->
    <div class="mb-8 text-center relative">
        <!-- Back Button -->
        <div class="absolute left-0 top-1/2 transform -translate-y-1/2">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-yellow-300 rounded-lg shadow-sm hover:bg-yellow-50 hover:border-yellow-400 focus:ring-2 focus:ring-yellow-400 transition-all duration-200 text-yellow-600 font-semibold">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-yellow-400 to-amber-500 rounded-2xl shadow-xl mb-4 transform rotate-3 hover:rotate-0 transition-transform duration-300">
            <i class="fas fa-calendar-check text-white text-xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Reservations Management</h1>
        <p class="text-gray-600">Manage all plot reservations</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Total Reservations</div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar text-blue-600 text-xl"></i>
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

    <!-- Reservations Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-list text-yellow-500 mr-2"></i>
                All Reservations
            </h2>
        </div>

        @if($reservations->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Plot Details
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reservations as $reservation)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            {{ strtoupper(substr($reservation->user->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $reservation->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $reservation->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start space-x-4">
                                        <img src="{{ $reservation->plot->plotImages && $reservation->plot->plotImages->count() > 0 ? $reservation->plot->plotImages->first()->image_url : ($reservation->plot->image_path ? asset('storage/' . $reservation->plot->image_path) : 'https://placehold.co/300x200') }}"
                                             alt="{{ $reservation->plot->title }}"
                                             class="w-72 h-48 object-cover rounded-lg shadow-sm">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 mb-1">{{ $reservation->plot->title }}</div>
                                            <div class="flex items-center mb-1">
                                                <i class="fas fa-map-marker-alt text-yellow-500 mr-2"></i>
                                                <span class="text-gray-600">{{ $reservation->plot->location }}</span>
                                            </div>
                                            <div class="flex items-center mb-1">
                                                <i class="fas fa-ruler-combined text-yellow-500 mr-2"></i>
                                                <span class="text-gray-600">Area: {{ number_format($reservation->plot->area_sqm, 2) }} sqm</span>
                                            </div>
                                            <div class="flex items-center mb-1">
                                                <i class="fas fa-tag text-yellow-500 mr-2"></i>
                                                <span class="text-gray-600">Category: {{ ucfirst($reservation->plot->category) }}</span>
                                            </div>
                                            <div class="text-xs text-gray-400">Price: MWK {{ number_format($reservation->plot->price, 2) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($reservation->status === 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Active
                                        </span>
                                        @php
                                            $minutesLeft = $reservation->expires_at ? now()->diffInMinutes($reservation->expires_at, false) : null;
                                        @endphp
                                        @if($minutesLeft !== null && $minutesLeft <= 120 && $minutesLeft > 0)
                                            <div class="mt-1 text-xs text-red-600 font-semibold flex items-center">
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
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-thumbs-up mr-1"></i>
                                            Completed
                                        </span>
                                    @elseif($reservation->status === 'cancelled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Cancelled
                                        </span>
                                    @elseif($reservation->status === 'expired')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-hourglass-end mr-1"></i>
                                            Expired
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($reservation->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ $reservation->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $reservation->created_at->format('g:i A') }}</div>
                                    @if($reservation->expires_at)
                                        <div class="text-xs text-gray-400">
                                            Expires: {{ $reservation->expires_at->format('M d, Y g:i A') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if($reservation->status === 'active')
                                            <form action="{{ route('admin.reservations.approve', $reservation) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-500 text-white hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-400 transition-all duration-200" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.reservations.reject', $reservation) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-500 text-white hover:bg-red-600 focus:ring-2 focus:ring-red-200 transition-all duration-200" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.plots.show', $reservation->plot) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 text-white hover:bg-blue-600 focus:ring-2 focus:ring-blue-200 transition-all duration-200" title="View Plot">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $reservations->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-times text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Reservations Found</h3>
                <p class="text-gray-500">There are no reservations to display at the moment.</p>
            </div>
        @endif
    </div>

    <!-- Success Message -->
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
            </div>
        </div>
    @endif

    <script>
        // Auto-hide success toast after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('successToast');
            if (toast) {
                // Slide in the toast
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);
                
                // Auto-hide after 3 seconds
                setTimeout(() => {
                    closeSuccessToast();
                }, 3000);
            }
        });
        
        function closeSuccessToast() {
            const toast = document.getElementById('successToast');
            if (toast) {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }
        }
    </script>
</x-dashboard-layout> 