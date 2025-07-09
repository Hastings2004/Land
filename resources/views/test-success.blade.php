<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Message Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Success Message Test</h1>
        
        <!-- Test Success Message Component -->
        <x-success-message />
        
        <!-- Test Logout Success Message Component -->
        <x-logout-success-message />
        
        <!-- Debug Info -->
        <div class="mt-6 p-4 bg-gray-100 rounded">
            <h3 class="font-semibold mb-2">Debug Info:</h3>
            <p><strong>Session Success:</strong> {{ session('success') ?? 'No success message' }}</p>
            <p><strong>Session ID:</strong> {{ session()->getId() }}</p>
            <p><strong>All Session Data:</strong> {{ json_encode(session()->all()) }}</p>
        </div>
        
        <!-- Test Buttons -->
        <div class="mt-6 space-y-2">
            <a href="/test-success" class="block w-full bg-green-500 text-white text-center py-2 rounded hover:bg-green-600">
                Test Regular Success
            </a>
            <a href="/test-logout-success" class="block w-full bg-blue-500 text-white text-center py-2 rounded hover:bg-blue-600">
                Test Logout Success
            </a>
            <a href="/debug-success" class="block w-full bg-gray-500 text-white text-center py-2 rounded hover:bg-gray-600">
                Debug Session
            </a>
        </div>
    </div>
</body>
</html> 