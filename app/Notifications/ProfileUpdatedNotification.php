<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ProfileUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        // No extra data needed
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Profile Updated',
            'message' => 'Your profile information has been updated successfully.',
            'type' => 'profile_updated',
        ];
    }
} 