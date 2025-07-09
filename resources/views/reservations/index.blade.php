<x-dashboard-layout>
    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">My Reservations</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white p-6 rounded-xl shadow-lg">
            @if($reservations->isEmpty())
                <p class="text-gray-600">You have no reservations.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-bold text-gray-700 uppercase">Plot</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-bold text-gray-700 uppercase">Status</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-bold text-gray-700 uppercase">Expires At</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm font-bold text-gray-700 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td class="px-6 py-4 border-b">
                                        <a href="{{ route('customer.plots.show', $reservation->plot->id) }}" class="text-yellow-600 hover:underline">{{ $reservation->plot->title }}</a>
                                    </td>
                                    <td class="px-6 py-4 border-b">
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                            @switch($reservation->status)
                                                @case('active') bg-green-200 text-green-800 @break
                                                @case('expired') bg-gray-200 text-gray-800 @break
                                                @case('cancelled') bg-red-200 text-red-800 @break
                                                @case('completed') bg-blue-200 text-blue-800 @break
                                            @endswitch">
                                            {{ ucfirst($reservation->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 border-b">
                                        @if($reservation->status === 'active')
                                            {{ $reservation->expires_at->diffForHumans() }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 border-b text-center">
                                        @if($reservation->status === 'active')
                                            <form action="{{ route('customer.reservations.destroy', $reservation->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold text-xs uppercase">Cancel</button>
                                            </form>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $reservations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout> 