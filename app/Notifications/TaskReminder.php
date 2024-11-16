<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskReminder extends Notification
{
    use Queueable;

    protected $tasks;

    /**
     * Create a new notification instance.
     *
     * @param \Illuminate\Support\Collection $tasks
     */
    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $taskList = $this->tasks->pluck('description')->join(', ');
        return [
            'message' => "You have the following incomplete tasks: {$taskList}. Please complete them to earn points.",
        ];
    }
}