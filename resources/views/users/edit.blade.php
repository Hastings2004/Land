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
                    @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover border-4 border-yellow-200 shadow-lg transition-transform duration-300 hover:scale-110 active:scale-95 cursor-pointer group">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center border-4 border-yellow-200 shadow-lg transition-transform duration-300 hover:scale-110 active:scale-95 cursor-pointer group">
                            <span class="text-3xl font-bold text-yellow-900 group-hover:animate-bounce">{{ strtoupper(substr(auth()->user()->username, 0, 2)) }}</span>
                        </div>
                    @endif
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
                            <span class="inline-flex items-center px-4 py-2 bg-yellow-100 rounded-full text-yellow-500 text-sm font-semibold animate-pulse">
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
            <div id="success-message" class="bg-gradient-to-r from-green-400 to-emerald-500 text-white px-6 py-4 rounded-xl shadow-lg mb-8 flex items-center fade-in">
                <i class="fas fa-check-circle text-2xl mr-3"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-gradient-to-r from-red-400 to-pink-500 text-white px-6 py-4 rounded-xl shadow-lg mb-8 fade-in">
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
                        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6" id="profile-form">
                    @csrf
                    @method('PUT')
                    
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                                    <div class="relative">
                                        <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400"></i>
                                        <input type="text" name="username" id="username" value="{{ old('username', auth()->user()->username) }}" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-500 focus:shadow-lg transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                               placeholder="Enter your username">
                                    </div>
                                    @error('username')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                    <div class="relative">
                                        <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400"></i>
                                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-500 focus:shadow-lg transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
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
                                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-500 focus:shadow-lg transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white">
                                </div>
                                @error('phone_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-yellow-500 border border-yellow-500 text-yellow-900 rounded-lg font-bold text-sm uppercase shadow-lg hover:from-yellow-500 hover:to-yellow-600 transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-yellow-400 flex items-center justify-center gap-2" id="update-profile-btn" data-tooltip="Update your profile information">
                                    <span id="profile-btn-spinner" class="hidden"><i class="fas fa-spinner fa-spin"></i></span>
                                    <span id="profile-btn-text"><i class="fas fa-save mr-2"></i> Update Profile</span>
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
                        <form action="{{ route('profile.change_password') }}" method="POST" class="space-y-4" id="password-form">
                    @csrf
                    
                            <div>
                                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400"></i>
                                    <input type="password" name="current_password" id="current_password" 
                                           class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-500 focus:shadow-lg transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                           placeholder="Enter current password">
                                    <button type="button" tabindex="-1" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-yellow-500 focus:outline-none password-toggle" data-target="current_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400"></i>
                                    <input type="password" name="password" id="password" 
                                           class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-500 focus:shadow-lg transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                           placeholder="Enter new password">
                                    <button type="button" tabindex="-1" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-yellow-500 focus:outline-none password-toggle" data-target="password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400"></i>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg focus:border-yellow-400 focus:ring-2 focus:ring-yellow-500 focus:shadow-lg transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                           placeholder="Confirm new password">
                                    <button type="button" tabindex="-1" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-yellow-500 focus:outline-none password-toggle" data-target="password_confirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-500 border border-yellow-500 text-yellow-900 rounded-lg font-bold text-sm uppercase shadow-lg hover:from-yellow-500 hover:to-yellow-600 transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-yellow-400 flex items-center justify-center gap-2" id="change-password-btn" data-tooltip="Change your password securely">
                                    <span id="password-btn-spinner" class="hidden"><i class="fas fa-spinner fa-spin"></i></span>
                                    <span id="password-btn-text"><i class="fas fa-key mr-2"></i> Change Password</span>
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

    @push('styles')
        <style>
            /* Animate success/error messages */
            .fade-in {
                animation: fadeIn 0.5s ease-in;
            }
            .fade-out {
                animation: fadeOut 0.5s ease-out;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeOut {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(-10px); }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Animate success message fade out
            document.addEventListener('DOMContentLoaded', function() {
                const successMsg = document.getElementById('success-message');
                if (successMsg) {
                    setTimeout(() => {
                        successMsg.classList.remove('fade-in');
                        successMsg.classList.add('fade-out');
                        setTimeout(() => successMsg.style.display = 'none', 500);
                    }, 3000);
                }
            });
            // Profile form loading state
            const profileForm = document.getElementById('profile-form');
            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    const btn = document.getElementById('update-profile-btn');
                    btn.disabled = true;
                    document.getElementById('profile-btn-spinner').classList.remove('hidden');
                    document.getElementById('profile-btn-text').classList.add('opacity-50');
                });
            }
            // Password form loading state
            const passwordForm = document.getElementById('password-form');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    const btn = document.getElementById('change-password-btn');
                    btn.disabled = true;
                    document.getElementById('password-btn-spinner').classList.remove('hidden');
                    document.getElementById('password-btn-text').classList.add('opacity-50');
                });
            }
            // Tooltips
            document.querySelectorAll('[data-tooltip]').forEach(function(el) {
                el.addEventListener('mouseenter', function() {
                    let tooltip = document.createElement('div');
                    tooltip.className = 'fixed z-50 px-3 py-2 bg-black text-white text-xs rounded shadow-lg';
                    tooltip.innerText = el.getAttribute('data-tooltip');
                    document.body.appendChild(tooltip);
                    const rect = el.getBoundingClientRect();
                    tooltip.style.left = (rect.left + rect.width/2 - tooltip.offsetWidth/2) + 'px';
                    tooltip.style.top = (rect.top - tooltip.offsetHeight - 8 + window.scrollY) + 'px';
                    el._tooltip = tooltip;
                });
                el.addEventListener('mouseleave', function() {
                    if (el._tooltip) {
                        el._tooltip.remove();
                        el._tooltip = null;
                    }
                });
            });
            // Password eye toggle
            document.querySelectorAll('.password-toggle').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = btn.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = btn.querySelector('i');
                    if (!input) {
                        console.log('Password input not found for', targetId);
                        return;
                    }
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                        console.log('Password shown for', targetId, 'value:', input.value);
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                        console.log('Password hidden for', targetId);
                    }
                });
            });
        </script>
        <script>
document.querySelectorAll('.password-toggle').forEach(function(btn) {
  btn.onclick = function() {
    const input = document.getElementById(btn.getAttribute('data-target'));
    if (input && input.type === 'password') {
      input.type = 'text';
    } else if (input) {
      input.type = 'password';
    }
  }
        });
    </script>
    @endpush
</x-dashboard-layout>