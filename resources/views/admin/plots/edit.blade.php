<x-dashboard-layout>
    <h2 class="text-3xl font-bold mb-6 text-gray-500 dark:text-black-100">Edit Plot (Admin)</h2>
    <div class="p-6 rounded-xl shadow-lg">
        {{-- Form action points to the update route, passing the plot ID --}}
        <form action="{{ route('plots.update', $plot) }}" method="POST">
            @csrf
            @method('PUT') {{-- Or @method('PATCH') --}}

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $plot->title) }}" required
                       class="mt-1 block w-full h-12 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" id="description" rows="3" required
                          class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">{{ old('description', $plot->description) }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                <input type="number" name="price" id="price" value="{{ old('price', $plot->price) }}" required
                       class="mt-1 block w-full h-12 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
                @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label for="area_sqm" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Area (sqm)</label>
                <input type="number" name="area_sqm" id="area_sqm" value="{{ old('area_sqm', $plot->area_sqm) }}" required
                       class="mt-1 block w-full h-12 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
                @error('area_sqm')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location', $plot->location) }}" required
                       class="mt-1 block w-full h-12 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
                @error('location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                <select name="status" id="status" required
                        class="mt-1 block w-full h-12 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
                    <option value="available" {{ old('status', $plot->status) == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="sold" {{ old('status', $plot->status) == 'sold' ? 'selected' : '' }}>Sold</option>
                </select>
                @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label for="is_new_listing" class="flex items-center">
                    <input type="checkbox" name="is_new_listing" id="is_new_listing" value="1"
                           {{ old('is_new_listing', $plot->is_new_listing) ? 'checked' : '' }}
                           class="mr-2 h-5 w-5">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">New Listing</span>
                </label>
                @error('is_new_listing')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mt-6 flex gap-4">
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500">Update Plot</button>
                <a href="{{ route('plots.show', $plot) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancel</a>
            </div>
        </form>
    </div>
</x-dashboard-layout>