@if(session('success') && str_contains(strtolower(session('success')), 'logged out'))
    <!-- DEBUG: Logout success message component loaded -->
    <!-- Session success: {{ session('success') }} -->
    <div id="logout-success-message" class="fixed top-4 right-4 z-50 max-w-sm w-full transform transition-all duration-500 ease-in-out opacity-0 translate-x-full">
        <div class="bg-green-500 rounded-2xl shadow-2xl border border-green-600 p-6 relative">
            <div class="relative z-10">
                <div class="flex items-start space-x-4">
                    <!-- Logout Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Message Content -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-green-900 mb-1">Logged Out! 👋</h3>
                        <p class="text-white text-sm leading-relaxed">You have been logged out.</p>
                    </div>
                    <!-- Close Button -->
                    <button onclick="dismissLogoutMessage()" class="flex-shrink-0 w-8 h-8 bg-green-400 hover:bg-green-600 rounded-full flex items-center justify-center transition-all duration-200 group">
                        <svg class="w-4 h-4 text-green-900 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <!-- Progress Bar -->
                <div class="mt-4 relative">
                    <div class="w-full bg-green-400 rounded-full h-1">
                        <div id="logout-progress-bar" class="bg-white h-1 rounded-full transition-all duration-100 ease-linear" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show the logout message with animation
        setTimeout(() => {
            const message = document.getElementById('logout-success-message');
            if (message) {
                message.classList.remove('opacity-0', 'translate-x-full');
                message.classList.add('opacity-100', 'translate-x-0');
            }
        }, 100);

        // Auto-dismiss functionality for logout message
        let logoutTimeLeft = 4000; // 4 seconds for logout message
        const logoutProgressBar = document.getElementById('logout-progress-bar');
        const logoutInterval = setInterval(() => {
            logoutTimeLeft -= 50; // Update every 50ms for smooth animation
            const progress = (logoutTimeLeft / 4000) * 100;
            logoutProgressBar.style.width = progress + '%';
            if (logoutTimeLeft <= 0) {
                clearInterval(logoutInterval);
                dismissLogoutMessage();
            }
        }, 50);

        // Manual dismiss function for logout message
        function dismissLogoutMessage() {
            const message = document.getElementById('logout-success-message');
            message.classList.add('opacity-0', 'translate-x-full');
            message.classList.remove('opacity-100', 'translate-x-0');
            setTimeout(() => {
                message.remove();
            }, 500);
        }

        // Add hover pause functionality for logout message
        const logoutMessage = document.getElementById('logout-success-message');
        let logoutIsPaused = false;
        logoutMessage.addEventListener('mouseenter', () => {
            logoutIsPaused = true;
            clearInterval(logoutInterval);
        });
        logoutMessage.addEventListener('mouseleave', () => {
            logoutIsPaused = false;
            // Restart the countdown with remaining time
            const remainingProgress = parseFloat(logoutProgressBar.style.width);
            const remainingTime = (remainingProgress / 100) * 4000;
            const newLogoutInterval = setInterval(() => {
                if (!logoutIsPaused) {
                    logoutTimeLeft -= 50;
                    const progress = (logoutTimeLeft / 4000) * 100;
                    logoutProgressBar.style.width = progress + '%';
                    if (logoutTimeLeft <= 0) {
                        clearInterval(newLogoutInterval);
                        dismissLogoutMessage();
                    }
                }
            }, 50);
        });
    </script>
@endif 