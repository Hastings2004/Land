<x-dashboard-layout>
<div class="max-w-2xl mx-auto py-10 px-4">
    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}"
       class="inline-flex items-center px-4 py-2 mb-6 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-semibold rounded-lg shadow transition-all duration-200 group">
        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
        Back to Dashboard
    </a>
    <h2 class="text-2xl font-bold text-yellow-700 mb-6 flex items-center gap-2">
        <i class="fas fa-bell text-yellow-500 animate-pulse"></i> Notifications
        @if($notifications->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="ml-auto">
                @csrf
                <button type="submit" class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 hover:text-yellow-900 font-semibold text-xs shadow transition-all duration-200 ml-4">
                    <i class="fas fa-check-double mr-1"></i> Mark all as read
                </button>
            </form>
        @endif
    </h2>
    @if($notifications->count() === 0)
        <div class="p-10 text-center text-yellow-500 font-semibold flex flex-col items-center justify-center bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl shadow-lg border-2 border-dashed border-yellow-200">
            <i class="fas fa-bell-slash text-5xl mb-3 animate-bounce"></i>
            <span class="text-lg">No notifications yet!</span>
            <p class="text-gray-400 text-sm mt-2">You’ll see important updates, reminders, and messages here.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="flex items-start gap-3 p-4 bg-white hover:bg-yellow-50 transition-all duration-200 cursor-pointer rounded-xl shadow-md border border-yellow-100 @if(!$notification->is_read) ring-2 ring-yellow-400 bg-gradient-to-r from-yellow-50 to-yellow-100 @endif">
                    <div class="flex-shrink-0 flex flex-col items-center pt-1">
                        <span class="text-2xl">
                            @if($notification->type === 'reservation_expiring') <i class="fas fa-hourglass-half text-yellow-500"></i>
                            @elseif($notification->type === 'new_plot') <i class="fas fa-star text-green-500"></i>
                            @elseif($notification->type === 'payment_due') <i class="fas fa-money-bill-wave text-blue-500"></i>
                            @elseif($notification->type === 'inquiry_received') <i class="fas fa-envelope-open-text text-pink-500"></i>
                            @elseif($notification->type === 'inquiry_responded') <i class="fas fa-comment-dots text-purple-500"></i>
                            @else <i class="fas fa-bell text-yellow-400"></i>
                            @endif
                        </span>
                        @if(!$notification->is_read)
                            <span class="text-xs text-yellow-400 mt-1 animate-pulse">•</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-bold text-gray-900 mb-1">{{ $notification->title }}</p>
                            <span class="text-xs text-gray-400 ml-2">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $notification->message }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
</x-dashboard-layout> 