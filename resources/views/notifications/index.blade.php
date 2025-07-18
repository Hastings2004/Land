<x-dashboard-layout>
<div class="max-w-2xl mx-auto py-10 px-4">
    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}"
       class="inline-flex items-center px-5 py-2 mb-8 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-bold rounded-xl shadow-lg transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-yellow-400">
        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform text-lg"></i>
        <span class="tracking-wide">Back to Dashboard</span>
    </a>
    <div class="flex items-center gap-3 mb-8">
        <span class="relative">
            <i class="fas fa-bell text-3xl text-yellow-500 animate-pulse"></i>
            @if($notifications->where('is_read', false)->count() > 0)
                <span class="absolute -top-1 -right-1 h-3 w-3 bg-yellow-400 rounded-full border-2 border-white animate-bounce"></span>
            @endif
        </span>
        <h2 class="text-3xl font-extrabold text-yellow-700 tracking-tight">Notifications</h2>
        @if($notifications->count() > 0)
            <form action="{{ route(auth()->user()->role === 'admin' ? 'admin.notifications.mark-all-read' : 'customer.notifications.mark-all-read') }}" method="POST" class="ml-auto">
                @csrf
                <button type="submit" class="flex items-center px-4 py-2 bg-yellow-200 text-yellow-800 rounded-lg hover:bg-yellow-300 hover:text-yellow-900 font-bold text-xs shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <i class="fas fa-check-double mr-2"></i> Mark all as read
                </button>
            </form>
        @endif
    </div>
    @if($notifications->count() === 0)
        <div class="p-12 text-center text-yellow-500 font-semibold flex flex-col items-center justify-center bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl shadow-2xl border-2 border-dashed border-yellow-200">
            <i class="fas fa-bell-slash text-6xl mb-4 animate-bounce"></i>
            <span class="text-xl font-bold">No notifications yet!</span>
            <p class="text-gray-400 text-base mt-2">You’ll see important updates, reminders, and messages here.</p>
        </div>
    @else
        <div class="space-y-5">
            @foreach($notifications as $notification)
                <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.notifications.show' : 'customer.notifications.show', $notification->id) }}"
                   tabindex="0"
                   class="flex items-start gap-4 p-5 bg-white hover:bg-yellow-50 transition-all duration-200 cursor-pointer rounded-2xl shadow-lg border border-yellow-100 focus:ring-2 focus:ring-yellow-400 outline-none @if(!$notification->is_read) ring-2 ring-yellow-400 bg-gradient-to-r from-yellow-50 to-yellow-100 @endif">
                    <div class="flex-shrink-0 flex flex-col items-center pt-1">
                        <span class="text-3xl">
                            @if($notification->type === 'reservation_expiring') <i class="fas fa-hourglass-half text-yellow-500"></i>
                            @elseif($notification->type === 'new_plot') <i class="fas fa-star text-green-500"></i>
                            @elseif($notification->type === 'payment_due') <i class="fas fa-money-bill-wave text-blue-500"></i>
                            @elseif($notification->type === 'inquiry_received') <i class="fas fa-envelope-open-text text-pink-500"></i>
                            @elseif($notification->type === 'inquiry_responded') <i class="fas fa-comment-dots text-purple-500"></i>
                            @else <i class="fas fa-bell text-yellow-400"></i>
                            @endif
                        </span>
                        @if(!$notification->is_read)
                            <span class="text-xs text-yellow-400 mt-1 animate-pulse font-extrabold">•</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-lg font-bold text-gray-900 leading-tight">{{ $notification->title }}</p>
                            <span class="text-xs text-gray-400 ml-2 whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-base text-gray-700 leading-snug">{{ $notification->message }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-10 flex justify-center">
            <div class="inline-flex rounded-lg shadow overflow-hidden border border-yellow-200">
                {{ $notifications->links('pagination::tailwind') }}
            </div>
        </div>
    @endif
</div>
</x-dashboard-layout> 