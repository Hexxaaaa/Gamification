<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tasks = Task::paginate(10);
        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tasks.create');
    }

    /**
     * Store a newly created task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'description' => 'required|string',
            'points' => 'required|integer|min:0',
            'status' => 'required|in:pending,active,completed',
            'deadline' => 'required|date|after:today',
            'video_url' => 'required|url',
        ]);

        // Create a new task
        $task = Task::create($request->all());

        // Log task creation activity
        activity()
            ->causedBy(Auth::user()) // Assuming the admin is authenticated
            ->performedOn($task)
            ->withProperties(['task_id' => $task->id, 'description' => $task->description])
            ->log('Admin Created Task');

        // Redirect to the tasks index with a success message
        return redirect()->route('admin.tasks.index')
                         ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $task = Task::with(['comments.user', 'interactions.user'])->findOrFail($id);
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('admin.tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'description' => 'required|string',
            'points' => 'required|integer|min:0',
            'status' => 'required|in:pending,active,completed',
            'deadline' => 'required|date|after:today',
            'video_url' => 'required|url',
        ]);

        // Update the task with validated data
        $task->update($request->all());

        // Log task update activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($task)
            ->withProperties(['task_id' => $task->id, 'updated_fields' => $request->all()])
            ->log('Admin Updated Task');

        // Redirect to the tasks index with a success message
        return redirect()->route('admin.tasks.index')
                         ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        // Log task deletion activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($task)
            ->withProperties(['task_id' => $id, 'description' => $task->description])
            ->log('Admin Deleted Task');

        // Redirect to the tasks index with a success message
        return redirect()->route('admin.tasks.index')
                         ->with('success', 'Task deleted successfully.');
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

        return view('admin.tasks.statistics', compact('statistics'));
    }
}