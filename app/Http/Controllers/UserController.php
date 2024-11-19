<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Interaction;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use App\Models\Voucher;
use App\Models\UserVoucher;
use App\Notifications\BadgeAchieved;
use App\Notifications\PointsEarned;
use App\Notifications\TaskCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
     /**
     * Display the user dashboard with aggregated insights.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();
        $tasks = Task::where('status', 'active')->get();
        $userTasks = $user->userTasks()->with('task')->get();
        $vouchers = Voucher::where('points_required', '<=', $user->total_points)
            ->where('status', 'active')
            ->get();

        // Progress Insights Data
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $totalPoints = User::sum('total_points');
        $completionRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        // Featured Task
        $featuredTask = Task::where('featured', true)
                            ->where('status', 'active')
                            ->first();

        // Mission Statistics
        $totalMissions = Task::count(); // Assuming missions are equivalent to tasks
        $engagedUsers = User::whereHas('userTasks', function ($query) {
            $query->where('status', 'completed');
        })->count();

        $gamificationHighlights = [
            '100% Transparent and Fair Challenges',
            '90+ Highly Rewarding Missions',
            '700+ Engaged Users Worldwide',
        ];

        return view('user.dashboard', compact(
            'user', 
            'tasks', 
            'userTasks', 
            'vouchers',
            'totalTasks',
            'completedTasks',
            'totalPoints',
            'completionRate',
            'featuredTask',
            'totalMissions',
            'engagedUsers',
            'gamificationHighlights'
        ));
    }

    /**
     * Start a Task.
     *
     * @param  int  $taskId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function startTask($taskId)
    {
        $user = Auth::user();
        $task = Task::findOrFail($taskId);

        // Check if the task is active and not already started by the user
        if ($task->status !== 'active' || $user->userTasks()->where('task_id', $taskId)->exists()) {
            return redirect()->back()->with('error', 'Task not available to start.');
        }

        $userTask = UserTask::create([
            'user_id' => $user->id,
            'task_id' => $taskId,
            'status' => 'started',
            'started_at' => now(),
        ]);

        // Log task start activity
        activity()
            ->causedBy($user)
            ->performedOn($task)
            ->withProperties(['user_task_id' => $userTask->id])
            ->log('Task Started');

        return redirect()->back()->with('success', 'Task started successfully.');
    }

    /**
     * Take a Task.
     *
     * @param  int  $taskId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function takeTask($taskId)
    {
        $user = Auth::user();
        $task = Task::findOrFail($taskId);

        if ($task->status !== 'active' || $user->userTasks()->where('task_id', $taskId)->exists()) {
            return redirect()->back()->with('error', 'Task not available to take.');
        }

        $userTask = UserTask::create([
            'user_id' => $user->id,
            'task_id' => $task->id,
            'status' => 'pending',
        ]);

        // Log task taken activity
        activity()
            ->causedBy($user)
            ->performedOn($task)
            ->withProperties(['user_task_id' => $userTask->id])
            ->log('Task Taken');

        return redirect()->back()->with('success', 'Task taken successfully.');
    }

    /**
     * Complete a Task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userTaskId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeTask(Request $request, $userTaskId)
    {
        $userTask = UserTask::where('id', $userTaskId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $task = $userTask->task;

        $this->authorize('complete', $userTask);

        // Validate that the user watched the video to completion
        $request->validate([
            'watched_to_completion' => 'required|boolean',
        ]);

        if (!$request->watched_to_completion) {
            // Log incomplete task attempt
            activity()
                ->causedBy(Auth::user())
                ->performedOn($task)
                ->withProperties(['user_task_id' => $userTaskId])
                ->log('Incomplete Task Completion Attempt');

            return redirect()->back()->with('error', 'You must watch the video to completion to complete the task.');
        }

        $userTask->update([
            'status' => 'completed',
            'watched_to_completion' => $request->watched_to_completion,
            'completion_date' => now(),
        ]);

        $user = Auth::user();
        $user->total_points += $task->points; // Points for watching the video
        $user->save();

        $user->notify(new TaskCompleted($task));

        // Log task completion
        activity()
            ->causedBy($user)
            ->performedOn($task)
            ->withProperties([
                'user_task_id' => $userTaskId,
                'points_earned' => $task->points,
                'total_points' => $user->total_points,
            ])
            ->log('Task Completed');

        // Check for badge achievements
        $badges = Badge::where('points_required', '<=', $user->total_points)->get();
        foreach ($badges as $badge) {
            if (!$user->badges()->where('badge_id', $badge->id)->exists()) {
                $user->badges()->attach($badge->id);
                $user->notify(new BadgeAchieved($badge));

                // Log badge achievement
                activity()
                    ->causedBy($user)
                    ->performedOn($badge)
                    ->withProperties(['badge_id' => $badge->id])
                    ->log('Badge Achieved');
            }
        }

        return redirect()->back()->with('success', 'Task completed successfully.');
    }

    /**
     * Redeem a Voucher.
     *
     * @param  int  $voucherId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redeemVoucher($voucherId)
    {
        $user = Auth::user();
        $voucher = Voucher::findOrFail($voucherId);

        if ($user->total_points < $voucher->points_required || $voucher->status !== 'active') {
            // Log failed redemption attempt
            activity()
                ->causedBy($user)
                ->withProperties([
                    'voucher_id' => $voucher->id,
                    'points_required' => $voucher->points_required,
                    'current_points' => $user->total_points,
                    'status' => $voucher->status,
                ])
                ->log('Failed Voucher Redemption Attempt');

            return redirect()->back()->with('error', 'Voucher cannot be redeemed.');
        }

        $user->total_points -= $voucher->points_required;
        $user->save();

        $userVoucher = UserVoucher::create([
            'user_id' => $user->id,
            'voucher_id' => $voucher->id,
            'redeemed_at' => now(),
        ]);

        // Log successful redemption
        activity()
            ->causedBy($user)
            ->performedOn($voucher)
            ->withProperties([
                'voucher_id' => $voucher->id,
                'points_redeemed' => $voucher->points_required,
                'remaining_points' => $user->total_points,
            ])
            ->log('Voucher Redeemed');

        return redirect()->back()->with('success', 'Voucher redeemed successfully.');
    }

    /**
     * Display the leaderboard.
     *
     * @return \Illuminate\View\View
     */
    public function leaderboard()
    {
        $users = User::orderBy('total_points', 'desc')
            ->take(10)
            ->get(['id', 'name', 'total_points']);

        return view('user.leaderboard', compact('users'));
    }

    /**
     * Log Interaction (Like, Comment, Share).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logInteraction(Request $request, Task $task)
    {
        $request->validate([
            'type' => 'required|in:like,comment,share',
            'comment' => 'required_if:type,comment|string|max:500',
        ]);

        $interaction = Interaction::create([
            'user_id' => Auth::id(),
            'task_id' => $task->id,
            'type' => $request->type,
            'content' => $request->comment ?? null,
        ]);

        // Assign points based on interaction type
        $points = 0;
        switch ($request->type) {
            case 'like':
                $points = 10; // Example points for like
                break;
            case 'comment':
                $points = 20; // Example points for comment
                break;
            case 'share':
                $points = 50; // Higher points for share
                break;
        }

        if ($points > 0) {
            $user = Auth::user();
            $user->total_points += $points;
            $user->save();

            // Notify user of points earned
            $user->notify(new PointsEarned($points, $request->type));

            // Log interaction and points earned
            activity()
                ->causedBy($user)
                ->performedOn($task)
                ->withProperties([
                    'interaction_type' => $request->type,
                    'points_earned' => $points,
                    'total_points' => $user->total_points,
                ])
                ->log('Interaction Logged and Points Earned');
        }

        // Check for badge achievements
        $badges = Badge::where('points_required', '<=', $user->total_points)->get();
        foreach ($badges as $badge) {
            if (!$user->badges()->where('badge_id', $badge->id)->exists()) {
                $user->badges()->attach($badge->id);
                $user->notify(new BadgeAchieved($badge));

                // Log badge achievement
                activity()
                    ->causedBy($user)
                    ->performedOn($badge)
                    ->withProperties(['badge_id' => $badge->id])
                    ->log('Badge Achieved');
            }
        }

        return redirect()->back()->with('success', 'Interaction recorded successfully.');
    }

    /**
     * Display task statistics.
     *
     * @return \Illuminate\View\View
     */
    public function taskStatistics()
    {
        $statistics = Task::withCount(['userTasks' => function ($query) {
            $query->where('status', 'completed');
        }])->get();

        return view('user.task_statistics', compact('statistics'));
    }

    /**
     * Display the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        $vouchers = $user->userVouchers()->with('voucher')->get();

        return view('user.profile', compact('user', 'vouchers'));
    }

    /**
     * Update the user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'age' => 'nullable|integer|min:0',
            'location' => 'nullable|string|max:255',
        ]);

        $user->update($request->only(['name', 'email', 'age', 'location']));

        // Log profile update activity
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties(['updated_fields' => $request->only(['name', 'email', 'age', 'location'])])
            ->log('Profile Updated');

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}