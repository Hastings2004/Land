<x-dashboard-layout>
    <div class="p-6">
        <!-- Elegant Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('customer.inquiries.index') }}" 
                   class="inline-flex items-center gap-2 text-yellow-600 hover:text-yellow-700 font-medium transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    Back to Inquiries
                </a>
            </div>
            
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-600 rounded-full shadow-2xl mb-4 transform hover:scale-105 transition-transform duration-300">
                    <i class="fas fa-envelope text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Send Us an Inquiry</h1>
                <p class="text-gray-600 text-lg max-w-md mx-auto">We'd love to hear from you and help you find your perfect plot in Malawi</p>
            </div>
        </div>

        <div class="max-w-lg mx-auto">
            <!-- Stylish Form Container -->
            <div class="relative">
                <!-- Background decoration -->
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-gradient-to-br from-yellow-200 to-yellow-300 rounded-full opacity-20 blur-xl"></div>
                <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-gradient-to-br from-yellow-300 to-yellow-400 rounded-full opacity-20 blur-xl"></div>
                
                <div class="relative bg-white rounded-2xl shadow-xl border border-yellow-100 overflow-hidden">
                    <form action="{{ route('customer.inquiries.store') }}" method="POST" id="inquiryForm">
                        @csrf
                        
                        <div class="p-6 space-y-6">
                            <!-- Subject Field with curved design -->
                            <div class="space-y-3">
                                <label for="name" class="block text-sm font-bold text-gray-700 uppercase tracking-wider ml-1">
                                    Subject <span class="text-yellow-500">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-xl transform rotate-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           class="relative w-full px-4 py-3 border-2 border-yellow-200 rounded-xl bg-white transition-all duration-300 text-gray-800 placeholder-gray-500 shadow-sm"
                                           placeholder="What would you like to know?"
                                           required
                                           maxlength="100">
                                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-yellow-500 text-sm font-medium">
                                        <span id="charCount">0</span>/100
                                    </div>
                                </div>
                                @error('name')
                                    <p class="text-sm text-red-600 flex items-center gap-2 ml-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Contact Fields with curved layout -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-3">
                                    <label for="email" class="block text-sm font-bold text-gray-700 uppercase tracking-wider ml-1">
                                        Email <span class="text-yellow-500">*</span>
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-xl transform -rotate-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <input type="email" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', auth()->user()->email) }}"
                                               class="relative w-full px-4 py-3 border-2 border-yellow-200 rounded-xl bg-white transition-all duration-300 text-gray-800 placeholder-gray-500 shadow-sm"
                                               placeholder="your@email.com"
                                               required>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-green-500">
                                            <i class="fas fa-check-circle" id="emailValid" style="display: none;"></i>
                                        </div>
                                    </div>
                                    @error('email')
                                        <p class="text-sm text-red-600 flex items-center gap-2 ml-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-3">
                                    <label for="phone" class="block text-sm font-bold text-gray-700 uppercase tracking-wider ml-1">
                                        Phone <span class="text-gray-400 font-normal">(Optional)</span>
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-xl transform rotate-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <input type="tel" 
                                               id="phone" 
                                               name="phone" 
                                               value="{{ old('phone') }}"
                                               class="relative w-full px-4 py-3 border-2 border-yellow-200 rounded-xl bg-white transition-all duration-300 text-gray-800 placeholder-gray-500 shadow-sm"
                                               placeholder="+265 123 456 789">
                                    </div>
                                    @error('phone')
                                        <p class="text-sm text-red-600 flex items-center gap-2 ml-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Message Field with curved design -->
                            <div class="space-y-3">
                                <label for="message" class="block text-sm font-bold text-gray-700 uppercase tracking-wider ml-1">
                                    Message <span class="text-yellow-500">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-xl transform -rotate-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <textarea id="message" 
                                              name="message" 
                                              rows="5"
                                              class="relative w-full px-4 py-3 border-2 border-yellow-200 rounded-xl bg-white transition-all duration-300 resize-none text-gray-800 placeholder-gray-500 shadow-sm"
                                              placeholder="Tell us more about your inquiry, requirements, or any specific questions you have..."
                                              required
                                              maxlength="1000">{{ old('message') }}</textarea>
                                    <div class="absolute bottom-3 right-3 text-yellow-500 text-sm font-medium">
                                        <span id="messageCharCount">0</span>/1000
                                    </div>
                                </div>
                                
                                @error('message')
                                    <p class="text-sm text-red-600 flex items-center gap-2 ml-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Stylish Submit Section -->
                            <div class="pt-6">
                                <div class="relative">
                                    <!-- Decorative line -->
                                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-transparent via-yellow-300 to-transparent"></div>
                                    
                                    <div class="flex flex-col sm:flex-row gap-3 mt-6">
                                        <button type="submit"
                                                id="submitBtn"
                                                class="flex-1 group relative overflow-hidden inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl font-bold text-base hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-yellow-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            <i class="fas fa-paper-plane relative z-10"></i>
                                            <span class="relative z-10">Send Inquiry</span>
                                            <div class="hidden relative z-10" id="loadingSpinner">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </div>
                                        </button>
                                        
                                        <a href="{{ route('customer.inquiries.index') }}"
                                           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300">
                                            <i class="fas fa-times"></i>
                                            Cancel
                                        </a>
                                    </div>
                                    

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-3xl p-8 max-w-md mx-4 transform scale-95 opacity-0 transition-all duration-300 animate-bounce-in" id="modalContent">
            <div class="text-center">
                <!-- Success Icon -->
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-600 rounded-full mb-6 shadow-lg">
                    <i class="fas fa-check text-yellow-600 text-3xl"></i>
                </div>
                <!-- Success Message -->
                <h3 class="text-2xl font-bold text-yellow-600 mb-3">Inquiry Sent Successfully!</h3>
                <p class="text-gray-600 mb-6">Thank you for reaching out to us. We'll get back to you within 24 hours.</p>
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('customer.inquiries.index') }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-yellow-500 text-white rounded-xl font-semibold hover:bg-yellow-600 transition-all duration-300">
                        <i class="fas fa-list"></i>
                        View My Inquiries
                    </a>
                    <button onclick="closeSuccessModal()"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300">
                        <i class="fas fa-times"></i>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-3xl p-8 max-w-md mx-4 transform scale-95 opacity-0 transition-all duration-300 animate-bounce-in" id="errorModalContent">
            <div class="text-center">
                <!-- Error Icon -->
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-600 rounded-full mb-6 shadow-lg">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-3xl"></i>
                </div>
                <!-- Error Message -->
                <h3 class="text-2xl font-bold text-yellow-600 mb-3">Submission Error</h3>
                <div id="errorMessages" class="text-gray-700 mb-6 text-left"></div>
                <!-- Action Button -->
                <div class="flex justify-center">
                    <button onclick="closeErrorModal()"
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
        // Character counter for subject
        const nameInput = document.getElementById('name');
        const charCount = document.getElementById('charCount');
        
        nameInput.addEventListener('input', function() {
            charCount.textContent = this.value.length;
            if (this.value.length > 80) {
                charCount.classList.add('text-red-500');
            } else {
                charCount.classList.remove('text-red-500');
            }
        });

        // Character counter for message
        const messageInput = document.getElementById('message');
        const messageCharCount = document.getElementById('messageCharCount');
        
        messageInput.addEventListener('input', function() {
            messageCharCount.textContent = this.value.length;
            if (this.value.length > 800) {
                messageCharCount.classList.add('text-red-500');
            } else {
                messageCharCount.classList.remove('text-red-500');
            }
        });

        // Email validation with enhanced feedback
        const emailInput = document.getElementById('email');
        const emailValid = document.getElementById('emailValid');
        
        emailInput.addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (emailRegex.test(email)) {
                emailValid.style.display = 'block';
                this.classList.add('border-green-500');
                this.classList.remove('border-red-500');
            } else {
                emailValid.style.display = 'none';
                this.classList.remove('border-green-500');
                if (email.length > 0) {
                    this.classList.add('border-red-500');
                }
            }
        });

        // Success Modal Functions
        function showSuccessModal() {
            const modal = document.getElementById('successModal');
            const modalContent = document.getElementById('modalContent');
            
            modal.classList.remove('hidden');
            
            // Trigger animation after a small delay
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            const modalContent = document.getElementById('modalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Close modal when clicking outside
        document.getElementById('successModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSuccessModal();
            }
        });

        // Error Modal Functions
        function showErrorModal(messages) {
            const modal = document.getElementById('errorModal');
            const modalContent = document.getElementById('errorModalContent');
            const errorMessages = document.getElementById('errorMessages');
            // Accept string or array
            if (Array.isArray(messages)) {
                errorMessages.innerHTML = '<ul class="list-disc list-inside space-y-1">' + messages.map(msg => `<li>${msg}</li>`).join('') + '</ul>';
            } else {
                errorMessages.textContent = messages;
            }
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        function closeErrorModal() {
            const modal = document.getElementById('errorModal');
            const modalContent = document.getElementById('errorModalContent');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
        document.getElementById('errorModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeErrorModal();
            }
        });

        // Enhanced form submission with loading state and success modal
        const form = document.getElementById('inquiryForm');
        const submitBtn = document.getElementById('submitBtn');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const submitText = submitBtn.querySelector('span');
        const submitIcon = submitBtn.querySelector('i');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            submitBtn.disabled = true;
            submitText.textContent = 'Sending...';
            submitIcon.style.display = 'none';
            loadingSpinner.classList.remove('hidden');
            submitBtn.classList.add('opacity-75');
            // Submit the form using fetch
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                // Reset button state
                submitBtn.disabled = false;
                submitText.textContent = 'Send Inquiry';
                submitIcon.style.display = 'block';
                loadingSpinner.classList.add('hidden');
                submitBtn.classList.remove('opacity-75');
                let data;
                try {
                    data = await response.json();
                } catch (e) {
                    showErrorModal('Unexpected server response. Please try again.');
                    return;
                }
                if (response.ok && data.success) {
                    // Show success modal
                    showSuccessModal();
                    
                    // Reset form
                    form.reset();
                    charCount.textContent = '0';
                    messageCharCount.textContent = '0';
                    
                    // Auto-redirect to inquiries list after 3 seconds
                    setTimeout(() => {
                        window.location.href = '{{ route("customer.inquiries.index") }}';
                    }, 3000);
                } else if (response.status === 422 && data.errors) {
                    // Validation errors
                    const messages = Object.values(data.errors).flat();
                    showErrorModal(messages);
                } else {
                    // Other errors
                    showErrorModal(data.message || 'Error sending inquiry. Please try again.');
                }
            })
            .catch(() => {
                submitBtn.disabled = false;
                submitText.textContent = 'Send Inquiry';
                submitIcon.style.display = 'block';
                loadingSpinner.classList.add('hidden');
                submitBtn.classList.remove('opacity-75');
                showErrorModal('Error sending inquiry. Please try again.');
            });
        });

        // Initialize counters
        charCount.textContent = nameInput.value.length;
        messageCharCount.textContent = messageInput.value.length;
    </script>
</x-dashboard-layout> 