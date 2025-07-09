<x-dashboard-layout>
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.inquiries.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back
                        </a>
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center gap-3">
                                <div class="p-2 bg-yellow-500 rounded-lg">
                                    <i class="fas fa-eye text-white"></i>
                                </div>
                                Inquiry Details
                            </h1>
                            <p class="text-gray-500 mt-1">View inquiry information and customer details</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('admin.inquiries.edit', $inquiry) }}" 
                           class="inline-flex items-center px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all duration-200 shadow-md">
                            <i class="fas fa-reply mr-2"></i> Respond to Inquiry
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg relative mb-6 animate-fade-in" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-600"></i>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Customer Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-yellow-100 rounded-lg">
                                <i class="fas fa-user text-yellow-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 ml-3">Customer Information</h3>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-user text-yellow-500"></i> Name
                                </label>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-200">
                                    <p class="text-gray-900 font-medium">{{ $inquiry->name }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-envelope text-yellow-500"></i> Email
                                </label>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-200">
                                    <p class="text-gray-900">{{ $inquiry->email }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-phone text-yellow-500"></i> Phone
                                </label>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-200">
                                    <p class="text-gray-900">{{ $inquiry->phone ?: 'Not provided' }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-tag text-yellow-500"></i> Status
                                </label>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-200">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium shadow-sm bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        {{ ucfirst($inquiry->status) }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-calendar text-yellow-500"></i> Submitted
                                </label>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-200">
                                    <p class="text-gray-900">{{ $inquiry->created_at->format('M d, Y \a\t H:i') }}</p>
                                </div>
                            </div>
                            @if($inquiry->plot_id)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-home text-yellow-500"></i> Related Plot
                                </label>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-200">
                                    <p class="text-gray-900">{{ $inquiry->plot->title ?? 'Plot not found' }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Message and Response -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Customer Message -->
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-yellow-100 rounded-lg">
                                <i class="fas fa-comment text-yellow-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 ml-3">Customer Message</h3>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $inquiry->message }}</p>
                        </div>
                    </div>
                    <!-- Admin Response -->
                    @if($inquiry->admin_response)
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-yellow-100 rounded-lg">
                                <i class="fas fa-reply text-yellow-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 ml-3">Admin Response</h3>
                        </div>
                        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
                            <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $inquiry->admin_response }}</p>
                        </div>
                    </div>
                    @endif
                    <!-- Action Buttons -->
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                        <div class="flex flex-col sm:flex-row justify-end gap-3">
                            <a href="{{ route('admin.inquiries.index') }}" 
                               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                <i class="fas fa-list mr-2"></i> Back to List
                            </a>
                            <a href="{{ route('admin.inquiries.edit', $inquiry) }}" 
                               class="inline-flex items-center justify-center px-8 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-500 transition-all duration-200 shadow-md">
                                <i class="fas fa-reply mr-2"></i> Respond to Inquiry
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-dashboard-layout> 