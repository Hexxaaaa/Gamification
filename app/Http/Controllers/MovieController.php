<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    /**
     * Display the movie listing page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        // Get featured movies (large cards at top)
        $featuredMovies = Task::where('featured', true)
        ->where('status', 'active')
        ->orderBy('created_at', 'desc')
        ->take(6)  // Increased from 3 to 6
        ->get();

        // Get movies for the grid section with search functionality
        $query = Task::where('status', 'active');

        if ($request->has('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $movies = $query->orderBy('created_at', 'desc')
            ->paginate(6); // 6 items for the grid

        // Get movies for bottom section
        $bottomMovies = Task::where('status', 'active')
            ->orderBy('points', 'desc') // Sort by points to show highest value content
            ->take(5)
            ->get();

        $inProgressTasks = $user->userTasks()
            ->with('task')
            ->whereIn('status', ['pending', 'started'])
            ->get()
            ->map(function ($userTask) {
                // Add progress calculation
                if ($userTask->status === 'started') {
                    $userTask->progress = $userTask->watched_to_completion ? 100 : 0;
                }
                return $userTask;
            });

        // Get total number of tasks in queue
        $totalInQueue = Task::where('status', 'active')->count();

        return view('user.tasks.index', compact(
            'featuredMovies',
            'movies',
            'bottomMovies',
            'inProgressTasks',
            'totalInQueue'
        ));
    }

    /**
     * Search for movies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->input('search');

        $results = Task::where('status', 'active')
            ->where('description', 'like', '%' . $query . '%')
            ->take(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }
}