<x-dashboard-layout>
    <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">Inquiry Management</h2>

    <div class="flex flex-col sm:flex-row mb-4 gap-4 items-center justify-between">
        <div class="w-full sm:w-auto">
            <form action="{{ route('inquiries.index') }}" method="GET" class="w-full">
                <div class="relative">
                    <input type="text" name="search"
                        class="w-full pl-10 pr-4 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-200 bg-white text-gray-900 placeholder-yellow-400"
                        placeholder="Search inquiries..."
                        value="{{ request('search') }}">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400"></i>
                </div>
            </form>
        </div>
        <div class="w-full sm:w-auto flex justify-end">
            <a href="{{ route('inquiries.create') }}"
            class="inline-flex items-center gap-2 px-7 py-2.5 bg-yellow-400 border-0 rounded-full font-semibold text-base text-white uppercase shadow-lg hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:ring-offset-2 transition-all duration-200"
            style="box-shadow: 0 4px 14px 0 rgba(251,191,36,0.18);"
            >
             <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
             </svg>
             Submit New Inquiry
            </a>
        </div>
    </div>

    <div class="p-6 rounded-xl shadow-lg bg-white :bg-gray-800">
        @if($inquiries->isEmpty())
            <div class="alert bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative">No inquiries found matching your criteria.</div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-xl shadow-lg">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 border-b border-r border-gray-300 bg-gradient-to-r from-yellow-100 to-yellow-200 text-left text-sm font-bold text-gray-700 uppercase tracking-wider first:rounded-tl-xl last:rounded-tr-xl">
                                Name
                            </th>
                            <th class="px-6 py-4 border-b border-r border-gray-300 bg-gradient-to-r from-yellow-100 to-yellow-200 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-4 border-b border-r border-gray-300 bg-gradient-to-r from-yellow-100 to-yellow-200 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 border-b border-r border-gray-300 bg-gradient-to-r from-yellow-100 to-yellow-200 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                Plot
                            </th>
                            <th class="px-6 py-4 border-b border-gray-300 bg-gradient-to-r from-yellow-100 to-yellow-200 text-center text-sm font-bold text-gray-700 uppercase tracking-wider last:rounded-tr-xl">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inquiries as $inquiry)
                            <tr class="hover:bg-yellow-50 transition">
                                <td class="px-6 py-4 border-b border-r border-gray-200 bg-white text-gray-900 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-yellow-200 rounded-full flex items-center justify-center text-lg font-bold text-yellow-700 mr-3">
                                            {{ strtoupper(substr($inquiry->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-base font-semibold">{{ $inquiry->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 border-b border-r border-gray-200 bg-white text-gray-700">
                                    {{ $inquiry->email }}
                                </td>
                                <td class="px-6 py-4 border-b border-r border-gray-200 bg-white">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow
                                        @if($inquiry->status == 'new')
                                            bg-blue-100 text-blue-800 border border-blue-300
                                        @elseif($inquiry->status == 'viewed')
                                            bg-yellow-100 text-yellow-800 border border-yellow-300
                                        @elseif($inquiry->status == 'responded')
                                            bg-green-100 text-green-800 border border-green-300
                                        @else
                                            bg-gray-100 text-gray-800 border border-gray-300
                                        @endif
                                    ">
                                        {{ ucfirst($inquiry->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 border-b border-r border-gray-200 bg-white text-gray-700">
                                    {{ $inquiry->plot->title ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 border-b border-gray-200 bg-white text-right space-x-2">
                                    <a href="{{ route('inquiries.show', $inquiry) }}"
                                       class="inline-block px-4 py-2 bg-green-500 text-white font-semibold rounded-lg shadow hover:bg-green-600 transition"
                                    >View</a>
                                    <a href="{{ route('inquiries.edit', $inquiry) }}"
                                       class="inline-block px-4 py-2 bg-yellow-400 text-white font-semibold rounded-lg shadow hover:bg-yellow-500 transition"
                                    >Edit</a>
                                    <form action="{{ route('inquiries.destroy', $inquiry) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-block px-4 py-2 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition"
                                        >Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
            <div class="mt-6 flex justify-center">
                {{ $inquiries->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-dashboard-layout>
