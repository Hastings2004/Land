<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewPlotNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $plot;

    public function __construct($plot)
    {
        $this->plot = $plot;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Plot Available',
            'message' => 'A new plot "' . $this->plot->title . '" has been added. Check it out!',
            'type' => 'new_plot',
            'plot_id' => $this->plot->id,
        ];
    }
} 