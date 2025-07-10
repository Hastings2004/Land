<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationPaidNotification extends Notification implements ShouldQueue
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
            ->subject('Payment Successful - Plot Purchased')
            ->line('Congratulations! Your payment for the plot: ' . $this->plotTitle . ' was successful.')
            ->line('The plot is now marked as sold and belongs to you.');
    }
} 