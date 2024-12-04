<?php

namespace App\Http\Controllers;

use App\Models\Badge;
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

        if ($user->total_points >= $badge->points_required) {
            $user->badges()->attach($badge->id);
            $badge->update(['status' => 'collected']);

            activity()
                ->causedBy($user)
                ->performedOn($badge)
                ->withProperties(['badge_id' => $badge->id])
                ->log('Badge Claimed');

            return redirect()->back()->with('success', 'Badge claimed successfully!');
        }

        return redirect()->back()->with('error', 'You do not have enough points to claim this badge.');
    }
}