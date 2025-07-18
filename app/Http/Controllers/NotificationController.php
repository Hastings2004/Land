<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function show($id)
    {
        $user = Auth::user();
        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();
        if (!$notification->is_read) {
            $notification->is_read = true;
            $notification->save();
        }
        return view('notifications.show', compact('notification'));
    }

    public function download($id)
    {
        $user = Auth::user();
        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();
        if ($notification->type === 'reservation_invoice') {
            $data = json_decode($notification->data, true);
            $reservation = \App\Models\Reservation::find($data['reservation_id'] ?? null);
            if ($reservation) {
                $pdf = Pdf::loadView('reservations.invoice', [
                    'invoice_number' => 'INV-' . $reservation->created_at->format('Ymd') . '-' . $reservation->id,
                    'date' => $reservation->created_at->format('Y-m-d'),
                    'user' => $reservation->user,
                    'plot' => $reservation->plot,
                    'reservation' => $reservation,
                ]);
                return $pdf->download('Reservation_Invoice_' . $reservation->id . '.pdf');
            }
        }
        // Fallback: generic notification PDF
        $pdf = Pdf::loadView('notifications.pdf', [
            'notification' => $notification,
        ]);
        return $pdf->download('Notification_' . $notification->id . '.pdf');
    }
}
