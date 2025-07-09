<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{env(key: 'APP_NAME')}}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(entrypoints: ['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-whitesmoke-100">
    <!-- Logout Success Message Component -->
    <x-logout-success-message />
    
    <main>
        {{ $slot }}
    </main>

    <footer class="fixed bottom-0 left-0 w-full bg-white shadow">
        <div class="text-center text-gray-500 text-sm py-4">
            &copy; {{ date('Y') }} Atsogo Estate Agency. All rights reserved.
        </div>
    </footer>
    <!-- Alpine.js loaded last for reliability -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js test block for troubleshooting -->
    <div style="position:fixed;bottom:2rem;right:2rem;z-index:9999;">
      <div x-data="{ open: false }" class="hidden md:block">
        <div x-show="open" x-cloak class="mt-2 p-4 bg-yellow-100 rounded shadow">Alpine.js is working!</div>
      </div>
    </div>
</body>
</html>