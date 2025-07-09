<x-dashboard-layout>
    <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('customer.inquiries.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>
                Back to My Inquiries
            </a>
        </div>

    <!-- Page Header -->
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-2xl shadow-xl mb-4 transform rotate-3 hover:rotate-0 transition-transform duration-300">
            <i class="fas fa-envelope-open text-white text-xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Inquiry Details</h1>
        <p class="text-gray-600">View your inquiry information and responses</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('info'))
        <div class="fixed top-4 right-4 bg-blue-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce-in">
            <div class="flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                {{ session('info') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce-in">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Status Banner -->
    <div class="mb-8">
        @switch($inquiry->status)
            @case('new')
                <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-clock text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold">New Inquiry</h3>
                            <p class="text-blue-600 text-xs">Your inquiry has been received and is awaiting review</p>
                        </div>
                    </div>
                </div>
                @break
            @case('viewed')
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-eye text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold">Inquiry Viewed</h3>
                            <p class="text-yellow-600 text-xs">Your inquiry has been reviewed by our team</p>
                        </div>
                    </div>
                </div>
                @break
            @case('responded')
                <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-reply text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold">Response Received</h3>
                            <p class="text-green-600 text-xs">We've responded to your inquiry. Check below for details.</p>
                        </div>
                    </div>
                </div>
                @break
            @case('closed')
                <div class="bg-gray-50 border border-gray-200 text-gray-800 p-4 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check-circle text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold">Inquiry Closed</h3>
                            <p class="text-gray-600 text-xs">This inquiry has been resolved and closed</p>
                        </div>
                    </div>
                </div>
                @break
            @default
                <div class="bg-gray-50 border border-gray-200 text-gray-800 p-4 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-info-circle text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold">Inquiry Status</h3>
                            <p class="text-gray-600 text-xs">Status: {{ ucfirst($inquiry->status) }}</p>
                        </div>
                    </div>
                </div>
        @endswitch
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Inquiry Details Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Card Header -->
                <div class="bg-yellow-50 border-b border-yellow-200 px-6 py-3">
                    <h2 class="text-lg font-bold text-yellow-800 flex items-center">
                        <i class="fas fa-file-alt mr-3 text-yellow-600"></i>
                        Inquiry Information
                    </h2>
                </div>

                <!-- Card Content -->
                <div class="p-6">
                    <!-- Subject -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">Subject</label>
                        <div class="text-xl font-bold text-gray-900 bg-yellow-50 p-4 rounded-xl border-l-4 border-yellow-500">
                            {{ $inquiry->name }}
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">Your Message</label>
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $inquiry->message }}</div>
                        </div>
                    </div>

                    <!-- Related Plot (if any) -->
                    @if($inquiry->plot)
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">Related Plot</label>
                        <div class="bg-blue-50 p-4 rounded-xl border-l-4 border-blue-500">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-blue-500 mr-3"></i>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $inquiry->plot->title }}</div>
                                    <div class="text-sm text-gray-600">{{ $inquiry->plot->location }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Admin Response (if any) -->
                    @if($inquiry->admin_response)
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">Admin Response</label>
                        <div class="bg-green-50 p-6 rounded-xl border-l-4 border-green-500">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-user-tie text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900 mb-2">Admin Response</div>
                                    <div class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $inquiry->admin_response }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="space-y-6">
            <!-- Contact Information Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-blue-50 border-b border-blue-200 px-6 py-3">
                    <h3 class="text-sm font-bold text-blue-800 flex items-center">
                        <i class="fas fa-user mr-3 text-blue-600"></i>
                        Contact Info
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <div class="text-gray-900 flex items-center">
                            <i class="fas fa-envelope text-yellow-500 mr-2"></i>
                            {{ $inquiry->email }}
                        </div>
                    </div>
                    @if($inquiry->phone)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                        <div class="text-gray-900 flex items-center">
                            <i class="fas fa-phone text-yellow-500 mr-2"></i>
                            {{ $inquiry->phone }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-green-50 border-b border-green-200 px-6 py-3">
                    <h3 class="text-sm font-bold text-green-800 flex items-center">
                        <i class="fas fa-clock mr-3 text-green-600"></i>
                        Timeline
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mt-2 mr-3"></div>
                            <div>
                                <div class="font-semibold text-gray-900">Inquiry Submitted</div>
                                <div class="text-sm text-gray-600">{{ $inquiry->created_at->format('M d, Y \a\t g:i A') }}</div>
                            </div>
                        </div>
                        @if($inquiry->updated_at != $inquiry->created_at)
                        <div class="flex items-start">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mt-2 mr-3"></div>
                        <div>
                                <div class="font-semibold text-gray-900">Last Updated</div>
                                <div class="text-sm text-gray-600">{{ $inquiry->updated_at->format('M d, Y \a\t g:i A') }}</div>
                            </div>
                        </div>
                        @endif
                        @if($inquiry->admin_response)
                        <div class="flex items-start">
                            <div class="w-3 h-3 bg-green-500 rounded-full mt-2 mr-3"></div>
                        <div>
                                <div class="font-semibold text-gray-900">Response Received</div>
                                <div class="text-sm text-gray-600">Admin has responded</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                    </div>

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-purple-50 border-b border-purple-200 px-6 py-3">
                    <h3 class="text-sm font-bold text-purple-800 flex items-center">
                        <i class="fas fa-bolt mr-3 text-purple-600"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('customer.inquiries.create') }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200 font-semibold">
                        <i class="fas fa-plus mr-2"></i>
                        New Inquiry
                    </a>
                    <a href="{{ route('customer.inquiries.index') }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200 font-semibold">
                        <i class="fas fa-list mr-2"></i>
                        All Inquiries
                    </a>
                </div>
            </div>
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