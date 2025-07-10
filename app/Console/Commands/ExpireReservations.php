<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Plot;
use Carbon\Carbon;
use App\Notifications\ReservationExpiredNotification;

class ExpireReservations extends Command
{
    protected $signature = 'reservations:expire';
    protected $description = 'Expire reservations whose expires_at is in the past and update plot status.';

    public function handle()
    {
        $now = Carbon::now();
        // Remove all SMS reminder logic
        // Only keep reservation expiry and notification logic
        $expiredReservations = Reservation::where('status', 'active')
            ->where('expires_at', '<', $now)
            ->get();

        foreach ($expiredReservations as $reservation) {
            $reservation->status = 'expired';
            $reservation->save();

            // Notify the user
            $reservation->user->notify(new ReservationExpiredNotification($reservation->plot->title));

            $plot = $reservation->plot;
            // Only set to available if there are no other active reservations
            if ($plot && !$plot->reservations()->where('status', 'active')->exists()) {
                $plot->status = 'available';
                $plot->save();
            }
        }

        $this->info('Expired reservations processed successfully.');
    }
} 