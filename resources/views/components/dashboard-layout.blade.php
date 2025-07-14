<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{env(key: 'APP_NAME')}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            @apply bg-gray-100 text-gray-800; /* Default light mode background and text */
        }

        /* Custom styles for sidebar transition */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        /* Hide scrollbar for consistent look, but still allow scrolling */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        /* Modal specific styles */
        .modal {
            /* display: none;  Hidden by default, handled by Tailwind's hidden class */
            position: fixed; /* Stay in place */
            z-index: 100; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0,0,0);
            }
            40%, 43% {
                transform: translate3d(0,-8px,0);
            }
            70% {
                transform: translate3d(0,-4px,0);
            }
            90% {
                transform: translate3d(0,-2px,0);
            }
        }
        
        .animate-bounce {
            animation: bounce 1s infinite;
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

        /* Support Section Animations */
        .support-section {
            position: relative;
            overflow: hidden;
        }

        .support-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease-in-out;
        }

        .support-section:hover::before {
            left: 100%;
        }

        .contact-item {
            position: relative;
            overflow: hidden;
        }

        .contact-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #f59e0b, #f97316);
            transition: width 0.3s ease-in-out;
        }

        .contact-item:hover::after {
            width: 100%;
        }

        /* Ripple effect for contact items */
        .contact-item::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .contact-item:active::before {
            width: 300px;
            height: 300px;
        }

        /* Responsive adjustments for support section */
        @media (max-width: 1024px) {
            .contact-item {
                padding: 0.75rem;
            }
            
            .contact-item .flex-shrink-0 {
                padding: 0.5rem;
            }
        }

        @media (max-width: 768px) {
            .support-section {
                margin-top: 1rem;
            }
            
            .contact-item {
                padding: 0.5rem;
            }
        }

        /* Loading animation for support section */
        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .support-section {
            animation: slideInFromLeft 0.6s ease-out;
        }

        .contact-item {
            animation: slideInFromLeft 0.6s ease-out;
        }

        .contact-item:nth-child(1) { animation-delay: 0.1s; }
        .contact-item:nth-child(2) { animation-delay: 0.2s; }
        .contact-item:nth-child(3) { animation-delay: 0.3s; }
        .contact-item:nth-child(4) { animation-delay: 0.4s; }

        /* Hover effects for social media buttons */
        .social-btn {
            position: relative;
            overflow: hidden;
        }

        .social-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .social-btn:hover::before {
            left: 100%;
        }

        /* Slide down animation for support section */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex h-screen overflow-hidden" data-user-role="{{ auth()->user()->role }}">

    @auth()

    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Hover trigger area -->
    <div id="hover-trigger" class="fixed top-0 left-0 w-4 h-full z-40 hidden lg:block"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-2xl transform -translate-x-full transition-all duration-500 ease-in-out z-50 flex flex-col no-scrollbar overflow-y-auto rounded-r-2xl border-r border-gray-200">
        <!-- Header Section -->
        <div class="p-4 flex items-center justify-between lg:justify-start bg-yellow-500 rounded-br-2xl">
            <h1 class="text-sm font-bold text-white inline-block align-middle whitespace-nowrap overflow-visible uppercase tracking-wide">ATSOGO ESTATE AGENCY</h1>
            <button class="lg:hidden text-white hover:text-gray-100 focus:outline-none transform hover:scale-110 transition-transform duration-200" onclick="toggleSidebar()">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Back Arrow for Dashboard -->
        <div class="px-4 py-3 border-b border-gray-200 bg-white">
            <div class="flex justify-end">
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}" 
                   class="group inline-flex items-center px-3 py-2 text-gray-600 hover:text-gray-800 transition-all duration-300 text-sm">
                    <i class="fas fa-arrow-left mr-1 group-hover:-translate-x-1 transition-transform duration-300"></i>
                    Back
                </a>
            </div>
        </div>

        <!-- Navigation Section -->
        <nav class="flex-grow p-3 bg-white">
            <ul class="space-y-1">
                {{-- Panel Label --}}
                @if(auth()->check() && auth()->user()->isAdmin())
                    <li class="mb-3 mt-1">
                        <div class="px-2 py-1 bg-yellow-100 rounded-md border-l-3 border-yellow-500">
                            <span class="text-xs font-bold uppercase text-yellow-700 tracking-wider">Admin Panel</span>
                        </div>
                    </li>
                @else
                    <li class="mb-3 mt-1">
                        <div class="px-2 py-1 bg-yellow-100 rounded-md border-l-3 border-yellow-500">
                            <span class="text-xs font-bold uppercase text-yellow-700 tracking-wider">Customer Panel</span>
                        </div>
                    </li>
                @endif

                <!-- Dashboard Link -->
                <li>
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}"
                       class="group flex items-center p-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105
                       {{ (request()->routeIs(auth()->user()->isAdmin() ? 'admin.dashboard' : 'customer.dashboard')) ? 'bg-yellow-500 text-white shadow-md' : 'text-gray-700 hover:bg-yellow-50 hover:shadow-sm' }}">
                        <i class="fas fa-home mr-3 text-base group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="font-medium text-sm">Dashboard</span>
                    </a>
                </li>

                {{-- Admin-specific links --}}
                @if(auth()->check() && auth()->user()->isAdmin())
                    <li>
                        <a href="{{ route('admin.plots.index') }}" 
                           class="group flex items-center p-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105
                           {{ (request()->routeIs('admin.plots.index')) ? 'bg-yellow-500 text-white shadow-md' : 'text-gray-700 hover:bg-yellow-50 hover:shadow-sm' }}">
                            <i class="fas fa-th-list mr-3 text-base group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="font-medium text-sm">Manage Plots</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.plots.create') }}" 
                           class="group flex items-center p-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105
                           {{ (request()->routeIs('admin.plots.create')) ? 'bg-yellow-500 text-white shadow-md' : 'text-gray-700 hover:bg-yellow-50 hover:shadow-sm' }}">
                            <i class="fas fa-plus-square mr-3 text-base group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="font-medium text-sm">Add New Plot</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.inquiries.index') }}" 
                           class="group flex items-center p-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105
                           {{ (request()->routeIs('admin.inquiries.index')) ? 'bg-yellow-500 text-white shadow-md' : 'text-gray-700 hover:bg-yellow-50 hover:shadow-sm' }}">
                            <i class="fas fa-envelope-open-text mr-3 text-base group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="font-medium text-sm">Manage Inquiries</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" 
                           class="group flex items-center p-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105
                           {{ (request()->routeIs('admin.users.index')) ? 'bg-yellow-500 text-white shadow-md' : 'text-gray-700 hover:bg-yellow-50 hover:shadow-sm' }}">
                            <i class="fas fa-users mr-3 text-base group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="font-medium text-sm">Manage Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reservations.index') }}" 
                           class="group flex items-center p-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105
                           {{ (request()->routeIs('admin.reservations.index')) ? 'bg-yellow-500 text-white shadow-md' : 'text-gray-700 hover:bg-yellow-50 hover:shadow-sm' }}">
                            <i class="fas fa-calendar-alt mr-3 text-base group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="font-medium text-sm">Manage Reservations</span>
                        </a>
                    </li>
                @endif

                {{-- Customer-specific links --}}
                @if(auth()->check() && !auth()->user()->isAdmin())
                    <li>
                        <a href="{{ route('customer.plots.index') }}" 
                           class="group flex items-center p-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105
                           {{ (request()->routeIs('customer.plots.*')) ? 'bg-yellow-500 text-white shadow-md' : 'text-gray-700 hover:bg-yellow-50 hover:shadow-sm' }}">
                            <i class="fas fa-list-alt mr-3 text-base group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="font-medium text-sm">Browse Plots</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.saved-plots.index') }}" 
                           class="group flex items-center p-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105
                           {{ (request()->routeIs('customer.saved-plots.*')) ? 'bg-yellow-500 text-white shadow-md' : 'text-gray-700 hover:bg-yellow-50 hover:shadow-sm' }}">
                            <i class="fas fa-bookmark mr-3 text-base group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="font-medium text-sm">Saved Plots</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.reservations.index') }}" 
                           class="group flex items-center p-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105
                           {{ (request()->routeIs('customer.reservations.*')) ? 'bg-yellow-500 text-white shadow-md' : 'text-gray-700 hover:bg-yellow-50 hover:shadow-sm' }}">
                            <i class="fas fa-calendar-check mr-3 text-base group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="font-medium text-sm">My Reservations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.inquiries.index') }}" 
                           class="group flex items-center p-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105
                           {{ (request()->routeIs('customer.inquiries.*')) ? 'bg-yellow-500 text-white shadow-md' : 'text-gray-700 hover:bg-yellow-50 hover:shadow-sm' }}">
                            <i class="fas fa-envelope mr-3 text-base group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="font-medium text-sm">My Inquiries</span>
                        </a>
                    </li>
                @endif

                {{-- Common Profile Link --}}
                <li>
                    <a href="{{ route('profile.edit') }}" 
                       class="group flex items-center p-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105
                       {{ (request()->routeIs('profile.*')) ? 'bg-yellow-500 text-white shadow-md' : 'text-gray-700 hover:bg-yellow-50 hover:shadow-sm' }}">
                        <i class="fas fa-user mr-3 text-base group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="font-medium text-sm">Profile</span>
                    </a>
                </li>

                <!-- Logout Section -->
                <li class="mt-4 pt-3 border-t border-gray-200">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); showLogoutModal();" 
                       class="group flex items-center p-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 hover:shadow-sm">
                        <i class="fas fa-sign-out-alt mr-3 text-base group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="font-medium text-sm">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-h-screen overflow-y-auto no-scrollbar">
        <header class="bg-white shadow-md p-4 flex items-center justify-between sticky top-0 z-30 top-nav">
            <button class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-300" onclick="toggleSidebar()">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h1 class="text-lg font-bold text-gray-800">{{ env('APP_NAME') }}</h1>
        </header>

        <!-- Success Message Component -->
        <x-success-message />

        <main class="p-6 flex-1">
            <x-success-message />
            {{ $slot }}
        </main>
    @endauth

    </div>
    <!-- Logout Form (Hidden) -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <!-- Enhanced Logout Confirmation Modal -->
    <div id="logout-modal" class="modal hidden">
        <div class="modal-content" style="max-width: 400px; border-radius: 18px; overflow: hidden; padding: 0;">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 text-white relative">
                <div class="relative z-10 flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold">Log Out?</h4>
                    </div>
                </div>
            </div>
            <!-- Body -->
            <div class="p-6 bg-white">
                <div class="text-center mb-6">
                    <h5 class="text-base font-medium text-gray-800 mb-2">
                        Are you sure you want to log out?
                    </h5>
                    <p class="text-gray-500 text-sm">
                        <span class="font-semibold text-gray-800">{{ auth()->user()->username }}</span>
                    </p>
                </div>
                <!-- Action buttons -->
                <div class="flex space-x-3">
                    <button type="button" onclick="hideLogoutModal()"
                            class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                    <button id="confirm-logout-btn"
                            class="flex-1 px-4 py-3 bg-red-600 text-white font-bold text-base rounded-2xl shadow-xl hover:bg-red-700 hover:scale-110 focus:outline-none focus:ring-4 focus:ring-red-300 transition-all duration-200"
                            style="letter-spacing: 0.5px; box-shadow: 0 6px 24px 0 rgba(220,38,38,0.15);"
                            onclick="handleLogout()">
                        <i class="fas fa-sign-out-alt mr-2"></i>Yes, Logout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Modal -->
    <div id="contact-modal" class="modal hidden">
        <div class="modal-content" style="max-width: 500px;">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-headset text-yellow-500 mr-3"></i>
                    Contact Support
                </h4>
                <button onclick="closeContactModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label for="contact-name" class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input type="text" id="contact-name" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all duration-200"
                           placeholder="Your full name" required>
                    <div id="name-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div>
                    <label for="contact-email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" id="contact-email" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all duration-200"
                           placeholder="your.email@example.com" required>
                    <div id="email-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div>
                    <label for="contact-message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                    <textarea id="contact-message" rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all duration-200 resize-none"
                              placeholder="How can we help you? Please provide details about your inquiry." required></textarea>
                    <div id="message-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    <div class="text-xs text-gray-500 mt-1">
                        <span id="message-count">0</span>/1000 characters
                    </div>
                </div>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h5 class="font-medium text-yellow-800 mb-2">Quick Contact Info:</h5>
                    <div class="text-sm text-yellow-700 space-y-1">
                        <p><i class="fas fa-phone mr-2"></i>+265 888 052 362</p>
                        <p><i class="fas fa-envelope mr-2"></i>info@atsogo.mw</p>
                        <p><i class="fas fa-map-marker-alt mr-2"></i>Area 47 sector 4, Mazengera street, gate No 25, Lilongwe</p>
                    </div>
                </div>
            </div>
            
            <div class="modal-buttons mt-6">
                <button onclick="submitContactForm()" 
                        class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-medium transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Send Message
                </button>
                <button onclick="closeContactModal()" 
                        class="px-6 py-3 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 hover:text-yellow-900 font-medium transition-all duration-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <script>
        function redirectToNotifications() {
            @if(auth()->user()->isAdmin())
                window.location.href = "{{ route('admin.notifications.all.view') }}";
            @else
                window.location.href = "{{ route('customer.notifications.all.view') }}";
            @endif
        }
    </script>

    <script>
        // Notification functionality
        let notificationsVisible = false;

        function toggleNotifications() {
            const dropdown = document.getElementById('notifications-dropdown');
            
            if (notificationsVisible) {
                dropdown.classList.add('hidden');
                notificationsVisible = false;
            } else {
                dropdown.classList.remove('hidden');
                loadNotifications();
                notificationsVisible = true;
            }
        }

        function loadNotifications() {
            const route = '{{ auth()->user()->role === "admin" ? route("admin.notifications.index") : route("customer.notifications.index") }}';
            const list = document.getElementById('notifications-list');
            // Show loading state
            list.innerHTML = '<div class="p-4 text-center text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Loading notifications...</div>';
            fetch(route)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const list = document.getElementById('notifications-list');
                    list.innerHTML = '';
                    // If paginated (object with data array)
                    const notifications = Array.isArray(data) ? data : (data.data || []);
                    if (!notifications || notifications.length === 0) {
                        list.innerHTML = '<div class="p-6 text-center text-yellow-500 font-semibold flex flex-col items-center justify-center">\n' +
                            '<i class="fas fa-bell-slash text-3xl mb-2"></i>\n' +
                            'No notifications yet!\n' +
                            '</div>';
                        return;
                    }
                    notifications.forEach(notification => {
                        const item = document.createElement('div');
                        let icon = '<i class="fas fa-bell text-yellow-500"></i>';
                        let bg = 'bg-white';
                        let border = '';
                        let titleColor = 'text-gray-900';
                        let messageColor = 'text-gray-700';
                        if (notification.type === 'reservation_expiring') {
                            icon = '<i class="fas fa-hourglass-half text-yellow-500"></i>';
                            bg = 'bg-yellow-50';
                            border = 'border-l-4 border-yellow-400';
                            titleColor = 'text-yellow-900';
                            messageColor = 'text-yellow-800';
                        } else if (notification.type === 'new_plot') {
                            icon = '<i class="fas fa-star text-green-500"></i>';
                            bg = 'bg-green-50';
                            border = 'border-l-4 border-green-400';
                            titleColor = 'text-green-900';
                            messageColor = 'text-green-800';
                        } else if (notification.type === 'payment_due') {
                            icon = '<i class="fas fa-money-bill-wave text-blue-500"></i>';
                            bg = 'bg-blue-50';
                            border = 'border-l-4 border-blue-400';
                            titleColor = 'text-blue-900';
                            messageColor = 'text-blue-800';
                        } else if (notification.type === 'inquiry_received') {
                            icon = '<i class="fas fa-envelope text-pink-500"></i>';
                            bg = 'bg-pink-50';
                            border = 'border-l-4 border-pink-400';
                            titleColor = 'text-pink-900';
                            messageColor = 'text-pink-800';
                        } else if (notification.type === 'inquiry_responded') {
                            icon = '<i class="fas fa-comment-dots text-purple-500"></i>';
                            bg = 'bg-purple-50';
                            border = 'border-l-4 border-purple-400';
                            titleColor = 'text-purple-900';
                            messageColor = 'text-purple-800';
                        }
                        item.className = `flex items-start gap-3 p-4 ${bg} hover:bg-yellow-100 transition-all duration-200 cursor-pointer rounded-xl shadow-sm mb-2 ${border} ring-1 ring-yellow-100`;
                        if (!notification.is_read) {
                            item.classList.add('ring-2', 'ring-yellow-400', 'shadow-md');
                        }
                        item.style.wordBreak = 'break-word';
                        item.onclick = () => {
                            markAsRead(notification.id);
                            if (notification.inquiry_id) {
                                window.location.href = `/inquiries/${notification.inquiry_id}`;
                            }
                        };
                        item.innerHTML = `
                            <div class="flex-shrink-0 flex flex-col items-center pt-1">
                                <span class="text-2xl">${icon}</span>
                                <span class="text-xs text-yellow-500 mt-1 font-bold">${notification.is_read ? '' : '•'}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-base font-bold ${titleColor} mb-1" style="line-height:1.2;">${notification.title}</p>
                                    <span class="text-xs text-gray-400 ml-2 whitespace-nowrap">${getTimeAgo(notification.created_at)}</span>
                                </div>
                                <p class="text-sm ${messageColor} leading-snug" style="word-break:break-word;">${notification.message}</p>
                            </div>
                        `;
                        list.appendChild(item);
                    });
                })
                .catch(error => {
                    const list = document.getElementById('notifications-list');
                    list.innerHTML = '<div class="p-4 text-center text-red-500">Failed to load notifications</div>';
                    console.error('Error loading notifications:', error);
                });
        }

        function markAsRead(notificationId) {
            const route = '{{ auth()->user()->role === "admin" ? route("admin.notifications.mark-read") : route("customer.notifications.mark-read") }}';
            fetch(route, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ notification_id: notificationId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateNotificationCount();
                    loadNotifications();
                }
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
            });
        }

        function markAllAsRead() {
            const route = '{{ auth()->user()->role === "admin" ? route("admin.notifications.mark-all-read") : route("customer.notifications.mark-all-read") }}';
            fetch(route, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateNotificationCount();
                    loadNotifications();
                }
            })
            .catch(error => {
                console.error('Error marking all notifications as read:', error);
            });
        }

        function updateNotificationCount() {
            const route = '{{ auth()->user()->role === "admin" ? route("admin.notifications.unread-count") : route("customer.notifications.unread-count") }}';
            fetch(route)
                .then(response => response.json())
                .then(data => {
                    const dot = document.getElementById('notification-dot');
                    if (data.count > 0) {
                        dot.classList.remove('hidden');
                    } else {
                        dot.classList.add('hidden');
                    }
                })
                .catch(error => {
                    const dot = document.getElementById('notification-dot');
                    dot.classList.add('hidden');
                });
        }

        function viewAllNotifications() {
            // Redirect to a full notifications page or show all notifications
            const route = '{{ auth()->user()->role === "admin" ? route("admin.notifications.all") : route("customer.notifications.all") }}';
            fetch(route)
                .then(response => response.json())
                .then(data => {
                    const list = document.getElementById('notifications-list');
                    list.innerHTML = '';
                    // If paginated (object with data array)
                    const notifications = Array.isArray(data) ? data : (data.data || []);
                    if (!notifications || notifications.length === 0) {
                        list.innerHTML = '<div class="p-6 text-center text-yellow-500 font-semibold flex flex-col items-center justify-center">\n' +
                            '<i class="fas fa-bell-slash text-3xl mb-2"></i>\n' +
                            'No notifications yet!\n' +
                            '</div>';
                        return;
                    }
                    notifications.forEach(notification => {
                        const item = document.createElement('div');
                        let icon = '🔔';
                        let bg = 'bg-white';
                        let border = '';
                        let titleColor = 'text-gray-900';
                        let messageColor = 'text-gray-600';
                        if (notification.type === 'reservation_expiring') {
                            icon = '<i class="fas fa-hourglass-half text-yellow-500"></i>';
                            bg = 'bg-yellow-50';
                            border = 'border-l-4 border-yellow-400';
                            titleColor = 'text-yellow-800';
                            messageColor = 'text-yellow-700';
                        } else if (notification.type === 'new_plot') {
                            icon = '<i class="fas fa-star text-green-500"></i>';
                            bg = 'bg-green-50';
                            border = 'border-l-4 border-green-400';
                            titleColor = 'text-green-800';
                            messageColor = 'text-green-700';
                        } else if (notification.type === 'payment_due') {
                            icon = '<i class="fas fa-money-bill-wave text-blue-500"></i>';
                            bg = 'bg-blue-50';
                            border = 'border-l-4 border-blue-400';
                            titleColor = 'text-blue-800';
                            messageColor = 'text-blue-700';
                        } else if (notification.type === 'inquiry_received') {
                            icon = '🚨';
                        } else if (notification.type === 'inquiry_responded') {
                            icon = '💬';
                        }
                        item.className = `flex items-start gap-3 p-4 ${bg} hover:bg-yellow-50 transition-all duration-200 cursor-pointer rounded-xl shadow-sm mb-2 ${border}`;
                        if (!notification.is_read) {
                            item.classList.add('ring-2', 'ring-yellow-300');
                        }
                        item.onclick = () => {
                            markAsRead(notification.id);
                            if (notification.inquiry_id) {
                                window.location.href = `/inquiries/${notification.inquiry_id}`;
                            }
                        };
                        item.innerHTML = `
                            <div class="flex-shrink-0 flex flex-col items-center pt-1">
                                <span class="text-2xl">${icon}</span>
                                <span class="text-xs text-yellow-400 mt-1">${notification.is_read ? '' : '•'}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-bold ${titleColor} mb-1">${notification.title}</p>
                                    <span class="text-xs text-gray-400 ml-2">${getTimeAgo(notification.created_at)}</span>
                                </div>
                                <p class="text-sm ${messageColor}">${notification.message}</p>
                            </div>
                        `;
                        list.appendChild(item);
                    });
                })
                .catch(error => {
                    const list = document.getElementById('notifications-list');
                    list.innerHTML = '<div class="p-4 text-center text-red-500">Failed to load notifications</div>';
                    console.error('Error loading notifications:', error);
                });
        }

        function getTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);
            
            if (diffInSeconds < 60) return 'Just now';
            if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + 'm ago';
            if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + 'h ago';
            return Math.floor(diffInSeconds / 86400) + 'd ago';
        }

        function showToastNotification(message, type = 'info') {
            // Create toast element
            const toast = document.createElement('div');
            
            // Set colors based on type
            let bgColor, icon;
            switch(type) {
                case 'success':
                    bgColor = 'bg-green-500';
                    icon = 'fas fa-check-circle';
                    break;
                case 'error':
                    bgColor = 'bg-red-500';
                    icon = 'fas fa-exclamation-circle';
                    break;
                case 'warning':
                    bgColor = 'bg-yellow-500';
                    icon = 'fas fa-exclamation-triangle';
                    break;
                default:
                    bgColor = 'bg-blue-500';
                    icon = 'fas fa-info-circle';
            }
            
            toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-all duration-300 max-w-sm`;
            toast.innerHTML = `
                <div class="flex items-center space-x-3">
                    <i class="${icon} text-lg"></i>
                    <span class="text-sm font-medium">${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after 4 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (document.body.contains(toast)) {
                    document.body.removeChild(toast);
                    }
                }, 300);
            }, 4000);
        }

        window.initSidebarHover = function() {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
            const hoverTrigger = document.getElementById('hover-trigger');
            let sidebarOpen = false;
            let hoverTimeout;

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOpen = true;
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOpen = false;
            }

            function toggleSidebar() { 
                if (sidebarOpen) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
                mobileMenuOverlay.classList.toggle('hidden');
            }
            window.toggleSidebar = toggleSidebar;

            // Hover functionality for desktop
            if (window.innerWidth >= 1024 && hoverTrigger) {
                hoverTrigger.onmouseenter = () => {
                    clearTimeout(hoverTimeout);
                    openSidebar();
                };
                sidebar.onmouseenter = () => {
                    clearTimeout(hoverTimeout);
                };
                sidebar.onmouseleave = () => {
                    hoverTimeout = setTimeout(() => {
                        closeSidebar();
                    }, 300);
                };
                hoverTrigger.onmouseleave = () => {
                    hoverTimeout = setTimeout(() => {
                        closeSidebar();
                    }, 300);
                };
            }

            // Mobile functionality
            window.addEventListener('resize', () => { 
                if (window.innerWidth >= 1024) { 
                    closeSidebar();
                    mobileMenuOverlay.classList.add('hidden'); 
                } else {
                    closeSidebar();
                }
            });
        }
        // Call on DOMContentLoaded
        window.addEventListener('DOMContentLoaded', function() {
            window.initSidebarHover();
            const sidebar = document.getElementById('sidebar');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
            const hoverTrigger = document.getElementById('hover-trigger');
            const logoutModal = document.getElementById('logout-modal');
            const logoutForm = document.getElementById('logout-form');
            const confirmLogoutBtn = document.getElementById('confirm-logout-btn');
            
            let sidebarOpen = false;
            let hoverTimeout;

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOpen = true;
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOpen = false;
            }

            function toggleSidebar() { 
                if (sidebarOpen) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
                mobileMenuOverlay.classList.toggle('hidden');
            }
            window.toggleSidebar = toggleSidebar;

            // Hover functionality for desktop
            if (window.innerWidth >= 1024) {
                hoverTrigger.addEventListener('mouseenter', () => {
                    clearTimeout(hoverTimeout);
                    openSidebar();
                });

                sidebar.addEventListener('mouseenter', () => {
                    clearTimeout(hoverTimeout);
                });

                sidebar.addEventListener('mouseleave', () => {
                    hoverTimeout = setTimeout(() => {
                        closeSidebar();
                    }, 300);
                });

                hoverTrigger.addEventListener('mouseleave', () => {
                    hoverTimeout = setTimeout(() => {
                        closeSidebar();
                    }, 300);
                });
            }

            // Mobile functionality
            window.addEventListener('resize', () => { 
                if (window.innerWidth >= 1024) { 
                    closeSidebar();
                    mobileMenuOverlay.classList.add('hidden'); 
                } else {
                    closeSidebar();
                }
            });

            window.showLogoutModal = function() { 
                logoutModal.classList.remove('hidden');
                // Faster entrance animation
                const modalContent = logoutModal.querySelector('.modal-content');
                modalContent.style.transform = 'scale(0.95)';
                modalContent.style.opacity = '0';
                modalContent.style.transition = 'all 0.2s ease-out';
                
                setTimeout(() => {
                    modalContent.style.transform = 'scale(1)';
                    modalContent.style.opacity = '1';
                }, 10);
            }
            
            window.hideLogoutModal = function() { 
                const modalContent = logoutModal.querySelector('.modal-content');
                modalContent.style.transform = 'scale(0.95)';
                modalContent.style.opacity = '0';
                modalContent.style.transition = 'all 0.15s ease-in';
                
                setTimeout(() => {
                    logoutModal.classList.add('hidden');
                    modalContent.style.transform = '';
                    modalContent.style.opacity = '';
                    modalContent.style.transition = '';
                }, 150);
            }
            // Logout functionality is now simplified and faster
            
            // Global logout handler function - Simplified and faster
            window.handleLogout = function() {
                const btn = document.getElementById('confirm-logout-btn');
                const logoutForm = document.getElementById('logout-form');
                
                // Show loading state
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Logging out...';
                btn.disabled = true;
                
                // Submit form immediately
                if (logoutForm) {
                    logoutForm.submit();
                } else {
                    // Fallback: redirect to logout route
                    window.location.href = '{{ route('logout') }}';
                }
            };
            
            // Close logout modal when clicking outside
            logoutModal.addEventListener('click', function(e) {
                if (e.target === logoutModal) {
                    hideLogoutModal();
                }
            });
            
            // Close logout modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !logoutModal.classList.contains('hidden')) {
                    hideLogoutModal();
                }
            });

            // Load notification count on page load
            updateNotificationCount();
            
            // Update notification count every 10 seconds for real-time updates
            setInterval(updateNotificationCount, 10000);
            
            // Auto-refresh notifications if dropdown is open
            setInterval(() => {
                if (notificationsVisible) {
                    loadNotifications();
                }
            }, 15000);

            // Close notifications when clicking outside
            document.addEventListener('click', function(e) {
                const dropdown = document.getElementById('notifications-dropdown');
                const bell = document.querySelector('.fa-bell').parentElement;
                
                if (!dropdown.contains(e.target) && !bell.contains(e.target)) {
                    dropdown.classList.add('hidden');
                    notificationsVisible = false;
                }
            });
        });

        // Contact Functions
        function copyToClipboard(text) {
            // Add visual feedback
            const event = window.event;
            const target = event.target.closest('.contact-item');
            
            if (target) {
                // Add success animation
                target.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    target.style.transform = '';
                }, 150);
            }

            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    showToastNotification('✅ Copied to clipboard!', 'success');
                }).catch(() => {
                    showToastNotification('❌ Failed to copy', 'error');
                });
            } else {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToastNotification('✅ Copied to clipboard!', 'success');
            }
        }

        function callPhone(phoneNumber) {
            // Add visual feedback
            const event = window.event;
            const target = event.target.closest('.contact-item');
            
            if (target) {
                target.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    target.style.transform = '';
                }, 150);
            }

            // Show confirmation with better UI
            const confirmed = confirm(`