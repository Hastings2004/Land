<x-dashboard-layout>
    <h2 class="text-3xl font-extrabold mb-8 text-[#ffb700] text-center tracking-wide">Edit Inquiry</h2>
    <div class="max-w-xl mx-auto p-8 rounded-2xl shadow-2xl border-2 border-indigo-200" style="background: linear-gradient(135deg, #f8fafc 60%, #e0e7ff 100%);">
        <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="name" class="block text-base font-semibold text-neutral-800 mb-1">Inquirer Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $inquiry->name) }}" required
                       class="mt-1 block w-full h-11 border-2 border-neutral-700 rounded-lg shadow focus:border-neutral-700 focus:ring-2 focus:ring-neutral-700 bg-white/80 text-neutral-800 placeholder-gray-400 transition pl-3"
                       style="caret-color: #6366f1;" autocomplete="off">
                @error('name')<p class="text-pink-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-6">
                <label for="email" class="block text-base font-semibold text-neutral-800 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $inquiry->email) }}" required
                       class="mt-1 block w-full h-11 border-2 border-neutral-700 rounded-lg shadow focus:border-neutral-700 focus:ring-2 focus:ring-neutral-700 bg-white/80 text-neutral-800 placeholder-gray-400 transition pl-3"
                       style="caret-color: #6366f1;" autocomplete="off">
                @error('email')<p class="text-pink-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-6">
                <label for="phone" class="block text-base font-semibold text-neutral-800 mb-1">Phone ( +265...)</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone', $inquiry->phone) }}"
                       pattern="^\+265\d{9}$"
                       placeholder="+265XXXXXXXXX"
                       class="mt-1 block w-full h-11 border-2 border-neutral-700 rounded-lg shadow focus:border-neutral-700 focus:ring-2 focus:ring-neutral-700 bg-white/80 text-neutral-800 placeholder-gray-400 transition pl-3"
                       style="caret-color: #6366f1;" autocomplete="off">
                <small class="text-neutral-800">Format: +265XXXXXXXXX</small>
                @error('phone')<p class="text-pink-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-6">
                <label for="message" class="block text-base font-semibold text-neutral-800 mb-1">Message</label>
                <textarea name="message" id="message" rows="5" required
                          class="mt-1 block w-full border-2 border-neutral-700 rounded-lg shadow focus:border-neutral-700 focus:ring-2 focus:ring-neutral-700 bg-white/80 text-neutral-800 placeholder-gray-400 transition pl-3"
                          style="caret-color: #6366f1;" autocomplete="off">{{ old('message', $inquiry->message) }}</textarea>
                @error('message')<p class="text-pink-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-6">
                <label for="status" class="block text-base font-semibold text-neutral-800 mb-1">Status</label>
                <select name="status" id="status" required
                        class="mt-1 block w-full h-11 border-2 border-neutral-700 rounded-lg shadow focus:border-neutral-700 focus:ring-2 focus:ring-neutral-700 bg-white/80 text-neutral-800 transition pl-3"
                        style="caret-color: #6366f1;">
                    <option value="new" {{ old('status', $inquiry->status) == 'new' ? 'selected' : '' }}>New</option>
                    <option value="viewed" {{ old('status', $inquiry->status) == 'viewed' ? 'selected' : '' }}>Viewed</option>
                    <option value="responded" {{ old('status', $inquiry->status) == 'responded' ? 'selected' : '' }}>Responded</option>
                    <option value="closed" {{ old('status', $inquiry->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                @error('status')<p class="text-pink-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-6">
                <label for="admin_response" class="block text-base font-semibold text-neutral-800 mb-1">Admin Response</label>
                <textarea name="admin_response" id="admin_response" rows="4" 
                          placeholder="Enter your response to the customer..."
                          class="mt-1 block w-full border-2 border-neutral-700 rounded-lg shadow focus:border-neutral-700 focus:ring-2 focus:ring-neutral-700 bg-white/80 text-neutral-800 placeholder-gray-400 transition pl-3"
                          style="caret-color: #6366f1;">{{ old('admin_response', $inquiry->admin_response) }}</textarea>
                <small class="text-neutral-600">This response will be sent to the customer when status is set to 'Responded'</small>
                @error('admin_response')<p class="text-pink-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <script>
                // Focus the first input and set caret at the start
                window.addEventListener('DOMContentLoaded', function() {
                    var firstInput = document.querySelector('form input, form textarea');
                    if (firstInput) {
                        firstInput.focus();
                        if (firstInput.setSelectionRange) {
                            // Set caret at position 1 (not at the very end or start)
                            firstInput.setSelectionRange(1, 1);
                        }
                    }
                });
            </script>

            <div class="mt-8 flex gap-4 justify-center">
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-[#ffe066] via-[#ffd60a] to-[#ffb700] text-[#7a5c00] font-bold rounded-lg shadow-lg hover:from-[#ffd60a] hover:to-[#ffb700] focus:outline-none focus:ring-2 focus:ring-[#ffe066] transition">Update Inquiry</button>
                <a href="{{ route('inquiries.show', $inquiry) }}" class="px-6 py-2 bg-gradient-to-r from-red-400 via-red-500 to-red-700 text-white font-bold rounded-lg shadow-lg hover:from-red-500 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-red-400 transition">Cancel</a>
            </div>
        </form>
    </div>
</x-dashboard-layout>
