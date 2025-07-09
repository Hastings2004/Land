<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::forUser($user)
            ->unread()
            ->latest()
            ->take(10)
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead(Request $request)
    {
        $notification = Notification::findOrFail($request->notification_id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        Notification::forUser($user)
            ->unread()
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $user = Auth::user();
        $count = Notification::forUser($user)->unread()->count();

        return response()->json(['count' => $count]);
    }

    public function getAll()
    {
        $user = Auth::user();
        $notifications = Notification::forUser($user)
            ->latest()
            ->paginate(20);

        return response()->json($notifications);
    }

    public function showAll()
    {
        $user = Auth::user();
        $notifications = Notification::forUser($user)
            ->latest()
            ->paginate(20);
        return view('notifications.index', compact('notifications'));
    }
}
