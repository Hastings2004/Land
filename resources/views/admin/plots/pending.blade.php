<x-dashboard-layout>
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Pending Plot Approvals</h1>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if($plots->isEmpty())
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">No pending plots for approval.</div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 rounded shadow">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Area (sqm)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plots as $plot)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plot->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">K{{ number_format($plot->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($plot->area_sqm, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $plot->location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                <form action="{{ route('plots.approve', $plot->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">Approve</button>
                                </form>
                                <form action="{{ route('plots.reject', $plot->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $plots->links() }}</div>
    @endif
</div>
</x-dashboard-layout> 