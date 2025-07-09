<x-dashboard-layout>
    <div class="max-w-6xl mx-auto py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-yellow-300 text-yellow-600 rounded-lg shadow-sm hover:bg-yellow-50 hover:border-yellow-400 focus:ring-2 focus:ring-yellow-400 transition-all duration-200 font-semibold text-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>

        <!-- Profile Header -->
        <div class="bg-white rounded-2xl p-8 mb-8 shadow-xl border border-gray-100">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center border-4 border-yellow-200 shadow-lg">
                        <span class="text-3xl font-bold text-white">{{ strtoupper(substr(auth()->user()->username, 0, 2)) }}</span>
                    </div>
                </div>
                <div class="flex-1 text-center md:text-left">
                    @if(auth()->user()->isAdmin())
                        <h1 class="text-4xl font-bold text-yellow-600 mb-2">Admin Profile</h1>
                    @else
                        <h1 class="text-4xl font-bold text-yellow-500 mb-2">Welcome, {{ auth()->user()->username }}!</h1>
                    @endif
                    <p class="text-gray-600 text-lg mb-4">{{ auth()->user()->username }}</p>
                    <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                        @if(auth()->user()->isAdmin())
                            <span class="inline-flex items-center px-4 py-2 bg-yellow-100 rounded-full text-yellow-800 text-sm font-semibold border border-yellow-300">
                                <i class="fas fa-user-shield mr-2 text-yellow-500"></i> {{ ucfirst(auth()->user()->role) }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 bg-yellow-100 rounded-full text-yellow-700 text-sm font-semibold animate-pulse">
                                <i class="fas fa-user mr-2 text-yellow-500"></i> Customer
                        </span>
                        @endif
                        <span class="inline-flex items-center px-4 py-2 bg-blue-100 rounded-full text-blue-800 text-sm font-semibold">
                            <i class="fas fa-envelope mr-2"></i> {{ auth()->user()->email }}
                        </span>
                        <span class="inline-flex items-center px-4 py-2 bg-green-100 rounded-full text-green-800 text-sm font-semibold">
                            <i class="fas fa-phone mr-2"></i> {{ auth()->user()->phone_number ?? '+265 888 052 362' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div id="success-message" class="bg-gradient-to-r from-green-400 to-emerald-500 text-white px-6 py-4 rounded-xl shadow-lg mb-8 flex items-center">
                <i class="fas fa-check-circle text-2xl mr-3"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-gradient-to-r from-red-400 to-pink-500 text-white px-6 py-4 rounded-xl shadow-lg mb-8">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
                    <span class="font-semibold">Please fix the following errors:</span>
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Information Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-user-cog text-yellow-500 mr-3"></i> Profile Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                                    <div class="relative">
                                        <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400"></i>
                                        <input type="text" name="username" id="username" value="{{ old('username', auth()->user()->username) }}" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                               placeholder="Enter your username">
                                    </div>
                                    @error('username')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                    <div class="relative">
                                        <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400"></i>
                                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                               placeholder="Enter your email address">
                                    </div>
                                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                </div>
                    </div>

                            <div>
                                <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                <div class="relative">
                                    <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400"></i>
                                    <input type="tel" name="phone_number" id="phone_number" 
                                           value="{{ old('phone_number', auth()->user()->phone_number) }}" 
                                           placeholder="Enter your phone number"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white">
                                </div>
                                @error('phone_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-yellow-500 to-amber-500 text-white rounded-lg hover:from-yellow-600 hover:to-amber-600 font-bold text-sm uppercase shadow-lg transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-yellow-400">
                                    <i class="fas fa-save mr-2"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Cards -->
            <div class="space-y-6">
                <!-- Change Password Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-key text-gray-600 mr-3"></i> Change Password
                        </h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('profile.change_password') }}" method="POST" class="space-y-4">
                    @csrf
                    
                            <div>
                                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400"></i>
                                    <input type="password" name="current_password" id="current_password" 
                                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                           placeholder="Enter current password">
                                </div>
                                @error('current_password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400"></i>
                                    <input type="password" name="password" id="password" 
                                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                           placeholder="Enter new password">
                                </div>
                                @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400"></i>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                           placeholder="Confirm new password">
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-yellow-500 to-amber-500 text-white rounded-lg hover:from-yellow-600 hover:to-amber-600 font-bold text-sm uppercase shadow-lg transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-yellow-400">
                                    <i class="fas fa-key mr-2"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                    </div>

                <!-- Quick Stats Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-chart-line text-yellow-600 mr-3"></i> 
                            @if(auth()->user()->isAdmin())
                                Quick Stats
                            @else
                                My Activity
                            @endif
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @if(auth()->user()->isAdmin())
                            <!-- Admin Stats -->
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-th-list text-yellow-600 mr-3"></i>
                                <span class="text-sm font-semibold text-gray-700">Total Plots</span>
                            </div>
                            <span class="text-lg font-bold text-yellow-600">{{ \App\Models\Plot::count() }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-envelope-open text-green-600 mr-3"></i>
                                <span class="text-sm font-semibold text-gray-700">Inquiries</span>
                            </div>
                            <span class="text-lg font-bold text-green-600">{{ \App\Models\Inquiries::count() }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-users text-purple-600 mr-3"></i>
                                <span class="text-sm font-semibold text-gray-700">Users</span>
                            </div>
                            <span class="text-lg font-bold text-purple-600">{{ \App\Models\User::count() }}</span>
                        </div>
                        @else
                            <!-- Customer Stats -->
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg hover:shadow-md transition-all duration-300 cursor-pointer" onclick="window.location.href='{{ route('customer.saved-plots.index') }}'">
                                <div class="flex items-center">
                                    <i class="fas fa-bookmark text-yellow-600 mr-3"></i>
                                    <span class="text-sm font-semibold text-gray-700">Saved Plots</span>
                                </div>
                                <span class="text-lg font-bold text-yellow-600">{{ auth()->user()->savedPlots()->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-green-100 rounded-lg hover:shadow-md transition-all duration-300 cursor-pointer" onclick="window.location.href='{{ route('customer.reservations.index') }}'">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-check text-green-600 mr-3"></i>
                                    <span class="text-sm font-semibold text-gray-700">My Reservations</span>
                                </div>
                                <span class="text-lg font-bold text-green-600">{{ auth()->user()->reservations()->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg hover:shadow-md transition-all duration-300 cursor-pointer" onclick="window.location.href='{{ route('customer.inquiries.index') }}'">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-blue-600 mr-3"></i>
                                    <span class="text-sm font-semibold text-gray-700">My Inquiries</span>
                                </div>
                                <span class="text-lg font-bold text-blue-600">{{ auth()->user()->inquiries()->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg hover:shadow-md transition-all duration-300 cursor-pointer" onclick="window.location.href='{{ route('customer.plots.index') }}'">
                                <div class="flex items-center">
                                    <i class="fas fa-eye text-purple-600 mr-3"></i>
                                    <span class="text-sm font-semibold text-gray-700">Plots Viewed</span>
                                </div>
                                <span class="text-lg font-bold text-purple-600">{{ \App\Models\Plot::where('views', '>', 0)->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg hover:shadow-md transition-all duration-300 cursor-pointer" onclick="window.location.href='{{ route('customer.dashboard') }}'">
                                <div class="flex items-center">
                                    <i class="fas fa-star text-orange-600 mr-3"></i>
                                    <span class="text-sm font-semibold text-gray-700">Reviews Given</span>
                                </div>
                                <span class="text-lg font-bold text-orange-600">{{ auth()->user()->reviews()->count() }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide success message after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.transition = 'opacity 0.5s ease-out';
                    successMessage.style.opacity = '0';
                    setTimeout(function() {
                        successMessage.style.display = 'none';
                    }, 500);
                }, 3000);
            }

            // Phone number formatting for Malawian format (supports both 0 and +265)
            const phoneInput = document.getElementById('phone_number');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
                    
                    // Handle different formats
                    if (value.length > 0) {
                        // If starts with 0, keep as is (local format)
                        if (value.startsWith('0')) {
                            // Format as 0XXX XXX XXX
                            if (value.length >= 1) {
                                value = value.substring(0, 1) + 
                                        (value.length > 1 ? value.substring(1, 4) : '') + 
                                        (value.length > 4 ? ' ' + value.substring(4, 7) : '') + 
                                        (value.length > 7 ? ' ' + value.substring(7, 10) : '');
                            }
                        }
                        // If starts with 265, format as +265
                        else if (value.startsWith('265')) {
                            value = '+' + value.substring(0, 3) + ' ' + 
                                    (value.length > 3 ? value.substring(3, 6) : '') + 
                                    (value.length > 6 ? ' ' + value.substring(6, 9) : '') + 
                                    (value.length > 9 ? ' ' + value.substring(9, 12) : '');
                        }
                        // If it's a 9-digit number starting with 8, assume it's a local number starting with 0
                        else if (value.length === 9 && value.startsWith('8')) {
                            value = '0' + value.substring(0, 3) + ' ' + 
                                    (value.length > 3 ? value.substring(3, 6) : '') + 
                                    (value.length > 6 ? ' ' + value.substring(6, 9) : '');
                        }
                        // For any other number, assume it's international and add +265
                        else if (value.length >= 9) {
                            value = '+265 ' + value.substring(0, 3) + ' ' + 
                                    (value.length > 3 ? value.substring(3, 6) : '') + 
                                    (value.length > 6 ? ' ' + value.substring(6, 9) : '');
                        }
                    }
                    
                    e.target.value = value;
                });

                // Auto-format existing value on load
                if (phoneInput.value) {
                    let value = phoneInput.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        // If starts with 0, format as local
                        if (value.startsWith('0')) {
                            value = value.substring(0, 1) + 
                                    (value.length > 1 ? value.substring(1, 4) : '') + 
                                    (value.length > 4 ? ' ' + value.substring(4, 7) : '') + 
                                    (value.length > 7 ? ' ' + value.substring(7, 10) : '');
                        }
                        // If starts with 265, format as international
                        else if (value.startsWith('265')) {
                            value = '+' + value.substring(0, 3) + ' ' + 
                                    (value.length > 3 ? value.substring(3, 6) : '') + 
                                    (value.length > 6 ? ' ' + value.substring(6, 9) : '') + 
                                    (value.length > 9 ? ' ' + value.substring(9, 12) : '');
                        }
                        phoneInput.value = value;
                    }
                }
            }

            // Interactive form enhancements
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="password"]');
            inputs.forEach(input => {
                // Add real-time validation feedback only
                input.addEventListener('input', function() {
                    if (this.value.length > 0) {
                        this.classList.add('border-green-300');
                        this.classList.remove('border-red-300');
                    } else {
                        this.classList.remove('border-green-300', 'border-red-300');
                    }
                });
            });

            // Form submission enhancement
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
                        submitBtn.disabled = true;
                    }
                });
            });
        });
    </script>
</x-dashboard-layout>