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
            <i class="fas fa-envelope text-white text-xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">My Inquiries</h1>
        <p class="text-gray-600">Track your land investment questions</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-3xl p-8 max-w-md mx-4 transform scale-100 opacity-100 animate-bounce-in" id="modalContent">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-600 rounded-full mb-6 shadow-lg">
                        <i class="fas fa-check text-yellow-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-yellow-600 mb-3">{{ session('success') }}</h3>
                    <div class="flex justify-center mt-6">
                        <button onclick="closeSuccessModal()"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-yellow-500 text-white rounded-xl font-semibold hover:bg-yellow-600 transition-all duration-300">
                            <i class="fas fa-times"></i>
                            Close
                        </button>
                    </div>
                </div>
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

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-blue-600">{{ $inquiries->total() }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Total Inquiries</div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-envelope text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $inquiries->where('status', 'new')->count() }}</div>
                    <div class="text-gray-600 text-sm font-semibold">New</div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ $inquiries->where('status', 'responded')->count() }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Responded</div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-reply text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-gray-600">{{ $inquiries->where('status', 'closed')->count() }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Closed</div>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-gray-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
        <!-- Search Bar -->
            <div class="w-full lg:w-96">
                <form action="{{ route('customer.inquiries.index') }}" method="GET" class="relative">
                    <input type="text" name="search"
                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 bg-gray-50 text-gray-900 placeholder-gray-500 transition-all duration-200"
                        placeholder="Search inquiries..."
                        value="{{ request('search') }}">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </form>
        </div>

            <!-- Status Filter -->
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700">Filter:</span>
                <select name="status" onchange="this.form.submit()" class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 bg-white text-gray-700">
                    <option value="">All Status</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                    <option value="viewed" {{ request('status') == 'viewed' ? 'selected' : '' }}>Viewed</option>
                    <option value="responded" {{ request('status') == 'responded' ? 'selected' : '' }}>Responded</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <!-- New Inquiry Button -->
            <a href="{{ route('customer.inquiries.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl font-semibold shadow-lg hover:from-yellow-600 hover:to-yellow-700 focus:outline-none focus:ring-4 focus:ring-yellow-200 transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus"></i>
                New Inquiry
            </a>
        </div>
    </div>

    <!-- Inquiries Content -->
    @php
        $showDeleted = request('show_deleted') == '1';
        $softDeletedInquiries = \App\Models\Inquiries::where('email', auth()->user()->email)
            ->where('customer_deleted', true)
            ->where('admin_deleted', false)
            ->latest()->get();
        $permanentlyDeletedInquiries = \App\Models\Inquiries::where('email', auth()->user()->email)
            ->where('customer_deleted', true)
            ->where('admin_deleted', true)
            ->latest()->get();
    @endphp
    <div class="mb-6 flex justify-end">
        <form method="GET" action="">
            <input type="hidden" name="show_deleted" value="{{ $showDeleted ? '0' : '1' }}">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200 font-semibold">
                <i class="fas fa-trash-restore mr-2"></i>
                {{ $showDeleted ? 'Hide Deleted' : 'Show Deleted' }} Inquiries ({{ $softDeletedInquiries->count() + $permanentlyDeletedInquiries->count() }})
            </button>
        </form>
    </div>
    @if($showDeleted)
        <!-- Soft Deleted Inquiries (can be restored) -->
        @if($softDeletedInquiries->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <h2 class="text-xl font-bold text-yellow-700 mb-4 flex items-center"><i class="fas fa-trash-restore mr-2"></i>Inquiries in Trash (Can Be Restored)</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($softDeletedInquiries as $inquiry)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 flex flex-col gap-4">
                            <div>
                                <div class="font-bold text-lg text-yellow-800 mb-1">{{ $inquiry->name }}</div>
                                <div class="text-gray-700 text-sm mb-2">{{ Str::limit($inquiry->message, 100) }}</div>
                                <div class="text-xs text-gray-500 mb-2">{{ $inquiry->created_at->format('M d, Y H:i') }}</div>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('customer.inquiries.restore', $inquiry) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200 font-semibold">
                                        <i class="fas fa-undo mr-2"></i>Restore
                                    </button>
                                </form>
                                <form action="{{ route('customer.inquiries.permanent-delete', $inquiry) }}" method="POST" class="inline-block" onsubmit="return confirm('WARNING: This will permanently delete this inquiry and it cannot be recovered. Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 font-semibold">
                                        <i class="fas fa-trash-alt mr-2"></i>Permanently Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Permanently Deleted Inquiries (cannot be restored) -->
        @if($permanentlyDeletedInquiries->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <h2 class="text-xl font-bold text-red-700 mb-4 flex items-center"><i class="fas fa-trash-alt mr-2"></i>Permanently Removed Inquiries</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($permanentlyDeletedInquiries as $inquiry)
                        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                            <div>
                                <div class="font-bold text-lg text-red-800 mb-1">{{ $inquiry->name }}</div>
                                <div class="text-gray-700 text-sm mb-2">{{ Str::limit($inquiry->message, 100) }}</div>
                                <div class="text-xs text-gray-500 mb-2">{{ $inquiry->created_at->format('M d, Y H:i') }}</div>
                                <div class="text-xs text-red-600 font-semibold">
                                    Permanently removed - cannot be restored (Deleted {{ $inquiry->updated_at->diffForHumans() }})
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($softDeletedInquiries->isEmpty() && $permanentlyDeletedInquiries->isEmpty())
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <h2 class="text-xl font-bold text-yellow-700 mb-4 flex items-center"><i class="fas fa-trash-restore mr-2"></i>Deleted Inquiries</h2>
                <p class="text-gray-500">No deleted inquiries.</p>
            </div>
        @endif
    @endif
            @if($inquiries->isEmpty())
        <!-- Beautiful Empty State -->
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="max-w-md mx-auto">
                <!-- Animated Icon -->
                <div class="relative mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                        <i class="fas fa-envelope text-yellow-500 text-4xl"></i>
                    </div>
                    <!-- Floating Elements -->
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-300 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                    <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-yellow-400 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
                    <div class="absolute top-1/2 -right-4 w-4 h-4 bg-yellow-500 rounded-full animate-bounce" style="animation-delay: 0.6s;"></div>
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-4">Start Your First Inquiry!</h2>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Have questions about land plots? Send us an inquiry and get expert advice from our team. 
                    We're here to help you make informed investment decisions.
                </p>

                <!-- Feature Cards -->
                <!-- Removed for simplicity -->

                <!-- Call to Action -->
                <div class="space-y-4">
                    <a href="{{ route('customer.inquiries.create') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl hover:from-yellow-600 hover:to-yellow-700 font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-plus mr-3"></i>
                        Send Your First Inquiry
                    </a>
                </div>
            </div>
                </div>
            @else
        <!-- Inquiries Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @foreach($inquiries as $inquiry)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                    <!-- Header -->
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-yellow-600 transition-colors duration-300">
                                {{ $inquiry->name }}
                            </h3>
                            <div class="flex items-center gap-2">
                                            @switch($inquiry->status)
                                    @case('new')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full flex items-center">
                                            <i class="fas fa-clock mr-1"></i>New
                                        </span>
                                        @break
                                    @case('viewed')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full flex items-center">
                                            <i class="fas fa-eye mr-1"></i>Viewed
                                        </span>
                                        @break
                                    @case('responded')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full flex items-center">
                                            <i class="fas fa-reply mr-1"></i>Responded
                                        </span>
                                        @break
                                    @case('closed')
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full flex items-center">
                                            <i class="fas fa-check mr-1"></i>Closed
                                        </span>
                                        @break
                                    @default
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                                            {{ ucfirst($inquiry->status) }}
                                        </span>
                                @endswitch
                            </div>
                        </div>
                        
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">
                            {{ Str::limit($inquiry->message, 120) }}
                        </p>

                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2 text-yellow-500"></i>
                                        {{ $inquiry->created_at->format('M d, Y') }}
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2 text-yellow-500"></i>
                                {{ $inquiry->created_at->format('g:i A') }}
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-6 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-envelope mr-2 text-yellow-500"></i>
                                {{ Str::limit($inquiry->email, 25) }}
                            </div>
                            <div class="flex space-x-2">
                                        <a href="{{ route('customer.inquiries.show', $inquiry) }}"
                                   class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200 text-sm font-semibold">
                                    <i class="fas fa-eye mr-2"></i>View
                                </a>
                                <form action="{{ route('customer.inquiries.destroy', $inquiry) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 text-sm font-semibold">
                                        <i class="fas fa-trash mr-2"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                            @endforeach
                </div>
                
                <!-- Pagination -->
        @if($inquiries->hasPages())
            <div class="mt-8 flex justify-center">
                    {{ $inquiries->appends(request()->query())->links() }}
                </div>
            @endif
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

            // Add hover effects to inquiry cards
            const cards = document.querySelectorAll('.group');
            cards.forEach(function(card) {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });

        // Status filter form submission
        document.querySelector('select[name="status"]').addEventListener('change', function() {
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = '{{ route("customer.inquiries.index") }}';
            
            // Add search parameter if exists
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput && searchInput.value) {
                const searchParam = document.createElement('input');
                searchParam.type = 'hidden';
                searchParam.name = 'search';
                searchParam.value = searchInput.value;
                form.appendChild(searchParam);
            }
            
            // Add status parameter
            const statusParam = document.createElement('input');
            statusParam.type = 'hidden';
            statusParam.name = 'status';
            statusParam.value = this.value;
            form.appendChild(statusParam);
            
            document.body.appendChild(form);
            form.submit();
        });

        function closeSuccessModal() {
            document.getElementById('successModal').style.display = 'none';
        }
        setTimeout(closeSuccessModal, 3000);
    </script>
</x-dashboard-layout> 