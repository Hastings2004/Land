<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class GracePeriodNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $plotTitle;
    protected $graceMinutes;

    public function __construct($plotTitle, $graceMinutes)
    {
        $this->plotTitle = $plotTitle;
        $this->graceMinutes = $graceMinutes;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Grace Period for Your Land Reservation')
            ->line('Another customer is ready to buy the plot: ' . $this->plotTitle)
            ->line('You have ' . $this->graceMinutes . ' minutes to complete your payment, or your reservation will be cancelled.')
            ->action('Pay Now', url('/reservations'))
            ->line('If you do not pay within this time, your reservation will be lost.');
    }
} 