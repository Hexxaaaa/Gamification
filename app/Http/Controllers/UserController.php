<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\DailyCheckIn;
use App\Models\Interaction;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use App\Models\UserVoucher;
use App\Models\Voucher;
use App\Notifications\BadgeAchieved;
use App\Notifications\PointsEarned;
use App\Notifications\TaskCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // Get user's interactions
        $interactions = $user->interactions()
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        // Get total points and other metrics
        $totalPoints = $user->total_points;
        $totalMissions = Task::where('status', 'active')->count();
        $engagedUsers = User::whereHas('userTasks')->count();

        // Gamification highlights
        $gamificationHighlights = [
            'highly rewarding mission',
            'engaged users worldwide',
            'Transparent and fair challenges',
        ];

        // Featured tasks for slider
        $featuredTasks = Task::where('featured', true)
            ->where('status', 'active')
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'user',
            'interactions',
            'totalPoints',
            'totalMissions',
            'engagedUsers',
            'gamificationHighlights',
            'featuredTasks'
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
            ->where(function ($query) {
                $query->where('deadline', '>', now())
                    ->orWhereNull('deadline');
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
            ->with(['task', 'user'])
            ->firstOrFail();

        // Get related tasks (you can customize this query)
        $relatedTasks = Task::where('id', '!=', $userTask->task_id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        // Check if user has interacted with this task
        $userInteractions = $userTask->task->interactions()
            ->where('user_id', Auth::id())
            ->pluck('type')
            ->toArray();

        return view('user.tasks.show', compact('userTask', 'relatedTasks', 'userInteractions'));
    }

    /**
     * Start a Task.
     *
     * @param  int  $taskId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function startTask($userTaskId)
    {
        $userTask = UserTask::where('id', $userTaskId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($userTask->status === 'pending') {
            $userTask->update([
                'status' => 'started',
                'started_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
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
    public function markVideoWatched(Request $request, UserTask $userTask)
    {
        // Ensure the user owns this task
        if ($userTask->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Check if already watched
        if (!$userTask->watched_to_completion) {
            $userTask->update([
                'watched_to_completion' => true,
                'completion_date' => now(), // Changed from completed_at to completion_date
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Video already watched']);
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

    /**
     * Log Interaction (Like, Comment, Share).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logInteraction(Request $request, Task $task)
    {
        try {
            $request->validate([
                'type' => 'required|in:like,comment,share',
                'comment' => 'required_if:type,comment|string|max:500',
            ]);

            // Check if interaction already exists
            if (Auth::user()->interactions()->where('task_id', $task->id)->where('type', $request->type)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Already interacted with this task',
                ], 400);
            }

            $interaction = Interaction::create([
                'user_id' => Auth::id(),
                'task_id' => $task->id,
                'type' => $request->type,
                'content' => $request->comment ?? null,
            ]);

            // Assign points based on interaction type
            switch ($request->type) {
                case 'like':
                    $points = 10;
                    break;
                case 'comment':
                    $points = 20;
                    break;
                case 'share':
                    $points = 50;
                    break;
                default:
                    $points = 0;
            }

            $user = Auth::user();
            if ($points > 0) {
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

            // Check and award badges
            $newBadges = [];
            $badges = Badge::where('points_required', '<=', $user->total_points)->get();
            foreach ($badges as $badge) {
                if (!$user->badges()->where('badge_id', $badge->id)->exists()) {
                    $user->badges()->attach($badge->id);
                    $user->notify(new BadgeAchieved($badge));
                    $newBadges[] = $badge;

                    activity()
                        ->causedBy($user)
                        ->performedOn($badge)
                        ->withProperties(['badge_id' => $badge->id])
                        ->log('Badge Achieved');
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Interaction recorded successfully',
                'data' => [
                    'interaction' => $interaction,
                    'points_earned' => $points,
                    'total_points' => $user->total_points,
                    'new_badges' => $newBadges,
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to record interaction',
                'error' => $e->getMessage(),
            ], 500);
        }
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
        $taskHistory = $user->userTasks()
            ->with('task')
            ->where('status', 'completed')
            ->get();
        $vouchers = $user->userVouchers()
            ->with('voucher')
            ->latest()
            ->take(3) // Get last 3 vouchers
            ->get();
        $interactions = $user->interactions()
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        $taskStats = [
            'like' => $user->interactions()->where('type', 'like')->count(),
            'comment' => $user->interactions()->where('type', 'comment')->count(),
            'share' => $user->interactions()->where('type', 'share')->count(),
        ];
        $taskCompletion = round(
            ($user->userTasks()->where('status', 'completed')->count() /
                Task::count()) * 100
        );

        return view('user.profile.show', compact(
            'user',
            'taskHistory',
            'vouchers',
            'interactions',
            'taskStats',
            'taskCompletion'
        ));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
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
            'gender' => 'required|in:Male,Female',
            'location' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        $data = $request->only(['name', 'email', 'age', 'gender', 'location']);

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

        return redirect()->route('user.profile.show')
            ->with('success', 'Profile updated successfully.');
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
            return response()->json([
                'success' => false,
                'message' => 'Already checked in today',
            ], 400);
        }

        // Calculate day count and points
        $dayCount = 1; // Reset to 1 by default

        // Only maintain streak if checked in yesterday
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
            'points_earned' => $points,
        ]);

        // Add points to user
        $user->total_points += $points;
        $user->save();

        // Log the check-in activity
        activity()
            ->causedBy($user)
            ->withProperties([
                'day_count' => $dayCount,
                'points_earned' => $points,
            ])
            ->log('Daily Check-in Complete');

        return response()->json([
            'success' => true,
            'points' => $points,
            'day_count' => $dayCount,
        ]);
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

        return response()->json([
            'can_check_in' => $canCheckIn,
            'next_reward' => 50 * $dayCount,
        ]);
    }
}