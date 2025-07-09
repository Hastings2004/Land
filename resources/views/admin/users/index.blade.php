<x-dashboard-layout>
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-yellow-600 rounded-lg border border-yellow-300 hover:bg-yellow-50 hover:border-yellow-400 focus:ring-2 focus:ring-yellow-400 transition-all duration-200 shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back
                    </a>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center gap-3">
                            <div class="p-2 bg-gradient-to-r from-yellow-500 to-orange-400 rounded-lg shadow">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <span class="text-yellow-600">Manage Users</span>
                        </h1>
                        <p class="text-gray-600 mt-1">View and manage all registered users</p>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div class="relative max-w-md w-full">
                    <form action="{{ route('admin.users.index') }}" method="GET" class="flex">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search users..." 
                                   class="w-full pl-10 pr-4 py-3 border border-yellow-200 rounded-l-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-400 transition-all duration-200">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-500"></i>
                        </div>
                        <button type="submit" class="px-6 py-3 bg-yellow-500 text-white rounded-r-lg hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-400 transition-all duration-200 shadow-md">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-user-shield text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Admins</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'admin')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-user text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Customers</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'customer')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-all duration-300 transform hover:scale-105">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-user-clock text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Active</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Sort Controls -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6 border border-yellow-200">
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                <div class="flex flex-col sm:flex-row gap-4 items-center">
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Filter by Role:</label>
                        <select id="roleFilter" class="px-3 py-2 border border-yellow-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-400 text-sm">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Sort by:</label>
                        <select id="sortBy" class="px-3 py-2 border border-yellow-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-400 text-sm">
                            <option value="name">Name</option>
                            <option value="role">Role</option>
                            <option value="date">Join Date</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600">View:</span>
                    <button id="gridView" class="p-2 rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-200 focus:ring-2 focus:ring-yellow-400 transition-colors view-active">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button id="listView" class="p-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 focus:ring-2 focus:ring-yellow-400 transition-colors">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Users Display -->
        <div id="usersContainer">
            <!-- Grid View (Mobile/Tablet) -->
            <div id="gridViewContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($users as $user)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 transform hover:scale-105 user-card" data-role="{{ $user->role }}">
                        <div class="p-4">
                            <div class="flex items-center mb-4">
                                <div class="h-12 w-12 rounded-full bg-gradient-to-r from-yellow-500 to-orange-500 flex items-center justify-center text-white font-semibold shadow-md">
                                    {{ strtoupper(substr($user->username, 0, 2)) }}
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="font-semibold text-gray-900 text-sm">{{ $user->username }}</h3>
                                    <p class="text-xs text-gray-500">ID: {{ $user->id }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-envelope text-gray-400 mr-2 w-4"></i>
                                    <span class="text-gray-700 truncate">{{ $user->email }}</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-phone text-gray-400 mr-2 w-4"></i>
                                    <span class="text-gray-700">{{ $user->phone_number ?: 'Not provided' }}</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-calendar text-gray-400 mr-2 w-4"></i>
                                    <span class="text-gray-700">{{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium shadow-sm
                                    @if($user->role === 'admin') bg-yellow-100 text-yellow-800 border border-yellow-200
                                    @else bg-green-100 text-green-800 border border-green-200
                                    @endif">
                                    @if($user->role === 'admin') 👑
                                    @else 👤
                                    @endif
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                            
                            <div class="flex gap-2">
                                @if($user->role === 'admin')
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-yellow-400 text-yellow-700 rounded-lg bg-yellow-50 hover:bg-yellow-100 hover:border-yellow-500 focus:ring-2 focus:ring-yellow-400 transition-all duration-200 text-xs">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <button onclick="confirmDelete({{ $user->id }}, '{{ $user->username }}')" 
                                                class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-red-300 text-red-700 rounded-lg bg-red-50 hover:bg-red-100 hover:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 text-xs">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    @endif
                                @else
                                    <button onclick="viewCustomerProfile({{ $user->id }}, '{{ $user->username }}', '{{ $user->email }}', '{{ $user->phone_number }}', '{{ $user->created_at->format('M d, Y') }}', '{{ $user->role }}')" 
                                            class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-blue-300 text-blue-700 rounded-lg bg-blue-50 hover:bg-blue-100 hover:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 text-xs">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- List View (Desktop) -->
            <div id="listViewContainer" class="hidden">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-list text-yellow-600"></i>
                                User List
                            </h2>
                            <div class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full border">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Total: {{ $users->count() }} users
                            </div>
                        </div>
                    </div>

                    @if($users->count() > 0)
    <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-id-card mr-1"></i> User
                                        </th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-envelope mr-1"></i> Email
                                        </th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-phone mr-1"></i> Phone
                                        </th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-user-tag mr-1"></i> Role
                                        </th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-calendar mr-1"></i> Joined
                                        </th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <i class="fas fa-cogs mr-1"></i> Actions
                                        </th>
                </tr>
            </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                                        <tr class="hover:bg-gray-50 transition-all duration-200 user-row" data-role="{{ $user->role }}">
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-yellow-500 to-orange-500 flex items-center justify-center text-white font-semibold shadow-md">
                                                            {{ strtoupper(substr($user->username, 0, 2)) }}
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $user->username }}</div>
                                                        <div class="text-xs text-gray-500">ID: {{ $user->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->phone_number ?: 'Not provided' }}</div>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium shadow-sm
                                                    @if($user->role === 'admin') bg-yellow-100 text-yellow-800 border border-yellow-200
                                                    @else bg-green-100 text-green-800 border border-green-200
                                                    @endif">
                                                    @if($user->role === 'admin') 👑
                                                    @else 👤
                                                    @endif
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex items-center">
                                                    <i class="fas fa-clock mr-1 text-gray-400"></i>
                                                    {{ $user->created_at->format('M d, Y') }}
                                                </div>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                <div class="flex flex-col sm:flex-row gap-2">
                                                    @if($user->role === 'admin')
                                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                           class="inline-flex items-center px-3 py-2 border border-yellow-400 text-yellow-700 rounded-lg bg-yellow-50 hover:bg-yellow-100 hover:border-yellow-500 focus:ring-2 focus:ring-yellow-400 transition-all duration-200 text-xs">
                                                            <i class="fas fa-edit mr-1"></i> Edit
                                                        </a>
                                                        @if($user->id !== auth()->id())
                                                            <button onclick="confirmDelete({{ $user->id }}, '{{ $user->username }}')" 
                                                                    class="inline-flex items-center px-3 py-2 border border-red-300 text-red-700 rounded-lg bg-red-50 hover:bg-red-100 hover:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 text-xs">
                                                                <i class="fas fa-trash mr-1"></i> Delete
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button onclick="viewCustomerProfile({{ $user->id }}, '{{ $user->username }}', '{{ $user->email }}', '{{ $user->phone_number }}', '{{ $user->created_at->format('M d, Y') }}', '{{ $user->role }}')" 
                                                                class="inline-flex items-center px-3 py-2 border border-blue-300 text-blue-700 rounded-lg bg-blue-50 hover:bg-blue-100 hover:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 text-xs">
                                                            <i class="fas fa-eye mr-1"></i> View
                                                        </button>
                                                    @endif
                                                </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto h-16 w-16 text-gray-400 mb-4">
                                <i class="fas fa-users text-5xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                            <p class="text-sm text-gray-500 max-w-md mx-auto">
                                @if(request('search'))
                                    No users match your search criteria. Try adjusting your search terms.
                                @else
                                    There are no registered users yet.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center transition-opacity duration-300">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 border-t-4 border-yellow-500 shadow-2xl animate-fade-in">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Confirm Delete</h3>
            </div>
            <p class="text-gray-600 mb-6">Are you sure you want to delete user <span id="deleteUserName" class="font-semibold text-yellow-700"></span>? This action cannot be undone.</p>
            <div class="flex justify-end gap-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-yellow-400 transition-all duration-200">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-400 transition-all duration-200">
                        Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Customer Profile Modal -->
    <div id="customerProfileModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center transition-opacity duration-300">
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full mx-4 border-t-4 border-yellow-500 shadow-2xl animate-fade-in">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="h-14 w-14 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-500 flex items-center justify-center text-white font-bold text-2xl shadow mr-3">
                        <span id="customerInitials"></span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-yellow-700" id="customerName"></h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs text-gray-400" id="customerJoined"></span>
                            <span class="text-xs text-gray-400">|</span>
                            <span class="text-xs text-gray-400">ID: <span id="customerId"></span></span>
                        </div>
                        <span id="customerRole" class="inline-block mt-2 px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-300"></span>
                    </div>
                </div>
                <button onclick="closeCustomerProfileModal()" class="text-gray-400 hover:text-yellow-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <i class="fas fa-envelope text-yellow-500"></i>
                    <span class="text-gray-800 text-sm" id="customerEmail"></span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-phone text-yellow-500"></i>
                    <span class="text-gray-800 text-sm" id="customerPhone"></span>
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <button onclick="closeCustomerProfileModal()" class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-400 transition-all duration-200 font-semibold">
                    Close
                </button>
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

        .user-card.hidden, .user-row.hidden {
            display: none !important;
        }

        .view-active {
            background-color: rgb(254 243 199) !important;
            color: rgb(161 98 7) !important;
        }
    </style>

    <script>
        // View toggle functionality
        document.getElementById('gridView').addEventListener('click', function() {
            document.getElementById('gridViewContainer').classList.remove('hidden');
            document.getElementById('listViewContainer').classList.add('hidden');
            document.getElementById('gridView').classList.add('view-active');
            document.getElementById('listView').classList.remove('view-active');
        });

        document.getElementById('listView').addEventListener('click', function() {
            document.getElementById('gridViewContainer').classList.add('hidden');
            document.getElementById('listViewContainer').classList.remove('hidden');
            document.getElementById('listView').classList.add('view-active');
            document.getElementById('gridView').classList.remove('view-active');
        });

        // Filter functionality
        document.getElementById('roleFilter').addEventListener('change', function() {
            const selectedRole = this.value;
            const userCards = document.querySelectorAll('.user-card');
            const userRows = document.querySelectorAll('.user-row');

            userCards.forEach(card => {
                if (selectedRole === '' || card.dataset.role === selectedRole) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });

            userRows.forEach(row => {
                if (selectedRole === '' || row.dataset.role === selectedRole) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        });

        // Sort functionality
        document.getElementById('sortBy').addEventListener('change', function() {
            const sortBy = this.value;
            const container = document.getElementById('gridViewContainer');
            const cards = Array.from(container.children);

            cards.sort((a, b) => {
                let aValue, bValue;

                switch(sortBy) {
                    case 'name':
                        aValue = a.querySelector('h3').textContent.toLowerCase();
                        bValue = b.querySelector('h3').textContent.toLowerCase();
                        break;
                    case 'role':
                        aValue = a.dataset.role;
                        bValue = b.dataset.role;
                        break;
                    case 'date':
                        aValue = new Date(a.querySelector('.text-gray-700').textContent);
                        bValue = new Date(b.querySelector('.text-gray-700').textContent);
                        break;
                    default:
                        return 0;
                }

                if (aValue < bValue) return -1;
                if (aValue > bValue) return 1;
                return 0;
            });

            cards.forEach(card => container.appendChild(card));
        });

        // Delete modal functionality
        function confirmDelete(userId, userName) {
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteForm').action = `/admin/users/${userId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Customer profile modal functionality
        function viewCustomerProfile(id, username, email, phone, joined, role = 'Customer') {
            // Set modal content
            document.getElementById('customerName').textContent = username;
            document.getElementById('customerEmail').textContent = email;
            document.getElementById('customerPhone').textContent = phone;
            document.getElementById('customerJoined').textContent = joined;
            document.getElementById('customerId').textContent = id;
            document.getElementById('customerRole').textContent = role.charAt(0).toUpperCase() + role.slice(1);
            // Generate initials from username
            const initials = username.split(' ').map(name => name.charAt(0)).join('').toUpperCase();
            document.getElementById('customerInitials').textContent = initials;
            // Show modal
            document.getElementById('customerProfileModal').classList.remove('hidden');
        }

        function closeCustomerProfileModal() {
            document.getElementById('customerProfileModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close customer profile modal when clicking outside
        document.getElementById('customerProfileModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCustomerProfileModal();
            }
        });

        // Initialize view
        document.getElementById('gridView').classList.add('view-active');

        // Add hover effects for better interactivity
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.user-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</x-dashboard-layout>
