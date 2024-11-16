<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Badge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BadgesController extends Controller
{
    /**
     * Display a listing of the badges.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $badges = Badge::paginate(10);
        return view('admin.badges.index', compact('badges'));
    }

    /**
     * Show the form for creating a new badge.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.badges.create');
    }

    /**
     * Store a newly created badge in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255|unique:badges,name',
            'points_required' => 'required|integer|min:0',
            'description' => 'required|string',
        ]);

        // Create a new badge
        $badge = Badge::create($request->all());

        // Log badge creation activity
        activity()
            ->causedBy(Auth::user()) // Assuming the admin is authenticated
            ->performedOn($badge)
            ->withProperties(['badge_id' => $badge->id, 'name' => $badge->name])
            ->log('Admin Created Badge');

        // Redirect to the badges index with a success message
        return redirect()->route('admin.badges.index')
                         ->with('success', 'Badge created successfully.');
    }

    /**
     * Display the specified badge.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $badge = Badge::findOrFail($id);
        return view('admin.badges.show', compact('badge'));
    }

    /**
     * Show the form for editing the specified badge.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $badge = Badge::findOrFail($id);
        return view('admin.badges.edit', compact('badge'));
    }

    /**
     * Update the specified badge in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $badge = Badge::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255|unique:badges,name,' . $badge->id,
            'points_required' => 'required|integer|min:0',
            'description' => 'required|string',
        ]);

        // Update the badge with validated data
        $badge->update($request->all());

        // Log badge update activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($badge)
            ->withProperties(['badge_id' => $badge->id, 'updated_fields' => $request->all()])
            ->log('Admin Updated Badge');

        // Redirect to the badges index with a success message
        return redirect()->route('admin.badges.index')
                         ->with('success', 'Badge updated successfully.');
    }

    /**
     * Remove the specified badge from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $badge = Badge::findOrFail($id);
        $badge->delete();

        // Log badge deletion activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($badge)
            ->withProperties(['badge_id' => $id, 'name' => $badge->name])
            ->log('Admin Deleted Badge');

        // Redirect to the badges index with a success message
        return redirect()->route('admin.badges.index')
                         ->with('success', 'Badge deleted successfully.');
    }
}