<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserTask;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserTaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can complete the task.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserTask  $userTask
     * @return bool
     */
    public function complete(User $user, UserTask $userTask)
    {
        return $user->id === $userTask->user_id && $userTask->status !== 'completed';
    }
}