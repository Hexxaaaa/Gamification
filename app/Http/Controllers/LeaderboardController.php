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

        $userRank = User::where('is_admin', false)
        ->where('total_points', '>', $currentUser->total_points)
        ->count() + 1;
        
        // Get badges with status
    $badgesController = new BadgesController();
    $badges = $badgesController->leaderboardBadges();

        return view('user.leaderboard.index', compact(
            'topUsers',
            'leaderboardUsers',
            'currentUser',
            'badges',
            'userRank'
        ));
    }
}