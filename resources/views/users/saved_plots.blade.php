<x-dashboard-layout>
    <h1 class="text-3xl font-bold mb-6">My Saved Plots</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('info'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('info') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto bg-white p-6 rounded-xl shadow-lg">
        @if($savedPlots->isEmpty())
            <p class="text-gray-600">You haven't saved any plots yet.</p>
        @else
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-bold text-gray-700 uppercase">Plot Title</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-bold text-gray-700 uppercase">Location</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-bold text-gray-700 uppercase">Price</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm font-bold text-gray-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($savedPlots as $plot)
                        <tr>
                            <td class="px-6 py-4 border-b">{{ $plot->title }}</td>
                            <td class="px-6 py-4 border-b">{{ $plot->location }}</td>
                            <td class="px-6 py-4 border-b">${{ number_format($plot->price, 2) }}</td>
                            <td class="px-6 py-4 border-b text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('customer.plots.show', $plot->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 font-semibold text-xs uppercase">View</a>
                                    <form action="{{ route('saved-plots.destroy', $plot->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold text-xs uppercase">Unsave</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-6">
                {{ $savedPlots->links() }}
            </div>
        @endif
    </div>
</x-dashboard-layout>
