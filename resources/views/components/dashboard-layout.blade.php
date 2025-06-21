<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    @auth()


    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-64 bg-white shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50 flex flex-col no-scrollbar overflow-y-auto rounded-r-xl">
        <div class="p-6 flex items-center justify-between lg:justify-start">
            <h1 class="text-lg font-semibold font-mono text-gray-900 inline-block align-middle whitespace-nowrap overflow-visible uppercase">ATSOGO LAND MARKETING</h1>
            <button class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none" onclick="toggleSidebar()">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <nav class="flex-grow p-4">
            <ul>
                {{-- Common Links for all authenticated users (e.g., Dashboard Overview) --}}
                @if(auth()->check() && !auth()->user()->isAdmin())
                    <li class="mb-2 mt-4 border-t border-gray-200 pt-4">
                        <span class="text-xs font-semibold uppercase text-gray-500 px-3">Customer Panel</span>
                    </li>
                @else
                    <li class="mb-2 mt-4 border-t border-gray-200 pt-4">
                        <span class="text-xs font-semibold uppercase text-gray-500 px-3">Admin Panel</span>
                    </li>
                @endif
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="sidebar-item bg-yellow-500 text-white {{ ($activeView ?? '') === 'dashboard' ? 'active' : '' }} flex items-center p-3 rounded-lg font-medium">
                        <i class="fas fa-home mr-3 text-lg"></i>
                        My Dashboard
                    </a>
                </li>

                @if (auth()->user()->isAdmin())
                    {{-- Admin-specific plot links --}}
                    <li class="mb-2">
                        <a href="{{ route('plots.index') }}" class="sidebar-item {{ (request()->routeIs('plots.*')) ? 'active bg-yellow-500 text-white' : 'text-gray-600 hover:bg-gray-200' }} flex items-center p-3 rounded-lg font-medium">
                            <i class="fas fa-th-list mr-3 text-lg"></i>
                            Manage Plots
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('plots.create') }}" class="sidebar-item {{ (request()->routeIs('plots.create')) ? 'active bg-yellow-500 text-white' : 'text-gray-600 hover:bg-gray-200' }} flex items-center p-3 rounded-lg font-medium">
                            <i class="fas fa-plus-square mr-3 text-lg"></i>
                            Add New Plot
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('inquiries.index') }}" class="sidebar-item {{ (request()->routeIs('inquiries.*')) ? 'active bg-yellow-500 text-white' : 'text-gray-600 hover:bg-gray-200' }} flex items-center p-3 rounded-lg font-medium">
                            <i class="fas fa-envelope-open-text mr-3 text-lg"></i>
                            Manage Inquiries
                        </a>
                    </li>
                @else
                    {{-- Customer-specific plot links --}}
                    <li class="mb-2">
                        <a href="{{ route('customer.plots.index') }}" class="sidebar-item {{ (request()->routeIs('customer.plots.*')) ? 'active bg-yellow-500 text-white' : 'text-gray-600 hover:bg-gray-200' }} flex items-center p-3 rounded-lg font-medium">
                            <i class="fas fa-list-alt mr-3 text-lg"></i>
                            All Plots
                        </a>
                    </li>
                @endif
                
                

                {{-- Customer Specific Sidebar Items (Only for Non-Admins / Customers) --}}
                {{-- These links are now only visible if the user is NOT an admin --}}
                @if (auth()->check() && !auth()->user()->isAdmin())
                    <li class="mb-2">
                        <a href="{{route('inquiries.index')}}" class="sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-yellow-100 transition-colors">
                            <i class="fas fa-question-circle mr-3 text-lg"></i>
                            Inquiries
                        </a>
                    </li>
                    
                   <li class="mb-2">
                        <a href="{{ route('saved-plots.index') }}" class="sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-yellow-100 transition-colors">
                            <i class="fas fa-bookmark mr-3 text-lg"></i>
                            Saved Plots
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('reservations.index') }}" class="sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-yellow-100 transition-colors">
                            <i class="fas fa-calendar-alt mr-3 text-lg"></i>
                            Reservations
                        </a>
                    </li>
                @endif

                <li class="mb-2">
                    <a href="{{route('customer.plots.show', auth()->user()->id)}}" class="sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-yellow-100 transition-colors">
                        <i class="fas fa-magnifying-glass-location mr-3 text-lg"></i>
                        Review Plot
                    </a>
                </li>

                <li class="mb-2">
                    <a href="#" class="sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-yellow-100 transition-colors">
                        <i class="fas fa-money-check-alt mr-3 text-lg"></i>
                        Payment
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{route('user.edit', auth()->user()->id)}}" class="sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-yellow-100 transition-colors">
                        <i class="fas fa-user mr-3 text-lg"></i>
                        Profile
                    </a>
                </li>

                {{-- End Customer Specific Sidebar Items --}}

                {{-- Admin Specific Sidebar Items (Only for Admins) --}}
                @if(auth()->check() && auth()->user()->isAdmin())

                <li class="mb-2">
                    <a href="{{ route('user.index') }}" class="sidebar-item {{ ($activeView ?? '') === 'admin_users_index' ? 'active bg-yellow-500 text-white' : 'text-gray-600 hover:bg-yellow-100' }} flex items-center p-3 rounded-lg font-medium transition-colors">
                        <i class="fas fa-users mr-3 text-lg"></i>
                        Manage Users
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('dashboard', ['viewType' => 'admin', 'id' => 'settings']) }}" class="sidebar-item {{ ($activeView ?? '') === 'admin_settings_index' ? 'active bg-yellow-500 text-white' : 'text-gray-600 hover:bg-yellow-100' }} flex items-center p-3 rounded-lg font-medium transition-colors">
                        <i class="fas fa-cog mr-3 text-lg"></i>
                        Manage Settings
                    </a>
                </li>


                {{-- Add more admin links here (e.g., Manage Users, Settings) --}}
                @endif
                {{-- End Admin Specific Sidebar Items --}}

                <!-- Logout option moved to sidebar -->
                <li class="mt-4 border-t border-gray-200 pt-4">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); showLogoutModal();" class="sidebar-item flex items-center p-3 rounded-lg text-gray-600 hover:bg-gray-200">
                        <i class="fas fa-sign-out-alt mr-3 text-lg"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-h-screen overflow-y-auto no-scrollbar">
        <header class="bg-white shadow-md p-4 flex items-center justify-between sticky top-0 z-30 top-nav">
            <button class="lg:hidden p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-300" onclick="toggleSidebar()">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <div class="relative flex-grow mx-4 max-w-lg hidden sm:block">
                <input type="text" placeholder="Search plots..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>

            <div class="flex items-center space-x-4">
                
                <button class="p-2 rounded-full hover:bg-gray-200 icon-btn relative">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100  rounded-full">2</span>
                </button>

                <!-- User Profile (without Logout dropdown) -->
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

        <main class="p-6 flex-1">
            {{ $slot }}
        </main>
    @endauth

    </div>
    <div id="logout-modal" class="modal hidden">
        <div class="modal-content logout-modal-content">
            <h4 class="text-lg font-bold mb-4">Confirm Logout</h4>
            <p>Are you sure you want to log out?</p>
            <div class="modal-buttons">
                <button id="confirm-logout-btn" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Yes, Logout</button>
                <button type="button" onclick="hideLogoutModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            const logoutModal = document.getElementById('logout-modal');
            const logoutForm = document.getElementById('logout-form');
            const confirmLogoutBtn = document.getElementById('confirm-logout-btn');

            function toggleSidebar() { sidebar.classList.toggle('-translate-x-full'); mobileMenuOverlay.classList.toggle('hidden'); }
            window.toggleSidebar = toggleSidebar;

            

            window.addEventListener('resize', () => { if (window.innerWidth >= 1024) { sidebar.classList.remove('-translate-x-full'); mobileMenuOverlay.classList.add('hidden'); } });

            window.showLogoutModal = function() { logoutModal.classList.remove('hidden'); }
            window.hideLogoutModal = function() { logoutModal.classList.add('hidden'); }
            if (confirmLogoutBtn) {
                confirmLogoutBtn.addEventListener('click', () => { logoutForm.submit(); });
            }
        });
    </script>
</body>
</html>



