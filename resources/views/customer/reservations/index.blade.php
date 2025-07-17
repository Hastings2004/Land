<x-dashboard-layout>
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-yellow-300 rounded-lg shadow-sm hover:bg-yellow-50 hover:border-yellow-400 focus:ring-2 focus:ring-yellow-400 transition-all duration-200 text-yellow-600 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>
            Back
        </a>
    </div>
    <!-- Page Header -->
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-2xl shadow-xl mb-4 transform rotate-3 hover:rotate-0 transition-transform duration-300">
            <i class="fas fa-calendar-check text-yellow-500 text-xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">My Reservations</h1>
        <p class="text-gray-600">Track your land plot reservations</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['total'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Total Reservations</div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Active</div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['completed'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Completed</div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-thumbs-up text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-gray-600">{{ $stats['expired'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Expired</div>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hourglass-end text-gray-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</div>
                    <div class="text-gray-600 text-sm font-semibold">Cancelled</div>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Reservations List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-list text-yellow-500 mr-2"></i>
                My Active Reservations
            </h2>
        </div>
        @if($activeReservations->count() > 0)
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($activeReservations as $reservation)
                        @include('customer.reservations._reservation_card', ['reservation' => $reservation])
                    @endforeach
                </div>
            </div>
        @else
            <div class="p-6 text-center text-gray-500">No active reservations.</div>
        @endif
    </div>

    <!-- Sold (Completed) Reservations List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-check-circle text-blue-500 mr-2"></i>
                My Sold Plots
            </h2>
        </div>
        @if($soldReservations->count() > 0)
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($soldReservations as $reservation)
                        @include('customer.reservations._reservation_card', ['reservation' => $reservation])
                    @endforeach
                </div>
            </div>
        @else
            <div class="p-6 text-center text-gray-500">No sold plots yet.</div>
        @endif
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-bounce-in">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
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
    </style>

    <!-- PayChangu Script -->
    <script src="https://in.paychangu.com/js/popup.js"></script>
    <div id="wrapper"></div>

    <script>
        // Always use the correct port for local development
        const paychanguCallbackUrl = "http://127.0.0.1:8000/payments/callback";
        const paychanguReturnUrl = "http://127.0.0.1:8000/payments/success";
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
        });

        // Payment function that triggers PayChangu
        function makePayment(reservationId, amount, userEmail, userName) {
            // Disable the button to prevent double clicks
            const button = event.target;
            button.disabled = true;            
            // Generate a unique transaction reference
            const txRef = 'RES-' + reservationId + '-' + Date.now();
            
            PaychanguCheckout({
                "public_key": "PUB-TEST-PvuQhVa7NUDFOMJNfw5jgJZMC4ACs36Q",
                "tx_ref": txRef,
                "amount": amount,
                "currency": "MWK",
                "callback_url": paychanguCallbackUrl, // for backend POST
                "return_url": paychanguReturnUrl,     // for user redirect
                "customer": {
                    "email": userEmail,
                    "first_name": userName,
                    "last_name": "",
                },
                "customization": {
                    "title": "Plot Reservation Payment",
                    "description": "Payment for reservation #" + reservationId,
                },
                "meta": {
                    "reservation_id": reservationId,
                },
                "onSuccess": function(response) {
                    window.location.href = paychanguReturnUrl;
                },
                "onclose": function() {
                    button.disabled = false;
                    button.innerHTML = '<i class=\"fas fa-credit-card mr-2\"></i> Pay Now';
                }
            });
        }
    </script>
</x-dashboard-layout> 