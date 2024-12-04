<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Get top 3 users for the podium
        $topUsers = User::orderBy('total_points', 'desc')
                       ->take(3)
                       ->get();

        // Get top 5 users for the leaderboard list
        $leaderboardUsers = User::orderBy('total_points', 'desc')
                               ->take(5)
                               ->get();

        // Get authenticated user
        $currentUser = auth()->user();

        // Get badge levels data from the database
        $badges = Badge::all()->map(function ($badge) use ($currentUser) {
            $status = $badge->status;
            // Update status to 'available' if user has enough points
            if ($status === 'locked' && $currentUser->total_points >= $badge->points_required) {
                $status = 'available';
            }
            
            return [
                'id' => $badge->id,
                'level' => $badge->level,
                'points_required' => $badge->points_required,
                'status' => $status,
            ];
        });

        return view('user.leaderboard.index', compact(
            'topUsers',
            'leaderboardUsers',
            'currentUser',
            'badges'
        ));
    }
}