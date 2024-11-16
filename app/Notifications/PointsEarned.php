<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PointsEarned extends Notification
{
    use Queueable;

    protected $points;
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @param int $points
     * @param string $type
     */
    public function __construct($points, $type)
    {
        $this->points = $points;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // You can add 'mail' or other channels if needed
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => "You earned {$this->points} points for {$this->type}ing a video!",
            'points' => $this->points,
            'type' => $this->type,
        ];
    }
}