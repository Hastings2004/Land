@if(session('success'))
    <!-- DEBUG: Success message component loaded -->
    <!-- Session success: {{ session('success') }} -->
    <!-- Session ID: {{ session()->getId() }} -->
    <!-- All session data: {{ json_encode(session()->all()) }} -->
    <div id="success-message" class="fixed top-4 right-4 z-50 max-w-sm w-full transform transition-all duration-500 ease-in-out opacity-0 translate-x-full">
        <div class="bg-green-600 p-6 rounded-2xl shadow-2xl relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-gradient-to-br from-green-300/20 to-transparent"></div>
            <div class="absolute top-0 right-0 w-20 h-20 bg-green-300/10 rounded-full -translate-y-10 translate-x-10"></div>
            <div class="absolute bottom-0 left-0 w-16 h-16 bg-green-300/10 rounded-full translate-y-8 -translate-x-8"></div>
            
            <!-- Content -->
            <div class="relative z-10">
                <div class="flex items-start space-x-4">
                    <!-- Success Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center animate-pulse">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Message Content -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-white mb-1">Success!</h3>
                        <p class="text-white text-sm leading-relaxed">{{ session('success') }}</p>
                    </div>
                    
                    <!-- Close Button -->
                    <button onclick="dismissSuccessMessage()" class="flex-shrink-0 w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-200 group">
                        <svg class="w-4 h-4 text-white group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Progress Bar -->
                <div class="mt-4 relative">
                    <div class="w-full bg-white/20 rounded-full h-1">
                        <div id="progress-bar" class="bg-white h-1 rounded-full transition-all duration-100 ease-linear" style="width: 100%"></div>
                    </div>
                </div>
            </div>
            
            <!-- Decorative Elements -->
            <div class="absolute top-2 right-2">
                <div class="w-2 h-2 bg-white/30 rounded-full animate-ping"></div>
            </div>
        </div>
    </div>

    <script>
        console.log('Success message script loaded');
        console.log('Success message element:', document.getElementById('success-message'));
        console.log('Success message content:', '{{ session('success') }}');
        
        // Show the message with animation
        setTimeout(() => {
            const message = document.getElementById('success-message');
            console.log('Attempting to show message:', message);
            if (message) {
                message.classList.remove('opacity-0', 'translate-x-full');
                message.classList.add('opacity-100', 'translate-x-0');
                console.log('Message should now be visible');
            } else {
                console.error('Success message element not found!');
            }
        }, 100);

        // Auto-dismiss functionality
        let timeLeft = 3000; // 3 seconds
        const progressBar = document.getElementById('progress-bar');
        const interval = setInterval(() => {
            timeLeft -= 50; // Update every 50ms for smooth animation
            const progress = (timeLeft / 3000) * 100;
            progressBar.style.width = progress + '%';
            
            if (timeLeft <= 0) {
                clearInterval(interval);
                dismissSuccessMessage();
            }
        }, 50);

        // Manual dismiss function
        function dismissSuccessMessage() {
            const message = document.getElementById('success-message');
            message.classList.add('opacity-0', 'translate-x-full');
            message.classList.remove('opacity-100', 'translate-x-0');
            
            setTimeout(() => {
                message.remove();
            }, 500);
        }

        // Add hover pause functionality
        const message = document.getElementById('success-message');
        let isPaused = false;
        let originalInterval;

        message.addEventListener('mouseenter', () => {
            isPaused = true;
            clearInterval(interval);
        });

        message.addEventListener('mouseleave', () => {
            isPaused = false;
            // Restart the countdown with remaining time
            const remainingProgress = parseFloat(progressBar.style.width);
            const remainingTime = (remainingProgress / 100) * 3000;
            
            const newInterval = setInterval(() => {
                if (!isPaused) {
                    timeLeft -= 50;
                    const progress = (timeLeft / 3000) * 100;
                    progressBar.style.width = progress + '%';
                    
                    if (timeLeft <= 0) {
                        clearInterval(newInterval);
                        dismissSuccessMessage();
                    }
                }
            }, 50);
        });
    </script>
@endif

<!-- Alternative: Show success message from URL parameter -->
<script>
    // Check for success message in URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    
    if (successParam) {
        showSuccessMessage(decodeURIComponent(successParam));
    }
    
    function showSuccessMessage(message) {
        // Create success message element
        const successDiv = document.createElement('div');
        successDiv.id = 'url-success-message';
        successDiv.className = 'fixed top-4 right-4 z-50 max-w-sm w-full transform transition-all duration-500 ease-in-out opacity-0 translate-x-full';
        successDiv.innerHTML = `
            <div class="bg-gradient-to-r from-green-400 to-green-500 rounded-2xl shadow-2xl border border-green-300 p-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-green-300/20 to-transparent"></div>
                <div class="absolute top-0 right-0 w-20 h-20 bg-green-300/10 rounded-full -translate-y-10 translate-x-10"></div>
                <div class="absolute bottom-0 left-0 w-16 h-16 bg-green-300/10 rounded-full translate-y-8 -translate-x-8"></div>
                
                <div class="relative z-10">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center animate-pulse">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-white mb-1">Success!</h3>
                            <p class="text-green-100 text-sm leading-relaxed">${message}</p>
                        </div>
                        
                        <button onclick="dismissUrlSuccessMessage()" class="flex-shrink-0 w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-200 group">
                            <svg class="w-4 h-4 text-white group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mt-4 relative">
                        <div class="w-full bg-white/20 rounded-full h-1">
                            <div id="url-progress-bar" class="bg-white h-1 rounded-full transition-all duration-100 ease-linear" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="absolute top-2 right-2">
                    <div class="w-2 h-2 bg-white/30 rounded-full animate-ping"></div>
                </div>
            </div>
        `;
        
        document.body.appendChild(successDiv);
        
        // Show the message
        setTimeout(() => {
            successDiv.classList.remove('opacity-0', 'translate-x-full');
            successDiv.classList.add('opacity-100', 'translate-x-0');
        }, 100);
        
        // Auto-dismiss
        let timeLeft = 3000;
        const progressBar = document.getElementById('url-progress-bar');
        const interval = setInterval(() => {
            timeLeft -= 50;
            const progress = (timeLeft / 3000) * 100;
            progressBar.style.width = progress + '%';
            
            if (timeLeft <= 0) {
                clearInterval(interval);
                dismissUrlSuccessMessage();
            }
        }, 50);
    }
    
    function dismissUrlSuccessMessage() {
        const message = document.getElementById('url-success-message');
        if (message) {
            message.classList.add('opacity-0', 'translate-x-full');
            message.classList.remove('opacity-100', 'translate-x-0');
            
            setTimeout(() => {
                message.remove();
            }, 500);
        }
    }
</script> 