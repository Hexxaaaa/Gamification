<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BadgeAchieved extends Notification
{
    use Queueable;

    protected $badge;

    /**
     * Create a new notification instance.
     */
    public function __construct($badge)
    {
        $this->badge = $badge;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => "Selamat! Anda telah mencapai badge: {$this->badge->name}.",
            'badge_id' => $this->badge->id,
        ];
    }
}