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
    <!-- Main container for the signup form, centered on the page and styled -->
    <div class="max-w-md mx-auto p-8 bg-white shadow-md rounded-lg mt-20">
        <!-- Signup page title with consistent styling -->
        <h3 class="text-yellow-500 text-2xl font-semibold mb-6 text-center">ATSOGO SIGNUP PAGE</h3>

        <!-- Signup form starts here -->
        <form action="{{ route('register') }}" method="post">
            <!-- CSRF token for security (Laravel specific) -->
            @csrf

            <!-- Username Input Field with Icon -->
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <!-- Input container for relative positioning of icon -->
                <div class="relative">
                    <!-- Username input field -->
                    <input
                        type="text"
                        id="username"
                        class="input @error('username') ring-red-500 @enderror shadow appearance-none border rounded w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-yellow-400 transition duration-200 ease-in-out"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Enter your username"
                    >
                    <!-- Username icon using Font Awesome -->
                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <!-- Error message for username validation -->
                @error('username') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

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
                @error('email') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Phone Number Input Field with Icon -->
            <div class="mb-4">
                <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                <!-- Input container for relative positioning of icon -->
                <div class="relative">
                    <!-- Phone number input field -->
                    <input
                        type="text"
                        id="phone_number"
                        class="input @error('phone_number') ring-red-500 @enderror shadow appearance-none border rounded w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-yellow-400 transition duration-200 ease-in-out"
                        name="phone_number"
                        value="{{ old('phone_number') }}"
                        placeholder="Enter your phone number"
                    >
                    <!-- Phone icon using Font Awesome -->
                    <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <!-- Error message for phone number validation -->
                @error('phone_number') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Password Input Field with Icon and Show/Hide Toggle -->
            <div class="mb-4">
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
                @error('password') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Confirm Password Input Field with Icon and Show/Hide Toggle -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                <!-- Input container for relative positioning of icon and toggle -->
                <div class="relative">
                    <!-- Confirm password input field -->
                    <input
                        type="password"
                        id="password_confirmation"
                        class="input @error('password_confirmation') ring-red-500 @enderror shadow appearance-none border rounded w-full py-2 pl-10 pr-10 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-yellow-400 transition duration-200 ease-in-out"
                        name="password_confirmation"
                        placeholder="Confirm your password"
                    >
                    <!-- Confirm password icon using Font Awesome (left side) -->
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <!-- Show/Hide Password Toggle Icon (right side) -->
                    <i class="fas fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer" onclick="togglePasswordVisibility('password_confirmation')"></i>
                </div>
                <!-- Error message for confirm password validation -->
                @error('password_confirmation') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Register button -->
            <div>
                <button
                    type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out"
                >
                    Register
                </button>
            </div>
        </form>
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
