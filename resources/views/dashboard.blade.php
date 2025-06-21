<x-dashboard-layout>
            {{-- Conditional rendering of content based on activeView --}}

            {{-- Admin Views --}}
            @if(auth()->check() && auth()->user()->isAdmin())
                @if(isset($activeView) && $activeView === 'admin_plots_index')
                    <h2 class="text-3xl font-bold mb-6 text-gray-900 dark:text-gray-100">Manage Plots (Admin)</h2>
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('dashboard', ['viewType' => 'admin', 'id' => 'plots/create']) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Add New Plot
                        </a>
                    </div>
                    <div class="p-6 rounded-xl shadow-lg">
                        @if (session('success'))
                            @php $message = session('success'); @endphp {{-- Assign session value to a variable --}}
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ $message }}</span>
                            </div>
                        @endif
                        @if ($plots->isEmpty())
                            <div class="alert bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative">No plots found for administration.</div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Area (sqm)</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">New Listing</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($Plots as $plot)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $plot->title }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${{ number_format($plot->price, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ number_format($plot->area_sqm, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $plot->location }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ ucfirst($plot->status) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $plot->is_new_listing ? 'Yes' : 'No' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('dashboard', ['viewType' => 'admin', 'id' => 'plots/' . $plot->id]) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 mr-2">View</a>
                                                    <a href="{{ route('dashboard', ['viewType' => 'admin', 'id' => 'plots/' . $plot->id . '/edit']) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-200 mr-2">Edit</a>
                                                    <form action="{{ route('admin.plots.destroy', $plot->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200" onclick="return confirm('Are you sure you want to delete this plot?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $Plots->links() }}
                            </div>
                        @endif
                    </div>

                
                @elseif(isset($activeView) && $activeView === 'admin_plots_edit')
                    
                @elseif(isset($activeView) && $activeView === 'admin_plots_show')
                    <h2 class="text-3xl font-bold mb-6 text-gray-900 dark:text-gray-100">Plot Details (Admin) - {{ $plot->title }}</h2>
                    <div class="p-6 rounded-xl shadow-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="col-span-2"><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Title:</strong> {{ $plot->title }}</p></div>
                            <div class="col-span-2"><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Description:</strong></p><p class="text-gray-900 dark:text-gray-100 mt-1">{{ $plot->description }}</p></div>
                            <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Price:</strong> ${{ number_format($plot->price, 2) }}</p></div>
                            <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Area:</strong> {{ number_format($plot->area_sqm, 2) }} sqm</p></div>
                            <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Location:</strong> {{ $plot->location }}</p></div>
                            <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Status:</strong> {{ ucfirst($plot->status) }}</p></div>
                            <div><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>New Listing:</strong> {{ $plot->is_new_listing ? 'Yes' : 'No' }}</p></div>
                            <div class="col-span-2"><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Created At:</strong> {{ $plot->created_at->format('M d, Y H:i A') }}</p></div>
                            <div class="col-span-2"><p class="text-sm font-medium text-gray-700 dark:text-gray-300"><strong>Last Updated:</strong> {{ $plot->updated_at->format('M d, Y H:i A') }}</p></div>
                        </div>
                        <div class="mt-6 flex justify-start">
                            <a href="{{ route('dashboard', ['viewType' => 'admin', 'id' => 'plots/' . $plot->id . '/edit']) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mr-2">Edit</a>
                            <a href="{{ route('dashboard', ['viewType' => 'admin', 'id' => 'plots']) }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">Back to List</a>
                        </div>
                    </div>
                @else {{-- Customer Views (or default if not admin) --}}
                              @endif
            @endif
        </main>
    </div>

</x-dashboard-layout>   