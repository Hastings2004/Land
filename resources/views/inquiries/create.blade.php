<x-dashboard-layout> {{-- Assuming you have a guest layout for public pages --}}
    <div class="max-w-xl mx-auto py-8">
        <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white text-center">Send Us an Inquiry</h2>

        <div class="p-6 rounded-xl shadow-lg bg-white">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('inquiries.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-black mb-1">Your Name</label>
                    <input type="text" name="name" id="name" @if(old('name')) value="{{ old('name') }}" @endif required
                           class="mt-1 block w-full h-10 px-3 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-black">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-black mb-1">Your Email</label>
                    <input type="email" name="email" id="email" @if(old('email')) value="{{ old('email') }}" @endif required
                           class="mt-1 block w-full h-10 px-3 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-black">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-black mb-1">Phone (Malawi)</label>
                    <input type="text" name="phone" id="phone" @if(old('phone')) value="{{ old('phone') }}" @endif
                           pattern="^(?:\+265\d{9}|0\d{9})$"
                           title="Enter a valid Malawi phone number (e.g., +265991234567 or 0991234567)"
                           placeholder="e.g., +265991234567 or 0991234567"
                           class="mt-1 block w-full h-10 px-3 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-black">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-black mb-1">Your Message</label>
                    <textarea name="message" id="message" rows="5" required
                              class="mt-1 block w-full px-3 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-black">@if(old('message')){{ old('message') }}@endif</textarea>
                    @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                {{-- If you want to link the inquiry to a specific plot, you can pass plot_id as a hidden field --}}
                {{-- <input type="hidden" name="plot_id" value="{{ $plot->id ?? '' }}"> --}}

                <div class="mt-6 text-center">
                    <button type="submit" class="px-6 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition ease-in-out duration-150">Submit Inquiry</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
