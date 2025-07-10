<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationCancelledNotification extends Notification implements ShouldQueue
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
            ->subject('Your Reservation Has Been Cancelled')
            ->line('Your reservation for the plot: ' . $this->plotTitle . ' has been cancelled.')
            ->line('If you have any questions, please contact the agency.');
    }
} 