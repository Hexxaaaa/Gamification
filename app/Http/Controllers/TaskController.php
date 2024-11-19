<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'video_type' => 'required|in:file,youtube',
            'video_url' => 'required_if:video_type,youtube|url|nullable',
            'video_file' => 'required_if:video_type,file|file|mimetypes:video/mp4,video/quicktime|max:102400|nullable',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'featured' => 'sometimes|boolean',
        ]);

        // Handle thumbnail upload
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');

        // Handle video based on type
        $videoUrl = null;
        if ($request->video_type === 'file') {
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $videoUrl = Storage::url($videoPath);
        } else {
            $videoUrl = $this->formatYouTubeUrl($request->video_url);
        }

        // If the new task is featured, unfeature others
        if ($request->has('featured') && $request->featured) {
            Task::where('featured', true)->update(['featured' => false]);
        }

        // Create task with video and thumbnail
        $task = Task::create([
            'description' => $request->description,
            'points' => $request->points,
            'status' => $request->status,
            'deadline' => $request->deadline,
            'video_type' => $request->video_type,
            'video_url' => $videoUrl,
            'thumbnail_url' => Storage::url($thumbnailPath),
            'featured' => $request->featured ?? false, // Set featured
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($task)
            ->withProperties(['task_id' => $task->id, 'description' => $task->description])
            ->log('Admin Created Task');

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

        $request->validate([
            'description' => 'required|string',
            'points' => 'required|integer|min:0',
            'status' => 'required|in:pending,active,completed',
            'deadline' => 'required|date|after:today',
            'video_type' => 'required|in:file,youtube',
            'video_url' => 'required_if:video_type,youtube|url|nullable',
            'video_file' => 'required_if:video_type,file|file|mimetypes:video/mp4,video/quicktime|max:102400|nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'featured' => 'sometimes|boolean', // Added validation
        ]);

        $data = $request->except(['thumbnail', 'video_file', 'video_url']);

        // Handle thumbnail update if provided
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($task->thumbnail_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $task->thumbnail_url));
            }
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail_url'] = Storage::url($thumbnailPath);
        }

        // Handle video update
        if ($request->video_type === 'file' && $request->hasFile('video_file')) {
            // Delete old video if it was a file
            if ($task->video_type === 'file' && $task->video_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $task->video_url));
            }
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $data['video_url'] = Storage::url($videoPath);
        } elseif ($request->video_type === 'youtube') {
            $data['video_url'] = $this->formatYouTubeUrl($request->video_url);
        }

        // Handle featured status
        if ($request->has('featured') && $request->featured && !$task->featured) {
            // Unfeature all other tasks
            Task::where('featured', true)->update(['featured' => false]);
        }
        $data['featured'] = $request->featured ?? $task->featured;

        $task->update($data);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($task)
            ->withProperties(['task_id' => $task->id, 'updated_fields' => $data])
            ->log('Admin Updated Task');

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

     /**
     * Format YouTube URL to embedded format
     *
     * @param string $url
     * @return string
     */
    private function formatYouTubeUrl($url)
    {
        $videoId = '';
        
        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
            $videoId = $matches[1];
        } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches)) {
            $videoId = $matches[1];
        } elseif (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $matches)) {
            $videoId = $matches[1];
        } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }

        return 'https://www.youtube.com/embed/' . $videoId;
    }
}