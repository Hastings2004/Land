<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{env(key: 'APP_NAME')}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
</head>
<body class="flex h-screen overflow-hidden">

    @auth()

    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Hover trigger area -->
    <div id="hover-trigger" class="fixed top-0 left-0 w-4 h-full z-40 hidden lg:block"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-2xl transform -translate-x-full transition-all duration-500 ease-in-out z-50 flex flex-col no-scrollbar overflow-y-auto rounded-r-2xl border-r border-gray-200">
        <!-- Header Section -->
        <div class="p-4 flex items-center justify-between lg:justify-start bg-yellow-500 rounded-br-2xl">
            <h1 class="text-sm font-bold text-white inline-block align-middle whitespace-nowrap overflow-visible uppercase tracking-wide">ATSOGO LAND MARKETING</h1>
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

            <!-- Notification Bell -->
            <div class="relative flex items-center space-x-4">
                <div class="relative cursor-pointer" onclick="toggleNotifications()">
                    <i class="fas fa-bell text-xl text-gray-600 hover:text-yellow-500 transition-colors"></i>
                    <span id="notification-dot" class="absolute -top-1.5 -right-1.5 h-3 w-3 bg-yellow-500 rounded-full border-2 border-white hidden"></span>
                </div>

                <!-- Notifications Dropdown -->
                <div id="notifications-dropdown" class="absolute right-0 mt-12 w-96 max-w-full bg-white rounded-2xl shadow-2xl z-50 hidden border border-yellow-200 animate-fade-in">
                    <div class="p-4 border-b border-yellow-200 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-t-2xl flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-bell text-yellow-500 text-xl"></i>
                            <h3 class="text-lg font-bold text-yellow-700">Notifications</h3>
                        </div>
                        <button onclick="markAllAsRead()" class="text-xs px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 hover:text-yellow-800 font-semibold transition-all duration-200">Mark all read</button>
                    </div>
                    <div id="notifications-list" class="max-h-96 overflow-y-auto divide-y divide-yellow-50">
                        <!-- Notifications will be loaded here -->
                    </div>
                    <div class="p-4 border-t border-yellow-200 bg-yellow-50 rounded-b-2xl text-center">
                        <a href="#" onclick="viewAllNotifications()" class="text-sm text-yellow-700 hover:text-yellow-900 font-semibold transition-all duration-200">View all notifications</a>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="relative flex items-center space-x-2 cursor-pointer group" tabindex="0">
                    <img src="https://placehold.co/40x40/FFD700/FFFFFF?text={{ strtoupper(substr(auth()->user()->username, 0, 2)) }}" alt="User Avatar" class="w-10 h-10 rounded-full border-2 border-yellow-500">
                    <span class="font-semibold hidden sm:block">{{ auth()->user()->username }}</span>
                    <i class="fas fa-chevron-down text-gray-500 ml-1"></i>
                    <div class="absolute left-0 mt-12 w-40 bg-white rounded-md shadow-lg z-50 hidden group-focus:block group-hover:block">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); showLogoutModal();" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Success Message Component -->
        <x-success-message />

        <main class="p-6 flex-1">
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
                            class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 font-medium transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300 shadow-lg"
                            onclick="handleLogout()">
                        Yes, Logout
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
                        class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg hover:from-yellow-600 hover:to-orange-600 font-medium transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Send Message
                </button>
                <button onclick="closeContactModal()" 
                        class="px-6 py-3 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 font-medium transition-all duration-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>

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
                        item.className = 'flex items-start gap-3 p-4 bg-white hover:bg-yellow-50 transition-all duration-200 cursor-pointer rounded-xl shadow-sm mb-2';
                        if (!notification.is_read) {
                            item.classList.add('ring-2', 'ring-yellow-300');
                        }
                        item.onclick = () => {
                            markAsRead(notification.id);
                            // Redirect to inquiry if it's an inquiry notification
                            if (notification.inquiry_id) {
                                window.location.href = `/inquiries/${notification.inquiry_id}`;
                            }
                        };
                        const icon = notification.type === 'inquiry_received' ? '🚨' : 
                                    notification.type === 'inquiry_responded' ? '💬' : '🔔';
                        item.innerHTML = `
                            <div class="flex-shrink-0 flex flex-col items-center pt-1">
                                <span class="text-2xl">${icon}</span>
                                <span class="text-xs text-yellow-400 mt-1">${notification.is_read ? '' : '•'}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-bold text-gray-900 mb-1">${notification.title}</p>
                                    <span class="text-xs text-gray-400 ml-2">${getTimeAgo(notification.created_at)}</span>
                                </div>
                                <p class="text-sm text-gray-600">${notification.message}</p>
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
                        item.className = 'flex items-start gap-3 p-4 bg-white hover:bg-yellow-50 transition-all duration-200 cursor-pointer rounded-xl shadow-sm mb-2';
                        if (!notification.is_read) {
                            item.classList.add('ring-2', 'ring-yellow-300');
                        }
                        item.onclick = () => {
                            markAsRead(notification.id);
                            // Redirect to inquiry if it's an inquiry notification
                            if (notification.inquiry_id) {
                                window.location.href = `/inquiries/${notification.inquiry_id}`;
                            }
                        };
                        const icon = notification.type === 'inquiry_received' ? '🚨' : 
                                    notification.type === 'inquiry_responded' ? '💬' : '🔔';
                        item.innerHTML = `
                            <div class="flex-shrink-0 flex flex-col items-center pt-1">
                                <span class="text-2xl">${icon}</span>
                                <span class="text-xs text-yellow-400 mt-1">${notification.is_read ? '' : '•'}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-bold text-gray-900 mb-1">${notification.title}</p>
                                    <span class="text-xs text-gray-400 ml-2">${getTimeAgo(notification.created_at)}</span>
                                </div>
                                <p class="text-sm text-gray-600">${notification.message}</p>
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

        window.addEventListener('DOMContentLoaded', function() {
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
                // Add entrance animation
                setTimeout(() => {
                    const modalContent = logoutModal.querySelector('.modal-content');
                    modalContent.style.transform = 'scale(0.9)';
                    modalContent.style.opacity = '0';
                    modalContent.style.transition = 'all 0.3s ease-out';
                    
                    setTimeout(() => {
                        modalContent.style.transform = 'scale(1)';
                        modalContent.style.opacity = '1';
                    }, 50);
                }, 10);
            }
            
            window.hideLogoutModal = function() { 
                const modalContent = logoutModal.querySelector('.modal-content');
                modalContent.style.transform = 'scale(0.9)';
                modalContent.style.opacity = '0';
                modalContent.style.transition = 'all 0.2s ease-in';
                
                setTimeout(() => {
                    logoutModal.classList.add('hidden');
                    modalContent.style.transform = '';
                    modalContent.style.opacity = '';
                    modalContent.style.transition = '';
                }, 200);
            }
            // Logout button is now handled by onclick="handleLogout()"
            console.log('Logout form element:', logoutForm);
            console.log('Confirm logout button:', confirmLogoutBtn);
            
            // Fallback logout function
            function performLogout() {
                console.log('Performing direct logout...');
                // Create a temporary form and submit it
                const tempForm = document.createElement('form');
                tempForm.method = 'POST';
                tempForm.action = '{{ route('logout') }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                tempForm.appendChild(csrfToken);
                document.body.appendChild(tempForm);
                tempForm.submit();
            }
            
            // Global logout handler function
            window.handleLogout = function() {
                console.log('handleLogout called');
                const btn = document.getElementById('confirm-logout-btn');
                const originalText = btn.innerHTML;
                
                // Show loading state
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Logging out...';
                btn.disabled = true;
                
                // Try form submission first
                const logoutForm = document.getElementById('logout-form');
                if (logoutForm) {
                    console.log('Submitting logout form...');
                    logoutForm.submit();
                } else {
                    console.log('Form not found, using fallback...');
                    performLogout();
                }
                
                // Reset button after a short delay (in case form submission fails)
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 2000);
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
            const confirmed = confirm(`📞 Would you like to call ${phoneNumber}?`);
            if (confirmed) {
                showToastNotification('📞 Opening phone app...', 'info');
                setTimeout(() => {
                    window.location.href = 'tel:' + phoneNumber;
                }, 500);
            }
        }

        function sendEmail(email) {
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
            const confirmed = confirm(`✉️ Would you like to send an email to ${email}?`);
            if (confirmed) {
                showToastNotification('✉️ Opening email app...', 'info');
                setTimeout(() => {
                    window.location.href = 'mailto:' + email + '?subject=ATSOGO Land Marketing Inquiry&body=Hello, I would like to inquire about your land marketing services.';
                }, 500);
            }
        }

        function openWebsite(url) {
            // Add visual feedback
            const event = window.event;
            const target = event.target.closest('.contact-item, button');
            
            if (target) {
                target.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    target.style.transform = '';
                }, 150);
            }

            showToastNotification('🌐 Opening website...', 'info');
            setTimeout(() => {
                window.open(url, '_blank');
            }, 300);
        }

        function openContactModal() {
            const modal = document.getElementById('contact-modal');
            modal.classList.remove('hidden');
            
            // Set up character counter for message
            const messageTextarea = document.getElementById('contact-message');
            const messageCount = document.getElementById('message-count');
            
            messageTextarea.addEventListener('input', function() {
                const length = this.value.length;
                messageCount.textContent = length;
                
                if (length > 900) {
                    messageCount.classList.add('text-red-500');
                    messageCount.classList.remove('text-gray-500');
                } else {
                    messageCount.classList.remove('text-red-500');
                    messageCount.classList.add('text-gray-500');
                }
            });
            
            // Auto-fill user info if available
            const user = @json(auth()->user());
            if (user) {
                document.getElementById('contact-name').value = user.name || user.username || '';
                document.getElementById('contact-email').value = user.email || '';
            }
        }

        function closeContactModal() {
            const modal = document.getElementById('contact-modal');
            modal.classList.add('hidden');
        }

        function submitContactForm() {
            // Clear previous errors
            document.querySelectorAll('[id$="-error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
            
            const name = document.getElementById('contact-name').value.trim();
            const email = document.getElementById('contact-email').value.trim();
            const message = document.getElementById('contact-message').value.trim();
            
            let hasErrors = false;
            
            // Validate name
            if (!name) {
                document.getElementById('name-error').textContent = 'Name is required';
                document.getElementById('name-error').classList.remove('hidden');
                hasErrors = true;
            } else if (name.length < 2) {
                document.getElementById('name-error').textContent = 'Name must be at least 2 characters';
                document.getElementById('name-error').classList.remove('hidden');
                hasErrors = true;
            }
            
            // Validate email
            if (!email) {
                document.getElementById('email-error').textContent = 'Email is required';
                document.getElementById('email-error').classList.remove('hidden');
                hasErrors = true;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                document.getElementById('email-error').textContent = 'Please enter a valid email address';
                document.getElementById('email-error').classList.remove('hidden');
                hasErrors = true;
            }
            
            // Validate message
            if (!message) {
                document.getElementById('message-error').textContent = 'Message is required';
                document.getElementById('message-error').classList.remove('hidden');
                hasErrors = true;
            } else if (message.length < 10) {
                document.getElementById('message-error').textContent = 'Message must be at least 10 characters';
                document.getElementById('message-error').classList.remove('hidden');
                hasErrors = true;
            } else if (message.length > 1000) {
                document.getElementById('message-error').textContent = 'Message must be less than 1000 characters';
                document.getElementById('message-error').classList.remove('hidden');
                hasErrors = true;
            }
            
            if (hasErrors) {
                return;
            }
            
            // Show loading state
            const submitBtn = document.querySelector('button[onclick="submitContactForm()"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
            submitBtn.disabled = true;
            
            // Send form data to backend
            fetch('{{ route("contact.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    message: message
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToastNotification(data.message, 'success');
                    closeContactModal();
                    
                    // Clear form
                    document.getElementById('contact-name').value = '';
                    document.getElementById('contact-email').value = '';
                    document.getElementById('contact-message').value = '';
                } else {
                    showToastNotification(data.message || 'Failed to send message', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToastNotification('Failed to send message. Please try again.', 'error');
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

        // Toggle Support Section

    </script>
    <!-- Alpine.js loaded last for reliability (DASHBOARD LAYOUT) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>


