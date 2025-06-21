<x-dashboard-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Inquiry #{{ $inquiry->id }}</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
            <h2 class="text-2xl font-bold mb-4">Inquiry Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Name</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $inquiry->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $inquiry->email }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Phone</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $inquiry->phone ?? 'Not provided' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Submitted</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $inquiry->created_at->format('M d, Y') }}</p>
                </div>
                @if($inquiry->plot)
                <div class="md:col-span-2">
                    <p class="text-sm font-medium text-gray-500">Regarding Plot</p>
                    <p class="text-lg font-semibold text-gray-800">
                        <a href="{{ route('plots.show', $inquiry->plot->id) }}" class="text-yellow-600 hover:underline">{{ $inquiry->plot->title }}</a>
                    </p>
                </div>
                @endif
                <div class="md:col-span-2">
                    <p class="text-sm font-medium text-gray-500">Message</p>
                    <p class="text-gray-700 mt-1 whitespace-pre-wrap">{{ $inquiry->message }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Update Status</h2>
            <form action="{{ route('inquiries.update', $inquiry->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                        <option value="new" {{ $inquiry->status === 'new' ? 'selected' : '' }}>New</option>
                        <option value="viewed" {{ $inquiry->status === 'viewed' ? 'selected' : '' }}>Viewed</option>
                        <option value="responded" {{ $inquiry->status === 'responded' ? 'selected' : '' }}>Responded</option>
                        <option value="closed" {{ $inquiry->status === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 font-semibold text-xs uppercase">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
