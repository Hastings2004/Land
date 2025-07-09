<x-dashboard-layout>
    <div class="p-6">
        <div class="mb-6">
            <a href="{{ route('customer.inquiries.show', $inquiry) }}" 
               class="inline-flex items-center gap-2 text-yellow-600 hover:text-yellow-700 font-medium">
                <i class="fas fa-arrow-left"></i>
                Back to Inquiry Details
            </a>
        </div>

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-yellow-100">
                    <h2 class="text-2xl font-bold text-gray-800">Edit Inquiry</h2>
                </div>

                <div class="p-6">
                    <form action="{{ route('customer.inquiries.update', $inquiry) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $inquiry->name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                       placeholder="Brief subject of your inquiry"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $inquiry->email) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                       placeholder="your@email.com"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone (Optional)</label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $inquiry->phone) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                       placeholder="+1234567890">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="plot_id" class="block text-sm font-medium text-gray-700 mb-2">Related Plot (Optional)</label>
                                <select id="plot_id" 
                                        name="plot_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                    <option value="">Select a plot (optional)</option>
                                    @foreach(\App\Models\Plot::where('status', 'available')->get() as $plot)
                                        <option value="{{ $plot->id }}" {{ old('plot_id', $inquiry->plot_id) == $plot->id ? 'selected' : '' }}>
                                            {{ $plot->title }} - ${{ number_format($plot->price) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('plot_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                                <textarea id="message" 
                                          name="message" 
                                          rows="6"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                          placeholder="Please provide details about your inquiry..."
                                          required>{{ old('message', $inquiry->message) }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex gap-4 pt-4">
                                <button type="submit"
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-yellow-500 text-white rounded-xl font-semibold hover:bg-yellow-600 focus:outline-none focus:ring-4 focus:ring-yellow-200 transition-all duration-200">
                                    <i class="fas fa-save"></i>
                                    Update Inquiry
                                </button>
                                
                                <a href="{{ route('customer.inquiries.show', $inquiry) }}"
                                   class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-500 text-white rounded-xl font-semibold hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-all duration-200">
                                    <i class="fas fa-times"></i>
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout> 