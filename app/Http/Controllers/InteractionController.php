<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\InteractionCreated;
use App\Models\Interaction;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    /**
     * Store a new interaction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $taskId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $taskId)
    {
        // Validate the incoming request data
        $request->validate([
            'type' => 'required|in:view,like,share,comment',
            'comment' => 'required_if:type,comment|string|max:500',
        ]);

        // Determine the content based on the interaction type
        $content = $request->type === 'comment' ? $request->comment : null;

        // Create the interaction
        $interaction = Interaction::create([
            'user_id' => Auth::id(),
            'task_id' => $taskId,
            'type' => $request->type,
            'content' => $content,
        ]);

        // Fire the InteractionCreated event
        event(new InteractionCreated($interaction));

        // Log the interaction using Spatie's Activity Log
        activity()
            ->causedBy(Auth::user())
            ->performedOn($interaction)
            ->withProperties(['type' => $interaction->type, 'task_id' => $taskId])
            ->log('User created interaction');

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Interaction recorded successfully.');
    }
}