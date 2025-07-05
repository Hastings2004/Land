<x-dashboard-layout>
    <!-- Hero Section with Welcome Message -->
    <div class="bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 p-8 rounded-b-3xl shadow-lg">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Welcome back, {{ auth()->user()->username }}! 👋</h1>
                    <p class="text-yellow-100 text-lg">Here's what's happening with your land investments today</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-full p-4">
                        <i class="fas fa-chart-line text-white text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-8 -mt-6">
        <div class="max-w-7xl mx-auto">
            <!-- Statistics Cards with Yellow Theme -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Saved Plots Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="p-4 rounded-full bg-gradient-to-br from-yellow-100 to-yellow-200">
                            <i class="fas fa-bookmark text-yellow-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Saved Plots</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['savedPlots'] }}</p>
                            <p class="text-xs text-yellow-600 font-medium">Your favorites</p>
                        </div>
                    </div>
                </div>

                <!-- Reservations Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="p-4 rounded-full bg-gradient-to-br from-yellow-100 to-yellow-200">
                            <i class="fas fa-calendar-check text-yellow-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Reservations</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['reservations'] }}</p>
                            <p class="text-xs text-yellow-600 font-medium">Active bookings</p>
                        </div>
                    </div>
                </div>

                <!-- Inquiries Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="p-4 rounded-full bg-gradient-to-br from-yellow-100 to-yellow-200">
                            <i class="fas fa-envelope text-yellow-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Inquiries</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['inquiries'] }}</p>
                            <p class="text-xs text-yellow-600 font-medium">Messages sent</p>
                        </div>
                    </div>
                </div>

                <!-- Reviews Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="p-4 rounded-full bg-gradient-to-br from-yellow-100 to-yellow-200">
                            <i class="fas fa-star text-yellow-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Reviews</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['reviews'] }}</p>
                            <p class="text-xs text-yellow-600 font-medium">Your feedback</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Recent Saved Plots -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-bookmark text-yellow-500 mr-3"></i>
                            Recent Saved Plots
                        </h3>
                        <a href="{{ route('customer.saved-plots.index') }}" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium flex items-center">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    @if($recentSavedPlots->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentSavedPlots as $plot)
                                <div class="flex items-center space-x-4 p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl hover:shadow-md transition-all duration-300">
                                    <img src="{{ $plot->image_path ? asset('storage/' . $plot->image_path) : 'https://placehold.co/80x80' }}"
                                         alt="{{ $plot->title }}"
                                         class="w-16 h-16 object-cover rounded-xl shadow-sm">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 text-lg">{{ $plot->title }}</h4>
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-map-marker-alt text-yellow-500 mr-1"></i>
                                            {{ $plot->location }}
                                        </p>
                                        <p class="text-lg font-bold text-yellow-600">${{ number_format($plot->price) }}</p>
                                    </div>
                                    <a href="{{ route('customer.plots.show', $plot->id) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        View
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-bookmark text-yellow-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 text-lg">No saved plots yet</p>
                            <p class="text-gray-400 text-sm">Start exploring and save your favorite plots!</p>
                        </div>
                    @endif
                </div>

                <!-- Active Reservations -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-calendar-check text-yellow-500 mr-3"></i>
                            Active Reservations
                        </h3>
                        <a href="{{ route('customer.reservations.index') }}" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium flex items-center">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    @if($activeReservations->count() > 0)
                        <div class="space-y-4">
                            @foreach($activeReservations as $reservation)
                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl border-l-4 border-yellow-500">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <img src="{{ $reservation->plot->image_path ? asset('storage/' . $reservation->plot->image_path) : 'https://placehold.co/60x60' }}"
                                             alt="{{ $reservation->plot->title }}"
                                             class="w-12 h-12 object-cover rounded-lg">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900">{{ $reservation->plot->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $reservation->plot->location }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm">
                                            <p class="text-gray-600">Expires: {{ $reservation->expires_at->format('M d, Y') }}</p>
                                            <p class="text-yellow-600 font-semibold">{{ $reservation->expires_at->diffForHumans() }}</p>
                                        </div>
                                        <a href="{{ route('customer.plots.show', $reservation->plot->id) }}"
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm font-medium transition-colors">
                                            View
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-calendar-check text-yellow-500 text-xl"></i>
                            </div>
                            <p class="text-gray-500">No active reservations</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Inquiries -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-envelope text-yellow-500 mr-3"></i>
                        Recent Inquiries
                    </h3>
                    <a href="{{ route('customer.inquiries.index') }}" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium flex items-center">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                @if($recentInquiries->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($recentInquiries as $inquiry)
                                    <tr class="hover:bg-yellow-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $inquiry->name }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($inquiry->message, 60) }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @switch($inquiry->status)
                                                    @case('new') bg-blue-100 text-blue-800 @break
                                                    @case('viewed') bg-yellow-100 text-yellow-800 @break
                                                    @case('responded') bg-green-100 text-green-800 @break
                                                    @case('closed') bg-gray-100 text-gray-800 @break
                                                    @default bg-gray-100 text-gray-800
                                                @endswitch">
                                                {{ ucfirst($inquiry->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $inquiry->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('customer.inquiries.show', $inquiry->id) }}"
                                               class="text-yellow-600 hover:text-yellow-700 font-medium">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-envelope text-yellow-500 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 text-lg">No inquiries yet</p>
                        <p class="text-gray-400 text-sm">Start asking questions about plots you're interested in!</p>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-3"></i>
                    Quick Actions
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('customer.plots.index') }}" class="group flex items-center p-6 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl hover:from-yellow-100 hover:to-yellow-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="p-3 bg-yellow-500 rounded-lg group-hover:bg-yellow-600 transition-colors">
                            <i class="fas fa-search text-white text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <span class="text-gray-900 font-semibold">Browse Plots</span>
                            <p class="text-sm text-gray-600">Find your perfect land</p>
                        </div>
                    </a>

                    <a href="{{ route('customer.inquiries.create') }}" class="group flex items-center p-6 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl hover:from-yellow-100 hover:to-yellow-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="p-3 bg-yellow-500 rounded-lg group-hover:bg-yellow-600 transition-colors">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <span class="text-gray-900 font-semibold">Send Inquiry</span>
                            <p class="text-sm text-gray-600">Ask questions</p>
                        </div>
                    </a>

                    <a href="{{ route('customer.saved-plots.index') }}" class="group flex items-center p-6 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl hover:from-yellow-100 hover:to-yellow-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="p-3 bg-yellow-500 rounded-lg group-hover:bg-yellow-600 transition-colors">
                            <i class="fas fa-bookmark text-white text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <span class="text-gray-900 font-semibold">Saved Plots</span>
                            <p class="text-sm text-gray-600">Your favorites</p>
                        </div>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="group flex items-center p-6 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl hover:from-yellow-100 hover:to-yellow-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                        <div class="p-3 bg-yellow-500 rounded-lg group-hover:bg-yellow-600 transition-colors">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <span class="text-gray-900 font-semibold">Edit Profile</span>
                            <p class="text-sm text-gray-600">Update details</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
