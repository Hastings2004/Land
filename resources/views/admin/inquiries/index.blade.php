<x-dashboard-layout>
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back
                    </a>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center gap-3">
                            <div class="p-2 bg-yellow-500 rounded-lg">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            Manage Inquiries
                        </h1>
                        <p class="text-gray-500 mt-1">View and respond to customer inquiries</p>
                    </div>
                </div>
                <!-- Search Bar -->
                <div class="relative max-w-md w-full">
                    <form action="{{ route('admin.inquiries.index') }}" method="GET" class="flex">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search inquiries..." 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-500"></i>
                        </div>
                        <button type="submit" class="px-6 py-3 bg-yellow-500 text-white rounded-r-lg hover:bg-yellow-600 transition-all duration-200 shadow-md">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Success Message -->
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
            <style>
                @keyframes bounceIn {
                    0% { opacity: 0; transform: scale(0.7) translateY(40px); }
                    60% { opacity: 1; transform: scale(1.05) translateY(-8px); }
                    80% { transform: scale(0.98) translateY(2px); }
                    100% { opacity: 1; transform: scale(1) translateY(0); }
                }
                .animate-bounce-in { animation: bounceIn 0.7s cubic-bezier(0.4, 0, 0.2, 1); }
            </style>
            <script>
                function closeSuccessModal() {
                    document.getElementById('successModal').style.display = 'none';
                }
                setTimeout(closeSuccessModal, 3000);
            </script>
        @endif

        <!-- Show Deleted Toggle -->
        @php
            $showDeleted = request('show_deleted') == '1';
            $softDeletedInquiries = \App\Models\Inquiries::where('admin_deleted', true)
                ->where('customer_deleted', false)
                ->latest()->get();
            $permanentlyDeletedInquiries = \App\Models\Inquiries::where('admin_deleted', true)
                ->where('customer_deleted', true)
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

        <!-- Deleted Inquiries Section -->
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
                                    <form action="{{ route('admin.inquiries.restore', $inquiry) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200 font-semibold">
                                            <i class="fas fa-undo mr-2"></i>Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.inquiries.permanent-delete', $inquiry) }}" method="POST" class="inline-block" onsubmit="return confirm('WARNING: This will permanently delete this inquiry and it cannot be recovered. Are you sure?');">
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-exclamation-circle text-yellow-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">New Inquiries</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $inquiries->where('status', 'new')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-eye text-yellow-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Viewed</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $inquiries->where('status', 'viewed')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-reply text-yellow-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Responded</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $inquiries->where('status', 'responded')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-check-circle text-yellow-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $inquiries->total() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inquiries Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-list text-yellow-500"></i>
                        Customer Inquiries
                    </h2>
                    <div class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full border">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Total: {{ $inquiries->total() }} inquiries
                    </div>
                </div>
            </div>

            @if($inquiries->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-user mr-1"></i> Customer
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-comment mr-1"></i> Message
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-tag mr-1"></i> Status
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-calendar mr-1"></i> Date
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <i class="fas fa-cogs mr-1"></i> Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($inquiries as $inquiry)
                                <tr class="hover:bg-yellow-50 transition-all duration-200">
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-yellow-500 flex items-center justify-center text-white font-semibold shadow-md">
                                                    {{ strtoupper(substr($inquiry->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $inquiry->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $inquiry->email }}</div>
                                                @if($inquiry->phone)
                                                    <div class="text-xs text-gray-400">{{ $inquiry->phone }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs">
                                            {{ Str::limit($inquiry->message, 80) }}
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium shadow-sm bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            {{ ucfirst($inquiry->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <i class="fas fa-clock mr-1 text-gray-400"></i>
                                            {{ $inquiry->created_at->format('M d, Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <a href="{{ route('admin.inquiries.show', $inquiry) }}" 
                                               class="inline-flex items-center px-3 py-2 border border-yellow-300 text-yellow-700 rounded-lg hover:bg-yellow-50 transition-all duration-200 text-xs">
                                                <i class="fas fa-eye mr-1"></i> View
                                            </a>
                                            <a href="{{ route('admin.inquiries.edit', $inquiry) }}" 
                                               class="inline-flex items-center px-3 py-2 border border-yellow-300 text-yellow-700 rounded-lg hover:bg-yellow-50 transition-all duration-200 text-xs">
                                                <i class="fas fa-reply mr-1"></i> Respond
                                            </a>
                                            <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 text-xs font-semibold">
                                                    <i class="fas fa-trash mr-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-inbox text-3xl mb-2"></i>
                    <p>No inquiries found.</p>
                </div>
            @endif
        </div>
        <!-- Pagination -->
        <div class="mt-6">
            {{ $inquiries->links() }}
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