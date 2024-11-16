<?php
// app/Listeners/AwardPointsForInteraction.php

namespace App\Listeners;

use App\Events\InteractionCreated;
use App\Models\UserTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwardPointsForInteraction implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(InteractionCreated $event)
    {
        $interaction = $event->interaction;
        $userTask = UserTask::where('user_id', $interaction->user_id)
                            ->where('task_id', $interaction->task_id)
                            ->where('status', 'pending')
                            ->first();

        if (!$userTask) {
            return;
        }

        $task = $userTask->task;

        // Check if interaction meets task requirements
        switch ($task->task_type) {
            case 'like':
                $requiredLikes = $task->required_likes;
                $actualLikes = $task->user->interactions()
                                         ->where('task_id', $task->id)
                                         ->where('type', 'like')
                                         ->count();

                if ($actualLikes >= $requiredLikes) {
                    $this->completeUserTask($userTask);
                }
                break;

            case 'comment':
                $requiredComments = $task->required_comments;
                $actualComments = $task->user->interactions()
                                            ->where('task_id', $task->id)
                                            ->where('type', 'comment')
                                            ->count();

                if ($actualComments >= $requiredComments) {
                    $this->completeUserTask($userTask);
                }
                break;

            case 'share':
                $requiredShares = $task->required_shares;
                $actualShares = $task->user->interactions()
                                          ->where('task_id', $task->id)
                                          ->where('type', 'share')
                                          ->count();

                if ($actualShares >= $requiredShares) {
                    $this->completeUserTask($userTask);
                }
                break;

            default:
                // Handle other task types if necessary
                break;
        }
    }

    protected function completeUserTask(UserTask $userTask)
    {
        $userTask->status = 'completed';
        $userTask->completed_at = now();
        $userTask->save();

        // Award points
        $user = $userTask->user;
        $user->total_points += $userTask->task->points;
        $user->save();

        // Notify user
        $user->notify(new \App\Notifications\TaskCompleted($userTask->task));

        // Check and assign badges
        $badges = \App\Models\Badge::where('points_required', '<=', $user->total_points)->get();
        foreach ($badges as $badge) {
            if (!$user->badges()->where('badge_id', $badge->id)->exists()) {
                $user->badges()->attach($badge->id);
                $user->notify(new \App\Notifications\BadgeAchieved($badge));
            }
        }
    }
}