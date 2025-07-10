<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class InquirySentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $inquiry;

    public function __construct($inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Inquiry Sent',
            'message' => 'Your inquiry "' . $this->inquiry->subject . '" has been sent successfully.',
            'type' => 'inquiry_sent',
            'inquiry_id' => $this->inquiry->id,
        ];
    }
} 