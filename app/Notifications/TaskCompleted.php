<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class TaskCompleted extends Notification
{
    use Queueable;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "You have completed the task: {$this->task->description}",
            'task_id' => $this->task->id,
            // Add other relevant data if needed
        ];
    }
}