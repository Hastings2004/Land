<x-dashboard-layout>
    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Inquiries</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white p-6 rounded-xl shadow-lg">
            @if($inquiries->isEmpty())
                <p class="text-gray-600">No inquiries found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-bold text-gray-700 uppercase">Name</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-bold text-gray-700 uppercase">Email</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-bold text-gray-700 uppercase">Status</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-bold text-gray-700 uppercase">Submitted</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm font-bold text-gray-700 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inquiries as $inquiry)
                                <tr>
                                    <td class="px-6 py-4 border-b">{{ $inquiry->name }}</td>
                                    <td class="px-6 py-4 border-b">{{ $inquiry->email }}</td>
                                    <td class="px-6 py-4 border-b">
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                            @switch($inquiry->status)
                                                @case('new') bg-blue-200 text-blue-800 @break
                                                @case('viewed') bg-yellow-200 text-yellow-800 @break
                                                @case('responded') bg-green-200 text-green-800 @break
                                                @case('closed') bg-gray-200 text-gray-800 @break
                                            @endswitch">
                                            {{ ucfirst($inquiry->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 border-b">{{ $inquiry->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 border-b text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('inquiries.show', $inquiry->id) }}" class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 font-semibold text-xs uppercase">View</a>
                                            @if(Auth::user()->isAdmin())
                                                <a href="{{ route('inquiries.edit', $inquiry->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 font-semibold text-xs uppercase">Edit</a>
                                                <form action="{{ route('inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold text-xs uppercase">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $inquiries->links() }}
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>
