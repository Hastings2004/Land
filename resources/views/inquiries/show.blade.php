<x-dashboard-layout>
    <div class="max-w-4xl mx-ato py-12 px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-extrabold mb-8 tracking-tight" style="font-family: 'Fira Sans', 'Segoe UI', Arial, sans-serif; color: #facc15;">
            Inquiry Details
        </h2>
        <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@700&display=swap" rel="stylesheet">

        <div class="p-8 rounded-2xl shadow-2xl border border-gray-300"
             style="background: #fff; font-family: 'Fira Sans', 'Segoe UI', Arial, sans-serif;">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
            <span class="block text-base font-medium mb-1" style="color:#23272f;">Inquirer Name</span>
            <p class="text-lg font-semibold" style="color: #23272f;">{{ $inquiry->name }}</p>
            </div>
            <div>
            <span class="block text-base font-medium mb-1" style="color: #23272f;">Email</span>
            <p class="text-lg font-semibold" style="color: #23272f;">{{ $inquiry->email }}</p>
            </div>
            @if($inquiry->phone)
            <div>
            <span class="block text-base font-medium mb-1" style="color: #23272f;">Phone</span>
            <p class="text-lg font-semibold" style="color: #23272f;">
                @php
                    // Format phone to Malawi standard: +265 9xx xxx xxx or +265 1 xxx xxx
                    $phone = preg_replace('/\D/', '', $inquiry->phone); // Remove non-digits
                    if (Str::startsWith($phone, '0')) {
                        $phone = '+265 ' . substr($phone, 1);
                    } elseif (Str::startsWith($phone, '265')) {
                        $phone = '+265 ' . substr($phone, 3);
                    } elseif (!Str::startsWith($phone, '+265')) {
                        $phone = '+265 ' . $phone;
                    }
                    // Add spacing for readability
                    $formatted = preg_replace('/^(\+265)(\d{1,3})(\d{3})(\d{3})$/', '$1 $2 $3 $4', str_replace(' ', '', $phone));
                @endphp
                {{ $formatted ?? $phone }}
            </p>
            </div>
            @endif
            @if($inquiry->plot)
            <div>
            <span class="block text-base font-medium mb-1" style="color: #23272f;">Regarding Plot</span>
            <p>
                <a href="{{ route('plots.show', $inquiry->plot) }}"
                   class="font-semibold transition"
                   style="color: #00bfae; text-decoration: underline dotted;">
                View: {{ $inquiry->plot->title }}
                </a>
            </p>
            </div>
            @endif
            <div>
            <span class="block text-base font-medium mb-1" style="color: #23272f;">Status</span>
            <span class="px-4 py-1 inline-flex text-sm leading-5 font-semibold rounded-full"
            style="
                @if($inquiry->status == 'new')
                background: #facc15; /* yellow */
                color: #23272f;
                box-shadow: 0 2px 8px rgba(250, 204, 21, 0.15);
                border: 2px solid #facc15;
                letter-spacing: 1px;
                @elseif($inquiry->status == 'viewed')
                background: #fff3cd; color: #23272f;
                @elseif($inquiry->status == 'responded')
                background: #b2f2e5; color: #23272f;
                @else
                background: #f3e8ff; color: #256cfa;
                @endif
                padding-left: 1rem; padding-right: 1rem;
                padding-top: 0.25rem; padding-bottom: 0.25rem;
                border-radius: 1rem;
                font-weight: bold;
                font-family: 'Fira Sans', 'Segoe UI', Arial, sans-serif;
                font-size: 1rem;
                display: inline-block;
            ">
            {{ ucfirst($inquiry->status) }}
            </span>
            </div>
            <div>
            <span class="block text-base font-medium mb-1" style="color: #23272f;">Received On</span>
            <p class="text-lg font-semibold" style="color: #23272f;">
                {{ now()->setTimezone('Africa/Blantyre')->format('F d, Y h:i A') }} (Malawi)
            </p>
            </div>
            </div>

            <div class="mt-8 border-t pt-8 border-gray-300">
            <span class="block text-base font-medium mb-2" style="color: #23272fc;">Message</span>
            <p class="text-lg leading-relaxed whitespace-pre-line" style="color: #23272f;">{{ $inquiry->message }}</p>
            </div>

            <div class="mt-10 flex flex-wrap gap-4 pt-6 border-t border-gray-300">
                <!-- Edit: Teal for a modern, appealing primary action -->
                <a href="{{ route('inquiries.edit', $inquiry) }}"
                   class="px-6 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 transition font-semibold">
                    Edit Inquiry
                </a>
                <!-- Delete: Red for clear destructive action -->
                <form action="{{ route('inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-6 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-2 transition font-semibold">
                        Delete Inquiry
                    </button>
                </form>
                <!-- Back: Slate for a neutral, modern secondary action -->
                <a href="{{ route('inquiries.index') }}"
                   class="px-6 py-2 bg-yellow-400 text-white rounded-lg shadow hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 transition font-semibold">
                    Back to List
                </a>
            </div>
        </div>
    </div>
</x-dashboard-layout>
