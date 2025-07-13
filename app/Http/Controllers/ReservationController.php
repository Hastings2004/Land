<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notifications\ReservationCancelledNotification;
use App\Notifications\ReservationPaidNotification;

class ReservationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reservations = $user->reservations()->withTrashed()->with('plot')->latest()->paginate(10);
        // Only use allowed statuses
        $stats = [
            'total' => $user->reservations()->withTrashed()->count(),
            'active' => $user->reservations()->where('status', 'active')->count(),
            'completed' => $user->reservations()->where('status', 'completed')->count(),
            'expired' => $user->reservations()->withTrashed()->where('status', 'expired')->count(),
            'cancelled' => $user->reservations()->where('status', 'cancelled')->count(),
        ];
        return view('customer.reservations.index', compact('reservations', 'stats'));
    }

    /**
     * Admin view: Show all reservations
     */
    public function adminIndex()
    {
        $reservations = Reservation::withTrashed()->with(['user', 'plot'])->latest()->paginate(15);
        $stats = [
            'total' => Reservation::withTrashed()->count(),
            'active' => Reservation::where('status', 'active')->count(),
            'completed' => Reservation::where('status', 'completed')->count(),
            'expired' => Reservation::withTrashed()->where('status', 'expired')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
        ];
        return view('admin.reservations.index', compact('reservations', 'stats'));
    }

    /**
     * Admin: Approve a reservation
     */
    public function approve(Reservation $reservation)
    {
        $reservation->status = 'completed'; // Use allowed ENUM value
        $reservation->save();

        return back()->with('success', 'Reservation approved successfully.');
    }

    /**
     * Admin: Reject a reservation
     */
    public function reject(Reservation $reservation)
    {
        $reservation->status = 'rejected';
        $reservation->save();

        // Notify the user
        $reservation->user->notify(new ReservationCancelledNotification($reservation->plot->title));

        // Update the plot status back to available
        $plot = $reservation->plot;
        $plot->status = 'available';
        $plot->save();

        return back()->with('success', 'Reservation rejected successfully.');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $plot = Plot::findOrFail($request->plot_id);

        // Check if the plot is already reserved
        if ($plot->activeReservation) {
            return back()->with('error', 'This plot is already reserved.');
        }

        // Check if the user already has an active reservation for this plot
        if ($user->reservations()->where('plot_id', $plot->id)->where('status', 'active')->exists()) {
            return back()->with('info', 'You already have an active reservation for this plot.');
        }

        $reservation = Reservation::create([
            'user_id' => $user->id,
            'plot_id' => $plot->id,
            'expires_at' => Carbon::now()->addHours(24),
            'status' => 'active',
        ]);

        // Update the plot status
        $plot->status = 'reserved';
        $plot->save();

        // Notify the customer of reservation
        $user->notify(new ReservationPaidNotification($plot->title));

        return redirect()->route('customer.reservations.index')->with('success', 'Plot reserved successfully! It will expire in 24 hours.');
    }

    public function destroy(Reservation $reservation)
    {
        // Authorize that the user owns the reservation
        if (Auth::id() !== $reservation->user_id) {
            abort(403);
        }

        $reservation->status = 'cancelled';
        $reservation->save();

        // Notify the user
        $reservation->user->notify(new ReservationCancelledNotification($reservation->plot->title));

        // Update the plot status back to available
        $plot = $reservation->plot;
        $plot->status = 'available';
        $plot->save();

        return back()->with('success', 'Reservation cancelled successfully.');
    }

    /**
     * Handle a request to buy a reserved plot (grace period logic)
     */
    public function requestToBuy(Request $request)
    {
        $plot = Plot::findOrFail($request->plot_id);
        $activeReservation = $plot->activeReservation;
        $graceMinutes = 120; // 2 hours

        if ($activeReservation) {
            $now = now();
            $currentExpires = $activeReservation->expires_at;
            $newExpires = $now->copy()->addMinutes($graceMinutes);
            // Only update if the new grace period is later than current expires_at
            if ($currentExpires->lt($newExpires)) {
                $activeReservation->expires_at = $newExpires;
                $activeReservation->save();
            }
            // Notify the reserver
            $activeReservation->user->notify(
                new \App\Notifications\GracePeriodNotification($plot->title, $graceMinutes)
            );
            // Optionally, notify admin here
            return back()->with('info', 'The current reserver has been notified and given a 2-hour grace period to pay.');
        }
        // If not reserved, allow the user to proceed to reserve or buy
        return back()->with('success', 'This plot is available. You can proceed to reserve or buy.');
    }

    public function show(Reservation $reservation)
    {
        $user = Auth::user();
        // Ensure the user owns the reservation or is admin
        if ($user->id !== $reservation->user_id && !$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        return view('customer.reservations.show', compact('reservation'));
    }
}
