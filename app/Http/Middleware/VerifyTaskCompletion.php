<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserTask;
use Illuminate\Support\Facades\Auth;

class VerifyTaskCompletion
{
    public function handle(Request $request, Closure $next)
    {
        $userTaskId = $request->route('userTaskId');
        $userTask = UserTask::where('id', $userTaskId)
                            ->where('user_id', Auth::id())
                            ->first();

        if (!$userTask) {
            return redirect()->back()->with('error', 'Invalid task.');
        }

        $task = $userTask->task;

        // Example Verification
        if ($task->task_type === 'watch' && $userTask->watch_duration < $task->required_watch_duration) {
            return redirect()->back()->with('error', 'Watch duration not sufficient.');
        }

        // Add more verification as needed

        return $next($request);
    }
}