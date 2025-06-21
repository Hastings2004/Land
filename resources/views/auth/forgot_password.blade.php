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
        <h3 class="text-yellow-500 text-2xl font-semibold mb-6 text-center">RESET PASSWORD</h3>

        <!-- Login form starts here -->
        <form action="{{ route('password.request') }}" method="post">
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

            

            <!-- Reset button -->
            <div>
                <button
                    type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out"
                >
                    Submit
                </button>
            </div>
            {{-- session message --}}
            @if (session('status'))
                <p style="color: green; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 8px 12px; border-radius: 4px; margin-top: 12px; text-align: center;">
                    {{ session('status') }}
                </p>
            @endif
        </form>

    

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
