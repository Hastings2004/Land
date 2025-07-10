<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Plot;
use Carbon\Carbon;
use App\Notifications\ReservationExpiredNotification;
use App\Models\Notification;

class ExpireReservations extends Command
{
    protected $signature = 'reservations:expire';
    protected $description = 'Expire reservations whose expires_at is in the past and update plot status.';

    public function handle()
    {
        $now = Carbon::now();
        // Send expiring soon notifications (2 hours before expiry)
        $expiringSoon = Reservation::where('status', 'active')
            ->where('expires_at', '>', $now)
            ->where('expires_at', '<=', $now->copy()->addHours(2))
            ->get();
        foreach ($expiringSoon as $reservation) {
            // Only send if not already notified
            $alreadyNotified = Notification::where('type', 'reservation_expiring')
                ->where('user_id', $reservation->user_id)
                ->where('data->reservation_id', $reservation->id)
                ->exists();
            if (!$alreadyNotified) {
                Notification::create([
                    'type' => 'reservation_expiring',
                    'title' => '⏰ Reservation Expiring Soon',
                    'message' => "Your reservation for plot '{$reservation->plot->title}' will expire at {$reservation->expires_at->format('M d, Y H:i')}. Please complete your payment.",
                    'user_id' => $reservation->user_id,
                    'data' => [
                        'plot_id' => $reservation->plot_id,
                        'reservation_id' => $reservation->id,
                        'expires_at' => $reservation->expires_at,
                    ]
                ]);
            }
        }
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

        // Archive expired reservations older than 7 days
        $toArchive = Reservation::where('status', 'expired')
            ->where('expires_at', '<', now()->subDays(7))
            ->get();
        foreach ($toArchive as $reservation) {
            $reservation->delete(); // Soft delete
        }

        $this->info('Expired reservations processed successfully.');
    }
} 