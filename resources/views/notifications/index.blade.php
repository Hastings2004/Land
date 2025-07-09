@extends('components.dashboard-layout')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    <h2 class="text-2xl font-bold text-yellow-700 mb-6 flex items-center gap-2">
        <i class="fas fa-bell text-yellow-500"></i> Notifications
    </h2>
    @if($notifications->count() === 0)
        <div class="p-10 text-center text-yellow-500 font-semibold flex flex-col items-center justify-center bg-yellow-50 rounded-xl shadow">
            <i class="fas fa-bell-slash text-4xl mb-3"></i>
            No notifications yet!
        </div>
    @else
        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="flex items-start gap-3 p-4 bg-white hover:bg-yellow-50 transition-all duration-200 cursor-pointer rounded-xl shadow-sm border border-yellow-100 @if(!$notification->is_read) ring-2 ring-yellow-300 @endif">
                    <div class="flex-shrink-0 flex flex-col items-center pt-1">
                        <span class="text-2xl">
                            @if($notification->type === 'inquiry_received') 🚨
                            @elseif($notification->type === 'inquiry_responded') 💬
                            @else 🔔
                            @endif
                        </span>
                        @if(!$notification->is_read)
                            <span class="text-xs text-yellow-400 mt-1">•</span>
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
@endsection 