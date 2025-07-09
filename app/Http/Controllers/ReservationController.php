<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reservations = $user->reservations()->with('plot')->latest()->paginate(10);
        
        // Calculate real statistics for the customer
        $stats = [
            'total' => $user->reservations()->count(),
            'active' => $user->reservations()->where('status', 'active')->count(),
            'pending' => $user->reservations()->where('status', 'pending')->count(),
            'approved' => $user->reservations()->where('status', 'approved')->count(),
            'rejected' => $user->reservations()->where('status', 'rejected')->count(),
            'expired' => $user->reservations()->where('status', 'expired')->count(),
            'cancelled' => $user->reservations()->where('status', 'cancelled')->count(),
        ];
        
        return view('customer.reservations.index', compact('reservations', 'stats'));
    }

    /**
     * Admin view: Show all reservations
     */
    public function adminIndex()
    {
        $reservations = Reservation::with(['user', 'plot'])->latest()->paginate(15);
        
        // Calculate real statistics for admin
        $stats = [
            'total' => Reservation::count(),
            'active' => Reservation::where('status', 'active')->count(),
            'pending' => Reservation::where('status', 'pending')->count(),
            'approved' => Reservation::where('status', 'approved')->count(),
            'rejected' => Reservation::where('status', 'rejected')->count(),
            'expired' => Reservation::where('status', 'expired')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.reservations.index', compact('reservations', 'stats'));
    }

    /**
     * Admin: Approve a reservation
     */
    public function approve(Reservation $reservation)
    {
        $reservation->status = 'approved';
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

        // Update the plot status back to available
        $plot = $reservation->plot;
        $plot->status = 'available';
        $plot->save();

        return back()->with('success', 'Reservation cancelled successfully.');
    }
}
