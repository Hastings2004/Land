<x-dashboard-layout>
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-6xl mx-auto">
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
                                <div class="p-2 bg-yellow-500 rounded-lg shadow-md">
                                    <i class="fas fa-reply text-white"></i>
                                </div>
                                Respond to Inquiry
                            </h1>
                            <p class="text-gray-500 mt-1">Update status and send a response to the customer</p>
                        </div>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Customer Information (Read-only) -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-yellow-100 rounded-lg shadow-md">
                                <i class="fas fa-user text-yellow-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 ml-3">Customer Information</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-user text-yellow-500"></i> Name
                                </label>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-200 group-hover:border-yellow-300 transition-all duration-200">
                                    <p class="text-gray-900 font-medium">{{ $inquiry->name }}</p>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-envelope text-yellow-500"></i> Email
                                </label>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-200 group-hover:border-yellow-300 transition-all duration-200">
                                    <p class="text-gray-900">{{ $inquiry->email }}</p>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-phone text-yellow-500"></i> Phone
                                </label>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-200 group-hover:border-yellow-300 transition-all duration-200">
                                    <p class="text-gray-900">{{ $inquiry->phone ?: 'Not provided' }}</p>
                                </div>
                            </div>
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-calendar text-yellow-500"></i> Submitted
                                </label>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-200 group-hover:border-yellow-300 transition-all duration-200">
                                    <p class="text-gray-900">{{ $inquiry->created_at->format('M d, Y \a\t H:i') }}</p>
                                </div>
                            </div>
                            @if($inquiry->plot_id)
                            <div class="group">
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-home text-yellow-500"></i> Related Plot
                                </label>
                                <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-200 group-hover:border-yellow-300 transition-all duration-200">
                                    <p class="text-gray-900">{{ $inquiry->plot->title ?? 'Plot not found' }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- Customer Message -->
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-yellow-100 rounded-lg shadow-md">
                                <i class="fas fa-comment text-yellow-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 ml-3">Customer Message</h3>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 hover:border-yellow-300 transition-all duration-200">
                            <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $inquiry->message }}</p>
                        </div>
                    </div>
                </div>
                <!-- Response Form -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-yellow-100 rounded-lg shadow-md">
                                <i class="fas fa-reply text-yellow-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 ml-3">Admin Response</h3>
                        </div>
                        <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST" id="responseForm">
                            @csrf
                            @method('PUT')
                            <!-- Status Selection -->
                            <div class="mb-6">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-3 flex items-center gap-2">
                                    <i class="fas fa-tag text-yellow-500"></i> Update Status
                                </label>
                                <select name="status" id="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-white hover:border-yellow-300">
                                    <option value="new" {{ old('status', $inquiry->status) == 'new' ? 'selected' : '' }}>🆕 New</option>
                                    <option value="viewed" {{ old('status', $inquiry->status) == 'viewed' ? 'selected' : '' }}>👁️ Viewed</option>
                                    <option value="responded" {{ old('status', $inquiry->status) == 'responded' ? 'selected' : '' }}>💬 Responded</option>
                                    <option value="closed" {{ old('status', $inquiry->status) == 'closed' ? 'selected' : '' }}>✅ Closed</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <!-- Admin Response -->
                            <div class="mb-6">
                                <label for="admin_response" class="block text-sm font-medium text-gray-700 mb-3 flex items-center gap-2">
                                    <i class="fas fa-pen text-yellow-500"></i> Your Response
                                </label>
                                <textarea name="admin_response" id="admin_response" rows="10"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 resize-none bg-white hover:border-yellow-300"
                                      placeholder="Type your professional response to the customer here...">{{ old('admin_response', $inquiry->admin_response) }}</textarea>
                                <!-- Character Counter -->
                                <div class="flex justify-between items-center mt-2">
                                    <div class="text-sm text-gray-500">
                                        <span id="charCount">0</span> characters
                                    </div>
                                    <div class="text-sm text-yellow-600 font-medium">
                                        <i class="fas fa-lightbulb mr-1"></i>
                                        Professional response recommended
                                    </div>
                                </div>
                                @error('admin_response')
                                    <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                                <a href="{{ route('admin.inquiries.show', $inquiry) }}" 
                                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm">
                                    <i class="fas fa-eye mr-2"></i> View Details
                                </a>
                                <button type="submit" id="submitBtn" class="inline-flex items-center justify-center px-8 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-500 transition-all duration-200 shadow-md transform hover:scale-105">
                                    <i class="fas fa-paper-plane mr-2"></i> Send Response
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Quick Response Templates -->
                    <div class="bg-yellow-50 rounded-lg p-6 border border-yellow-200">
                        <div class="flex items-center mb-4">
                            <div class="p-2 bg-yellow-100 rounded-lg">
                                <i class="fas fa-magic text-yellow-600"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-yellow-900 ml-3">Quick Response Templates</h4>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <button onclick="insertTemplate('Thank you for your inquiry. We have received your message and will get back to you shortly with detailed information.')" 
                                    class="text-left p-3 bg-white rounded-lg border border-yellow-200 hover:border-yellow-400 hover:shadow-md transition-all duration-200">
                                <div class="text-sm font-medium text-yellow-800 mb-1">Acknowledgment</div>
                                <div class="text-xs text-gray-600">Thank you for your inquiry...</div>
                            </button>
                            <button onclick="insertTemplate('We appreciate your interest in our properties. Please provide us with your preferred contact time and we will arrange a viewing at your convenience.')" 
                                    class="text-left p-3 bg-white rounded-lg border border-yellow-200 hover:border-yellow-400 hover:shadow-md transition-all duration-200">
                                <div class="text-sm font-medium text-yellow-800 mb-1">Viewing Request</div>
                                <div class="text-xs text-gray-600">We appreciate your interest...</div>
                            </button>
                            <button onclick="insertTemplate('Thank you for your inquiry. The property you are interested in is currently available. Please let us know your preferred time for a detailed discussion.')" 
                                    class="text-left p-3 bg-white rounded-lg border border-yellow-200 hover:border-yellow-400 hover:shadow-md transition-all duration-200">
                                <div class="text-sm font-medium text-yellow-800 mb-1">Availability</div>
                                <div class="text-xs text-gray-600">Thank you for your inquiry...</div>
                            </button>
                            <button onclick="insertTemplate('We have received your inquiry and are currently reviewing the details. We will provide you with a comprehensive response within 24 hours.')" 
                                    class="text-left p-3 bg-white rounded-lg border border-yellow-200 hover:border-yellow-400 hover:shadow-md transition-all duration-200">
                                <div class="text-sm font-medium text-yellow-800 mb-1">Under Review</div>
                                <div class="text-xs text-gray-600">We have received your inquiry...</div>
                            </button>
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

        .template-button:hover {
            transform: translateY(-2px);
        }

        .form-group:hover {
            transform: translateY(-1px);
        }
    </style>

    <script>
        // Character counter
        const textarea = document.getElementById('admin_response');
        const charCount = document.getElementById('charCount');
        const submitBtn = document.getElementById('submitBtn');

        textarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            // Change color based on length
            if (count < 10) {
                charCount.className = 'text-red-500';
            } else if (count < 50) {
                charCount.className = 'text-yellow-500';
            } else {
                charCount.className = 'text-green-500';
            }
        });

        // Quick response templates
        function insertTemplate(text) {
            textarea.value = text;
            textarea.focus();
            textarea.setSelectionRange(text.length, text.length);
            
            // Trigger input event to update character count
            const event = new Event('input', { bubbles: true });
            textarea.dispatchEvent(event);
            
            // Add visual feedback
            textarea.style.borderColor = '#f59e0b';
            setTimeout(() => {
                textarea.style.borderColor = '';
            }, 1000);
        }

        // Form submission with loading state
        document.getElementById('responseForm').addEventListener('submit', function(e) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75');
        });

        // Auto-resize textarea
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 300) + 'px';
        });

        // Initialize character count
        document.addEventListener('DOMContentLoaded', function() {
            const count = textarea.value.length;
            charCount.textContent = count;
            if (count < 10) {
                charCount.className = 'text-red-500';
            } else if (count < 50) {
                charCount.className = 'text-yellow-500';
            } else {
                charCount.className = 'text-green-500';
            }
        });
    </script>
</x-dashboard-layout> 