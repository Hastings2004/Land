<x-dashboard-layout>
<a href="{{ route('customer.dashboard') }}" class="inline-block mb-4 px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"><i class="fas fa-arrow-left mr-2"></i>Back</a>
<div class="max-w-5xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">
        <i class="fas fa-home text-red-500"></i> My Purchased Plots
    </h1>
    @if($purchasedPlots->isEmpty())
        <div class="bg-white rounded-xl shadow p-8 text-center">
            <i class="fas fa-home text-red-200 text-6xl mb-4"></i>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">No Purchases Yet</h2>
            <p class="text-gray-500 mb-4">You haven't purchased any plots yet. When you buy a plot, it will appear here.</p>
            <a href="{{ route('customer.plots.index') }}" class="inline-block px-6 py-3 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition">Browse Plots</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($purchasedPlots as $plot)
                <div class="bg-white rounded-xl shadow p-6 border border-red-100 flex flex-col gap-2">
                    <div class="flex items-center gap-4 mb-2">
                        <i class="fas fa-home text-red-500 text-2xl"></i>
                        <span class="text-lg font-bold text-gray-800">{{ $plot->title }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <i class="fas fa-map-marker-alt text-yellow-500"></i> {{ $plot->location }}
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <i class="fas fa-ruler-combined text-yellow-500"></i> {{ number_format($plot->area_sqm, 2) }} sqm
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <i class="fas fa-calendar-check text-green-500"></i> Purchased: <span class="ml-1">{{ $plot->updated_at ? $plot->updated_at->format('M d, Y') : '-' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-800 font-bold mt-2">
                        <i class="fas fa-money-bill-wave text-green-600"></i> MWK {{ number_format($plot->price) }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</x-dashboard-layout> 