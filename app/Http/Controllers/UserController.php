<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Interaction;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use App\Models\UserVoucher;
use App\Models\Voucher;
use App\Models\DailyCheckIn;
use App\Notifications\BadgeAchieved;
use App\Notifications\PointsEarned;
use App\Notifications\TaskCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
     * Display a list of available tasks for the user.
     *
     * @return \Illuminate\View\View
     */
    public function tasks()
    {
        $user = Auth::user();

        // Get active tasks
        $tasks = Task::where('status', 'active')
            ->where('deadline', '>', now()) // Add this line
            ->when(true, function ($query) use ($user) {
                return $query->whereDoesntHave('userTasks', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get user's in-progress tasks
        $inProgressTasks = $user->userTasks()
            ->with('task')
            ->whereIn('status', ['pending', 'started'])
            ->get();

        // Get user's completed tasks
        $completedTasks = $user->userTasks()
            ->with('task')
            ->where('status', 'completed')
            ->get();

        return view('user.tasks.index', compact('tasks', 'inProgressTasks', 'completedTasks'));
    }

    public function showTask($userTaskId)
    {
        $userTask = UserTask::where('id', $userTaskId)
            ->where('user_id', Auth::id())
            ->with('task')
            ->firstOrFail();
    
        // If task is pending, automatically start it
        if ($userTask->status === 'pending') {
            $userTask->update([
                'status' => 'started',
                'started_at' => now()
            ]);
    
            // Log task start activity
            activity()
                ->causedBy(Auth::user())
                ->performedOn($userTask->task)
                ->withProperties(['user_task_id' => $userTask->id])
                ->log('Task Started');
        }
    
        // Now task will be either 'started' or 'completed'
        if ($userTask->status === 'started' || $userTask->status === 'completed') {
            return view('user.tasks.show', compact('userTask'));
        }
    
        return redirect()->route('user.tasks.index')->with('error', 'Task cannot be viewed.');
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

        // Check if the task is active
        if ($task->status !== 'active') {
            return redirect()->back()->with('error', 'Task not available to start.');
        }

        // Find the userTask with 'pending' status
        $userTask = $user->userTasks()->where('task_id', $taskId)->where('status', 'pending')->first();

        if (!$userTask) {
            // Check if the task is already started or completed
            $existingTask = $user->userTasks()->where('task_id', $taskId)->first();
            if ($existingTask && in_array($existingTask->status, ['started', 'completed'])) {
                return redirect()->back()->with('error', 'Task not available to start.');
            }

            // If no userTask exists, prevent starting
            return redirect()->back()->with('error', 'Task not available to start.');
        }

        // Update the userTask to 'started'
        $userTask->update([
            'status' => 'started',
            'started_at' => now(),
        ]);

        // Log task start activity
        activity()
            ->causedBy($user)
            ->performedOn($task)
            ->withProperties(['user_task_id' => $userTask->id])
            ->log('Task Started');

        // Redirect to the task video view
        return redirect()->route('user.tasks.show', ['userTaskId' => $userTask->id])
            ->with('success', 'Task started successfully. Watch the video below.');
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
    
        // Ensure that 'watched_to_completion' is true
        if (!$userTask->watched_to_completion) {
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
    
        return redirect()->route('user.tasks.index')
        ->with('success', 'Task completed successfully! You earned ' . $task->points . ' points.');
    }

    /**
 * Mark the task as watched to completion.
 *
 * @param  int  $userTaskId
 * @return \Illuminate\Http\JsonResponse
 */
public function markWatched($userTaskId)
{
    $user = Auth::user();
    $userTask = UserTask::where('id', $userTaskId)
        ->where('user_id', $user->id)
        ->where('status', 'started')
        ->first();

    if (!$userTask) {
        \Log::error('Invalid task attempt', ['user_id' => $user->id, 'task_id' => $userTaskId]);
        return response()->json(['success' => false, 'message' => 'Invalid task.'], 400);
    }

    try {
        $userTask->watched_to_completion = true;
        $userTask->save();

        // Log that the user has watched the video
        activity()
            ->causedBy($user)
            ->performedOn($userTask)
            ->log('Video Watched to Completion');

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        \Log::error('Error marking video as watched', [
            'error' => $e->getMessage(),
            'user_id' => $user->id,
            'task_id' => $userTaskId
        ]);
        return response()->json(['success' => false, 'message' => 'Error marking video as watched'], 500);
    }
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
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        $data = $request->only(['name', 'email', 'age', 'location']);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old profile image jika ada
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Simpan gambar baru
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $path;
        }

        $user->update($data);

        // Log profile update activity
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties(['updated_fields' => $data])
            ->log('Profile Updated');

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }


    /**
 * Handle daily check-in
 * 
 * @return \Illuminate\Http\RedirectResponse
 */
public function checkIn()
{
    $user = Auth::user();
    $now = now();

    // Get user's last check-in
    $lastCheckIn = DailyCheckIn::where('user_id', $user->id)
        ->latest()
        ->first();

    // Check if user already checked in today
    if ($lastCheckIn && $lastCheckIn->last_check_in->isToday()) {
        return redirect()->back()
            ->with('error', 'You have already checked in today!');
    }

    // Calculate day count and points
    $dayCount = 1;
    if ($lastCheckIn && $lastCheckIn->last_check_in->isYesterday()) {
        $dayCount = min($lastCheckIn->day_count + 1, 7);
    }

    // Calculate points (50 points × day count)
    $points = 50 * $dayCount;

    // Create new check-in record
    DailyCheckIn::create([
        'user_id' => $user->id,
        'day_count' => $dayCount,
        'last_check_in' => $now,
        'points_earned' => $points
    ]);

    // Add points to user
    $user->total_points += $points;
    $user->save();

    // Log the check-in activity
    activity()
        ->causedBy($user)
        ->withProperties([
            'day_count' => $dayCount,
            'points_earned' => $points
        ])
        ->log('Daily Check-in Complete');

    return redirect()->back()
        ->with('success', "Check-in successful! You earned {$points} points!");
}

/**
 * Get check-in status
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function checkInStatus()
{
    $user = Auth::user();
    $lastCheckIn = DailyCheckIn::where('user_id', $user->id)
        ->latest()
        ->first();

    $canCheckIn = !$lastCheckIn || !$lastCheckIn->last_check_in->isToday();
    $dayCount = 1;
    
    if ($lastCheckIn && $lastCheckIn->last_check_in->isYesterday()) {
        $dayCount = min($lastCheckIn->day_count + 1, 7);
    }

    $nextReward = 50 * $dayCount;

    return response()->json([
        'can_check_in' => $canCheckIn,
        'day_count' => $dayCount,
        'next_reward' => $nextReward
    ]);
}
}