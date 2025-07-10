<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class InquiryRespondedNotification extends Notification implements ShouldQueue
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
            'title' => 'Inquiry Responded',
            'message' => 'Your inquiry "' . $this->inquiry->subject . '" has received a response.',
            'type' => 'inquiry_responded',
            'inquiry_id' => $this->inquiry->id,
        ];
    }
} 