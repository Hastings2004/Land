<x-dashboard-layout>
<div class="max-w-2xl mx-auto mt-10">
    <div class="flex items-center mb-6">
        <a href="{{ url()->previous() }}" class="text-yellow-700 hover:text-yellow-900 mr-4">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h2 class="text-3xl font-extrabold text-yellow-700 tracking-tight flex items-center">
            <i class="fas fa-bell mr-2"></i> Notification Details
        </h2>
        <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.notifications.download' : 'customer.notifications.download', $notification->id) }}"
           class="ml-auto px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-bold text-xs shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <i class="fas fa-file-pdf mr-2"></i> Download as PDF
        </a>
    </div>
    <div class="bg-white border-2 border-yellow-400 rounded-lg p-6 shadow-md">
        <div class="flex items-center mb-4">
            @if($notification->type === 'reservation_expiring')
                <i class="fas fa-hourglass-half text-yellow-500 text-2xl mr-3"></i>
            @elseif($notification->type === 'new_plot')
                <i class="fas fa-star text-green-500 text-2xl mr-3"></i>
            @elseif($notification->type === 'payment_due')
                <i class="fas fa-money-bill-wave text-blue-500 text-2xl mr-3"></i>
            @elseif($notification->type === 'inquiry_received')
                <i class="fas fa-envelope-open-text text-pink-500 text-2xl mr-3"></i>
            @elseif($notification->type === 'inquiry_responded')
                <i class="fas fa-comment-dots text-purple-500 text-2xl mr-3"></i>
            @else
                <i class="fas fa-bell text-yellow-500 text-2xl mr-3"></i>
            @endif
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $notification->title }}</h3>
                <span class="text-xs text-gray-400 ml-2 whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
            </div>
        </div>
        <p class="text-base text-gray-700 leading-snug mb-2">{!! $notification->message !!}</p>
    </div>
</div>
</x-dashboard-layout> 