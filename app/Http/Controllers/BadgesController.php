<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\UserBadge;
use App\Notifications\BadgeAchieved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgesController extends Controller
{
    public function index()
    {
        $badges = Badge::paginate(10);
        return view('admin.badges.index', compact('badges'));
    }

    public function create()
    {
        return view('admin.badges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:badges,name',
            'points_required' => 'required|integer|min:0',
            'description' => 'required|string',
            'level' => 'required|integer|min:1',
            'status' => 'required|in:collected,available,locked',
        ]);

        $badge = Badge::create($request->all());

        activity()
            ->causedBy(Auth::user())
            ->performedOn($badge)
            ->withProperties(['badge_id' => $badge->id, 'name' => $badge->name])
            ->log('Admin Created Badge');

        return redirect()->route('admin.badges.index')
            ->with('success', 'Badge created successfully.');
    }

    public function show($id)
    {
        $badge = Badge::findOrFail($id);
        return view('admin.badges.show', compact('badge'));
    }

    public function edit($id)
    {
        $badge = Badge::findOrFail($id);
        return view('admin.badges.edit', compact('badge'));
    }

    public function update(Request $request, $id)
    {
        $badge = Badge::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:badges,name,' . $badge->id,
            'points_required' => 'required|integer|min:0',
            'description' => 'required|string',
            'level' => 'required|integer|min:1',
            'status' => 'required|in:collected,available,locked',
        ]);

        $badge->update($request->all());

        activity()
            ->causedBy(Auth::user())
            ->performedOn($badge)
            ->withProperties(['badge_id' => $badge->id, 'updated_fields' => $request->all()])
            ->log('Admin Updated Badge');

        return redirect()->route('admin.badges.index')
            ->with('success', 'Badge updated successfully.');
    }

    public function destroy($id)
    {
        $badge = Badge::findOrFail($id);
        $badge->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($badge)
            ->withProperties(['badge_id' => $id, 'name' => $badge->name])
            ->log('Admin Deleted Badge');

        return redirect()->route('admin.badges.index')
            ->with('success', 'Badge deleted successfully.');
    }

    public function claim($id)
    {
        $user = Auth::user();
        $badge = Badge::findOrFail($id);

        \Log::info('Claiming badge', [
            'user_id' => $user->id,
            'badge_id' => $badge->id,
            'user_points' => $user->total_points,
            'badge_points' => $badge->points_required,
        ]);

        // Check if user already has this badge
        $userBadge = $user->userBadges()->where('badge_id', $id)->first();
        if ($userBadge && $userBadge->status === 'collected') {
            return redirect()->back()->with('error', 'You have already claimed this badge.');
        }

        // Check if user has enough points
        if ($user->total_points >= $badge->points_required) {
            if (!$userBadge) {
                $userBadge = new UserBadge([
                    'user_id' => $user->id,
                    'badge_id' => $badge->id,
                    'status' => 'collected',
                ]);
            } else {
                $userBadge->status = 'collected';
            }
            $userBadge->save();

            // Notify user
            $user->notify(new BadgeAchieved($badge));

            // Log the activity
            activity()
                ->causedBy($user)
                ->performedOn($badge)
                ->withProperties([
                    'badge_id' => $badge->id,
                    'points_required' => $badge->points_required,
                    'user_points' => $user->total_points,
                ])
                ->log('Badge Claimed');

            return redirect()->back()->with('success', 'Badge claimed successfully!');
        }

        return redirect()->back()->with('error', 'You do not have enough points to claim this badge.');
    }

    public function leaderboardBadges()
    {
        $user = auth()->user();

        $badges = Badge::orderBy('level', 'asc')->get()->map(function ($badge) use ($user) {
            // Check if user has claimed this badge
            $userBadge = $user->userBadges()->where('badge_id', $badge->id)->first();
            if ($userBadge) {
                $status = $userBadge->status;
            } elseif ($user->total_points >= $badge->points_required) {
                $status = 'available';
            } else {
                $status = 'locked';
            }

            return [
                'id' => $badge->id,
                'level' => $badge->level,
                'points' => $badge->points_required,
                'status' => $status,
            ];
        });

        return $badges;
    }
}