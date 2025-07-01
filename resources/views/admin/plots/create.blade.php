<x-dashboard-layout>
    <h2 class="text-3xl font-extrabold mb-8 text-gray-700 dark:text-gray-100 text-center tracking-tight">Create New Plot (Admin)</h2>
    <div class="p-10 rounded-2xl shadow-2xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 max-w-2xl mx-auto">
        <form action="{{ route('plots.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="title" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-1">Title</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full h-12 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 dark:focus:border-yellow-400 dark:focus:ring-yellow-400 transition-all duration-200 px-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" placeholder="Enter plot title">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="description" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 dark:focus:border-yellow-400 dark:focus:ring-yellow-400 transition-all duration-200 px-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" placeholder="Describe the plot"></textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="price" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-1">Price</label>
                <input type="number" name="price" id="price" class="mt-1 block w-full h-12 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 dark:focus:border-yellow-400 dark:focus:ring-yellow-400 transition-all duration-200 px-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" placeholder="Enter price">
                @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="area_sqm" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-1">Area (sqm)</label>
                <input type="number" name="area_sqm" id="area_sqm" class="mt-1 block w-full h-12 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 dark:focus:border-yellow-400 dark:focus:ring-yellow-400 transition-all duration-200 px-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" placeholder="Enter area in sqm">
                @error('area_sqm')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="category" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-1">Category</label>
                <select name="category" id="category" class="mt-1 block w-full h-12 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 dark:focus:border-yellow-400 dark:focus:ring-yellow-400 transition-all duration-200 px-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    <option value="residential">Residential</option>
                    <option value="commercial">Commercial</option>
                    <option value="industrial">Industrial</option>
                </select>
                @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="location" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-1">Location</label>
                <input type="text" name="location" id="location" class="mt-1 block w-full h-12 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 dark:focus:border-yellow-400 dark:focus:ring-yellow-400 transition-all duration-200 px-4 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100" placeholder="Enter location">
                @error('location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="image" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-1">Plot Image</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 dark:focus:border-yellow-400 dark:focus:ring-yellow-400 transition-all duration-200">
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="is_new_listing" class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_new_listing" id="is_new_listing" class="mr-2 h-5 w-5 accent-yellow-500 focus:ring-2 focus:ring-yellow-400 transition-all duration-200">
                    <span class="text-base font-medium text-gray-700 dark:text-gray-300">New Listing</span>
                </label>
                @error('is_new_listing')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full px-6 py-3 bg-yellow-500 text-white font-bold rounded-lg shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-200 text-lg">Create Plot</button>
            </div>
        </form>
    </div>
</x-dashboard-layout>