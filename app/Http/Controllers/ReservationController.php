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
        $reservations = Auth::user()->reservations()->with('plot')->latest()->paginate(10);
        return view('customer.reservations.index', compact('reservations'));
    }

    /**
     * Admin view: Show all reservations
     */
    public function adminIndex()
    {
        $reservations = Reservation::with(['user', 'plot'])->latest()->paginate(15);
        return view('admin.reservations.index', compact('reservations'));
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

        return redirect()->route('reservations.index')->with('success', 'Plot reserved successfully! It will expire in 24 hours.');
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
