@extends('layouts.app')

@section('title', 'Your Tasks')

@section('content')
<div class="container mt-5">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-4">Your Tasks</h1>
        <p class="lead text-muted">Manage and track your tasks efficiently</p>
    </div>

    <!-- Task Tabs -->
    <ul class="nav nav-pills justify-content-center mb-4" id="taskTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="available-tasks-tab" data-bs-toggle="tab" data-bs-target="#available-tasks" type="button" role="tab" aria-controls="available-tasks" aria-selected="true">
                Available Tasks
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="in-progress-tasks-tab" data-bs-toggle="tab" data-bs-target="#in-progress-tasks" type="button" role="tab" aria-controls="in-progress-tasks" aria-selected="false">
                In Progress
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="completed-tasks-tab" data-bs-toggle="tab" data-bs-target="#completed-tasks" type="button" role="tab" aria-controls="completed-tasks" aria-selected="false">
                Completed Tasks
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="taskTabsContent">
                <!-- Available Tasks -->
        <div class="tab-pane fade show active" id="available-tasks" role="tabpanel" aria-labelledby="available-tasks-tab">
            @if($tasks->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($tasks as $task)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <!-- Task Thumbnail -->
                                @if($task->thumbnail_url)
                                    <img src="{{ $task->thumbnail_url }}" class="card-img-top" alt="{{ $task->title }}">
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $task->title }}</h5>
                                    <p class="card-text">{{ Str::limit($task->description, 100) }}</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-primary"><i class="bi bi-star-fill me-1"></i>{{ $task->points }} Points</span>
                                            <small class="text-muted">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}</small>
                                        </div>
                                        <!-- View Details Button -->
                                        <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->id }}">
                                            <i class="bi bi-info-circle me-1"></i>View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <!-- Task Modal -->
                        <div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1" aria-labelledby="taskModalLabel{{ $task->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="taskModalLabel{{ $task->id }}">{{ $task->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Video Content -->
                                        @if($task->video_type === 'youtube')
                                            <div class="ratio ratio-16x9 mb-3">
                                                <iframe src="{{ $task->video_url }}" title="{{ $task->title }}" allowfullscreen></iframe>
                                            </div>
                                        @elseif($task->video_type === 'file')
                                            <video class="w-100 mb-3" controls>
                                                <source src="{{ $task->video_url }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                        <!-- Task Description -->
                                        <p>{{ $task->description }}</p>
                                        <!-- Additional Info -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-primary"><i class="bi bi-star-fill me-1"></i>{{ $task->points }} Points</span>
                                            <small class="text-muted">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('user.tasks.take', $task->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-check-circle me-1"></i>Take Task
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $tasks->links() }}
                </div>
            @else
                <div class="alert alert-info text-center mt-4">
                    No available tasks at the moment.
                </div>
            @endif
        </div>

        <!-- In Progress Tasks -->
        <div class="tab-pane fade" id="in-progress-tasks" role="tabpanel" aria-labelledby="in-progress-tasks-tab">
            @if($inProgressTasks->count() > 0)
                <div class="list-group mt-4">
                    @foreach($inProgressTasks as $userTask)
                    <a href="{{ route('user.tasks.show', $userTask->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">{{ $userTask->task->description }}</h5>
                                <small class="text-muted">Started on: {{ $userTask->created_at }}</small>
                            </div>
                            <span class="badge bg-warning text-dark">In Progress</span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center mt-4">
                    You have no tasks in progress.
                </div>
            @endif
        </div>

        <!-- Completed Tasks -->
        <div class="tab-pane fade" id="completed-tasks" role="tabpanel" aria-labelledby="completed-tasks-tab">
            @if($completedTasks->count() > 0)
                <div class="list-group mt-4">
                    @foreach($completedTasks as $userTask)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">{{ $userTask->task->title }}</h5>
                                <small class="text-muted">Completed on: {{ $userTask->completion_date }}</small>
                            </div>
                            <div>
                                <span class="badge bg-success"><i class="bi bi-check2-circle me-1"></i>Completed</span>
                                <div class="mt-1 text-end">
                                    <small class="text-muted">Points Earned: {{ $userTask->task->points }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center mt-4">
                    You have not completed any tasks yet.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection