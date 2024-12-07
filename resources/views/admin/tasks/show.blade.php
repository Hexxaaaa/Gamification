@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 mb-1">Task Details</h1>
            <p class="text-muted mb-0">Viewing task #{{ $task->id }}</p>
        </div>
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Back to Tasks
        </a>
    </div>

    <div class="row g-4">
        <!-- Main Task Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body p-4">
                    <!-- Description -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-3">Description</h5>
                        <p class="mb-0">{{ $task->description }}</p>
                    </div>

                    <hr class="my-4">

                    <!-- Task Metadata -->
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-star-half-alt text-warning h4 mb-0 me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Points</small>
                                        <strong>{{ number_format($task->points) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock text-info h4 mb-0 me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Status</small>
                                        <strong>{{ ucfirst($task->status) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-alt text-danger h4 mb-0 me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Deadline</small>
                                        <strong>{{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Video Section -->
                    @if($task->video_url)
                        <div class="mt-4">
                            <h5 class="text-primary mb-3">Video Content</h5>
                            <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow-sm">
                                @if($task->video_type === 'file')
                                    <video controls>
                                        <source src="{{ $task->video_url }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <iframe src="{{ $task->video_url }}" allowfullscreen></iframe>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Thumbnail -->
            @if($task->thumbnail_url)
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-4">
                        <h5 class="text-primary mb-3">Thumbnail</h5>
                        <img src="{{ $task->thumbnail_url }}" 
                             alt="Task Thumbnail" 
                             class="img-fluid rounded-3 shadow-sm w-100"
                             style="object-fit: cover;">
                    </div>
                </div>
            @endif

            <!-- Featured Status -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="fs-1 me-3">
                            @if($task->featured)
                                <i class="fas fa-star text-warning"></i>
                            @else
                                <i class="far fa-star text-muted"></i>
                            @endif
                        </div>
                        <div>
                            <h5 class="mb-1">Featured Status</h5>
                            <p class="mb-0 text-muted">
                                {{ $task->featured ? 'This is a featured task' : 'This is a regular task' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interactions and Comments -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h5 class="text-primary mb-4">Interactions & Comments</h5>

                    @if($task->interactions->isEmpty())
                        <p class="text-muted mb-0">No interactions or comments available.</p>
                    @else
                        <div class="row g-4">
                            <!-- Interactions -->
                            <div class="col-md-4">
                                <h6 class="mb-3">Recent Interactions</h6>
                                <div class="list-group list-group-flush">
                                    @foreach($task->interactions->where('type', '!=', 'comment')->take(5) as $interaction)
                                        <div class="list-group-item px-0">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary-subtle text-primary me-2">
                                                    {{ ucfirst($interaction->type) }}
                                                </span>
                                                <small class="text-muted">
                                                    by <strong>{{ $interaction->user->name }}</strong>
                                                    • {{ $interaction->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Comments -->
                            <div class="col-md-8">
                                <h6 class="mb-3">Comments</h6>
                                <div class="comments-list">
                                    @foreach($task->interactions->where('type', 'comment') as $comment)
                                        <div class="d-flex mb-3">
                                            <div class="flex-shrink-0">
                                                <div class="avatar bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex align-items-center mb-1">
                                                    <h6 class="mb-0">{{ $comment->user->name }}</h6>
                                                    <small class="text-muted ms-2">
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                                <p class="mb-0">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .avatar {
        font-size: 1.2rem;
        font-weight: 500;
    }
    .comments-list {
        max-height: 500px;
        overflow-y: auto;
    }
    .badge {
        font-weight: 500;
    }
</style>
@endpush
@endsection