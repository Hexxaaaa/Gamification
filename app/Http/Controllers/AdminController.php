<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Task;
use App\Models\UserVoucher;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard with various statistics.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $activeUsers = User::where('is_admin', false)->where('active', true)->count();
        $newUsers = User::where('is_admin', false)
                        ->where('created_at', '>=', now()->subMonth())
                        ->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $totalPoints = User::sum('total_points');
        $redeemedVouchers = UserVoucher::count();
    
        // Data for charts/graphs
        $tasksPerMonth = Task::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                            ->groupBy('month')
                            ->get();
    
        // Most Frequently Completed Tasks
        $topCompletedTasks = Task::select('id', 'video_url', 'description', \DB::raw('COUNT(*) as completion_count'))
                                  ->where('status', 'completed')
                                  ->groupBy('id', 'video_url', 'description')
                                  ->orderByDesc('completion_count')
                                  ->take(5)
                                  ->get();
    
        // Additional Graph Data
        $userRegistrations = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                                 ->where('is_admin', false)
                                 ->groupBy('date')
                                 ->orderBy('date')
                                 ->get();
    
        $voucherRedemptions = UserVoucher::selectRaw('DATE(redeemed_at) as date, COUNT(*) as count')
                                         ->whereNotNull('redeemed_at')
                                         ->groupBy('date')
                                         ->orderBy('date')
                                         ->get();
    
        // Usage Trends
        $dailyActiveUsers = User::where('is_admin', false)
                                ->where('last_activity', '>=', now()->subDay())
                                ->count();
    
        $monthlyActiveUsers = User::where('is_admin', false)
                                  ->where('last_activity', '>=', now()->subMonth())
                                  ->count();
    
        // Pass all data to the dashboard view
        return view('admin.dashboard', compact(
            'activeUsers',
            'newUsers',
            'completedTasks',
            'totalPoints',
            'redeemedVouchers',
            'tasksPerMonth',
            'topCompletedTasks',
            'userRegistrations',
            'voucherRedemptions',
            'dailyActiveUsers',
            'monthlyActiveUsers'
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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'age' => $request->age,
            'location' => $request->location,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin,
            'active' => $request->active,
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
        ]);

        $data = $request->only(['name', 'email', 'phone_number', 'age', 'location', 'is_admin', 'active']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(['updated_fields' => $request->all()])
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