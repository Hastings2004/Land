<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationExpiredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $plotTitle;

    public function __construct($plotTitle)
    {
        $this->plotTitle = $plotTitle;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Reservation Has Expired')
            ->line('Your reservation for the plot: ' . $this->plotTitle . ' has expired.')
            ->line('The plot is now available to other customers.');
    }
} 