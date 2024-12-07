<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use App\Models\UserVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use Storage;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard with various statistics.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Count of active users who are not admins
        $activeUsers = User::where('is_admin', false)->where('active', true)->count();

        // New users in the past month
        $newUsers = User::where('is_admin', false)
            ->where('created_at', '>=', now()->subMonth())
            ->count();

        // Count of completed tasks
        $completedTasks = DB::table('user_tasks')
            ->join('tasks', 'user_tasks.task_id', '=', 'tasks.id')
            ->join('users', 'user_tasks.user_id', '=', 'users.id')
            ->where('user_tasks.status', 'completed')
            ->count();

        // Sum of total points from all users
        $totalPoints = DB::table('user_tasks')
            ->join('tasks', 'user_tasks.task_id', '=', 'tasks.id')
            ->where('user_tasks.status', 'completed')
            ->sum('tasks.points'); //

        // Count of redeemed vouchers
        $redeemedVouchers = UserVoucher::count();

        $dailyTasks = UserTask::selectRaw('DATE(completion_date) as date, COUNT(*) as count')
            ->where('status', 'completed')
            ->whereDate('completion_date', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top 5 most completed tasks
        $topCompletedTasks = Task::select('id', 'video_url', 'description', \DB::raw('COUNT(*) as completion_count'))
            ->where('status', 'completed')
            ->groupBy('id', 'video_url', 'description')
            ->orderByDesc('completion_count')
            ->take(5)
            ->get();

        // User registrations data for charts
        $userRegistrations = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('is_admin', false)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Voucher redemptions data for charts
        $voucherRedemptions = UserVoucher::selectRaw('DATE(redeemed_at) as date, COUNT(*) as count')
            ->whereNotNull('redeemed_at')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Daily active users
        $dailyActiveUsers = User::where('is_admin', false)
            ->where('last_activity', '>=', now()->subDay())
            ->count();

        // Monthly active users
        $monthlyActiveUsers = User::where('is_admin', false)
            ->where('last_activity', '>=', now()->subMonth())
            ->count();

        $taskStatistics = DB::table('tasks')
            ->leftJoin('user_tasks', 'tasks.id', '=', 'user_tasks.task_id')
            ->select(
                'tasks.id',
                'tasks.description',
                DB::raw('COUNT(user_tasks.id) as user_tasks_count'),
                DB::raw('COUNT(DISTINCT user_tasks.user_id) as unique_users_count'),
                DB::raw('MAX(user_tasks.completion_date) as last_completion') // Changed from completed_at to completion_date
            )
            ->where('user_tasks.status', 'completed')
            ->groupBy('tasks.id', 'tasks.description')
            ->orderBy('user_tasks_count', 'desc')
            ->get();
        // Pass all data to the dashboard view
        return view('admin.dashboard', compact(
            'activeUsers',
            'newUsers',
            'completedTasks',
            'totalPoints',
            'redeemedVouchers',
            'dailyTasks',
            'topCompletedTasks',
            'userRegistrations',
            'voucherRedemptions',
            'dailyActiveUsers',
            'monthlyActiveUsers',
            'taskStatistics'
        ));
    }

    /**
     * Display a paginated list of activity logs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function viewActivities(Request $request)
    {
        // Optionally, add filters based on request parameters
        $activities = Activity::with(['causer', 'subject'])
            ->latest()
            ->paginate(20);

        return view('admin.activities', compact('activities'));
    }

    /**
     * Display a paginated list of users.
     *
     * @return \Illuminate\View\View
     */
    public function indexUsers()
    {
        $users = User::where('is_admin', false)->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:15',
            'age' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
            'active' => 'required|boolean',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone_number', 'age', 'location', 'is_admin', 'active']);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $path;
        }

        $user = User::create([
            'password' => Hash::make($request->password),
            'profile_image' => $data['profile_image'] ?? null,
            // Assign other fields...
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'age' => $data['age'],
            'location' => $data['location'],
            'is_admin' => $data['is_admin'],
            'active' => $data['active'],
        ]);

        activity()
            ->causedBy(auth()->user()) // Assuming the admin is authenticated
            ->performedOn($user)
            ->withProperties(['user_id' => $user->id, 'email' => $user->email])
            ->log('Admin Created User');

        return redirect()->route('admin.users.index')
            ->with('success', 'User added successfully.');
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:15',
            'age' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'is_admin' => 'required|boolean',
            'active' => 'required|boolean',
            // If updating password, add validation
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone_number', 'age', 'location', 'is_admin', 'active']);

        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

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

        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(['updated_fields' => $data])
            ->log('Admin Updated User');

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(['user_id' => $id, 'email' => $user->email])
            ->log('Admin Deleted User');

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Deactivate the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivateUser($id)
    {
        $user = User::findOrFail($id);
        $user->active = false;
        $user->save();

        // Log user deactivation
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(['user_id' => $id, 'email' => $user->email])
            ->log('Admin Deactivated User');

        return redirect()->route('admin.users.index')
            ->with('success', 'User deactivated successfully.');
    }
}