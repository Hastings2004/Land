<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReservationPaidNotification;
use App\Notifications\ReservationCancelledNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);
        $plot = $reservation->plot;

        // Only allow payment if reservation is active
        if ($reservation->status !== 'active') {
            return back()->with('error', 'This reservation is not active.');
        }

        DB::transaction(function () use ($reservation, $plot) {
            // Mark reservation as paid
            $reservation->status = 'paid';
            $reservation->save();

            // Mark plot as sold
            $plot->status = 'sold';
            $plot->save();

            // Cancel all other active reservations for this plot
            $otherReservations = Reservation::where('plot_id', $plot->id)
                ->where('id', '!=', $reservation->id)
                ->where('status', 'active')
                ->get();
            foreach ($otherReservations as $other) {
                $other->status = 'cancelled';
                $other->save();
                // Notify the user
                $other->user->notify(new ReservationCancelledNotification($plot->title));
            }
        });

        // Notify the paying user
        $reservation->user->notify(new ReservationPaidNotification($plot->title));

        // Generate PDF receipt
        $pdf = Pdf::loadView('emails.receipt', [
            'user' => $reservation->user,
            'plot' => $plot,
            'date' => now()->format('M d, Y'),
        ]);
        $pdfContent = $pdf->output();

        // Email the PDF receipt to the user
        Mail::send([], [], function ($message) use ($reservation, $pdfContent) {
            $message->to($reservation->user->email)
                ->subject('Your Payment Receipt - Atsogo Estate Agency')
                ->attachData($pdfContent, 'receipt.pdf', [
                    'mime' => 'application/pdf',
                ])
                ->setBody('Thank you for your payment. Please find your receipt attached.', 'text/html');
        });

        return back()->with('success', 'Payment successful! The plot is now marked as sold.');
    }
}
