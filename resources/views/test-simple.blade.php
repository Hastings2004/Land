<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Success Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Simple Success Test</h1>
        
        <!-- Direct session check -->
        <div class="mb-4 p-4 bg-blue-100 rounded">
            <h3 class="font-semibold mb-2">Session Debug:</h3>
            <p><strong>Success Message:</strong> "{{ session('success') ?? 'NO SUCCESS MESSAGE' }}"</p>
            <p><strong>Session ID:</strong> {{ session()->getId() }}</p>
            <p><strong>All Session:</strong> {{ json_encode(session()->all()) }}</p>
        </div>
        
        <!-- Test Success Message Component -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 rounded">
                <h3 class="font-semibold mb-2">Success Message Found:</h3>
                <p>{{ session('success') }}</p>
            </div>
        @else
            <div class="mb-4 p-4 bg-red-100 border border-red-400 rounded">
                <h3 class="font-semibold mb-2">No Success Message:</h3>
                <p>No success message in session</p>
            </div>
        @endif
        
        <!-- Test Buttons -->
        <div class="space-y-2">
            <a href="/test-success" class="block w-full bg-green-500 text-white text-center py-2 rounded hover:bg-green-600">
                Set Success Message
            </a>
            <a href="/test-logout-success" class="block w-full bg-blue-500 text-white text-center py-2 rounded hover:bg-blue-600">
                Set Logout Success Message
            </a>
            <a href="/test-redirect-success" class="block w-full bg-purple-500 text-white text-center py-2 rounded hover:bg-purple-600">
                Test Redirect with Success
            </a>
            <a href="/test-url-success" class="block w-full bg-indigo-500 text-white text-center py-2 rounded hover:bg-indigo-600">
                Test URL Parameter Success
            </a>
            <a href="/test-simple" class="block w-full bg-gray-500 text-white text-center py-2 rounded hover:bg-gray-600">
                Refresh This Page
            </a>
        </div>
        
        <!-- Test setting success message directly -->
        <form method="POST" action="/test-set-success" class="mt-4">
            @csrf
            <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">
                Set Success Message (POST)
            </button>
        </form>
    </div>
</body>
</html> 