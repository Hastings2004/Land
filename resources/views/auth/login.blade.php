<x-layout>
    <head>
        <!-- Tailwind CSS CDN: Essential for styling -->
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            /* Optional: Apply Inter font globally for a modern look */
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>

        <!-- Font Awesome CSS: Crucial for displaying the icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5KwDFWJ8pcyqqQpNPjNpXH7P2jJ/6hOtyWpNKx/bywM+bQUIPTfMfw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <!-- Main container for the login form, centered on the page and styled -->
    <div class="max-w-md mx-auto p-8 bg-white shadow-md rounded-lg mt-20">
                        <!-- Login page title -->
        <h3 class="text-yellow-500 text-2xl font-semibold mb-6 text-center">ATSOGO LOGIN PAGE</h3>

        <!-- Login form starts here -->
        <form action="{{ route('login') }}" method="post">
            <!-- CSRF token for security (Laravel specific) -->
            @csrf



            <!-- Email Input Field with Icon -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <!-- Input container for relative positioning of icon -->
                <div class="relative">
                    <!-- Email input field -->
                    <input
                        type="text"
                        id="email"
                        class="input @error('email') ring-red-500 @enderror shadow appearance-none border rounded w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-yellow-400 transition duration-200 ease-in-out"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                    >
                    <!-- Email icon using Font Awesome -->
                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <!-- Error message for email validation -->
                @error('email') <p class="text-red-500 text-sm italic mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Password Input Field with Icon and Show/Hide Toggle -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <!-- Input container for relative positioning of icon and toggle -->
                <div class="relative">
                    <!-- Password input field -->
                    <input
                        type="password"
                        id="password"
                        class="input @error('password') ring-red-500 @enderror shadow appearance-none border rounded w-full py-2 pl-10 pr-10 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-yellow-400 transition duration-200 ease-in-out"
                        name="password"
                        placeholder="Enter your password"
                    >
                    <!-- Password icon using Font Awesome (left side) -->
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <!-- Show/Hide Password Toggle Icon (right side) -->
                    <i class="fas fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer" onclick="togglePasswordVisibility('password')"></i>
                </div>
                <!-- Error message for password validation -->
                @error('password') <p class="text-red-500 text-sm italic mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Remember me checkbox and Forgot password link -->
            <div class="remember flex items-center justify-between mb-6">
                {{-- This inner div uses flex to keep the checkbox and label on the same line --}}
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="form-checkbox h-4 w-4 text-yellow-500 rounded focus:ring-yellow-400">
                    <label for="remember" class="ml-2 text-gray-700 text-sm">Remember me</label>
                </div>
                <span class="text-sm">
                    <a href="{{ route('password.request') }}" class="text-yellow-500 hover:text-yellow-600 text-sm font-semibold">Forgot password?</a>
                </span>
            </div>

            <!-- Global error message for failed login attempts -->
            @error('failed')
                <p class="text-red-500 text-sm italic mb-4" style="color: #ef4444; font-size: 0.875rem; font-style: italic; margin-bottom: 1rem;">
                    {{ $message }}
                </p>
            @enderror

            <!-- Login button -->
            <div>
                <button
                    type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out"
                >
                    Login
                </button>
            </div>
            {{-- session message --}}
            @if (session('success'))
                <p style="color: green; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 8px 12px; border-radius: 4px; margin-top: 12px; text-align: center;">
                    {{ session('success') }}
                </p>
            @endif
        </form>

        {{-- "Don't have an account?" message and Sign up link --}}
        <div class="mt-6 text-center text-gray-700 text-sm">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-yellow-500 hover:text-yellow-600 font-bold">Sign up</a>
        </div>
    </div>

        {{-- JavaScript for password visibility toggle --}}
    <script>
        /**
         * Toggles the visibility of a password input field.
         * Changes the input type between 'password' and 'text' and updates the eye icon.
         * @param {string} inputId The ID of the password input field.
         */
        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            // This assumes the icon is the immediately next sibling of the input.
            // If structure changes, this selector might need adjustment.
            const toggleIcon = passwordInput.nextElementSibling;

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</x-layout>
