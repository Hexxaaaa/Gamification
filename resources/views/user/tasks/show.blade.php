@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <!-- Task Header -->
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="display-6 mb-1">{{ $userTask->task->description }}</h1>
                        <p class="text-muted mb-0">
                            <i class="bi bi-clock me-1"></i>Posted {{ $userTask->task->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="points-badge">
                        <span class="h4 mb-0">{{ $userTask->task->points }}</span>
                        <small class="d-block">Points</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Video Section -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-0">
                        @if ($userTask->task->video_type === 'youtube')
                            <div class="ratio ratio-16x9 rounded-3 overflow-hidden" id="video-container">
                                <iframe id="youtube-player"
                                    src="{{ $userTask->task->video_url }}?enablejsapi=1&origin={{ url('/') }}"
                                    title="Task Video"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @elseif($userTask->task->video_type === 'file')
                            <video id="task-video" class="w-100 rounded-3" controls>
                                <source src="{{ $userTask->task->video_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </div>
                </div>

                <!-- Interaction Section -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex gap-3 mb-4">
                            <!-- Like Button -->
                            <form action="{{ route('user.tasks.interaction', $userTask->task->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <input type="hidden" name="type" value="like">
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i
                                        class="bi bi-heart{{ $userTask->task->isLikedByUser(auth()->id()) ? '-fill' : '' }}"></i>
                                    <span class="ms-1">{{ $userTask->task->likes_count ?? 0 }}</span>
                                </button>
                            </form>

                            <!-- Share Button -->
                            <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#shareModal">
                                <i class="bi bi-share"></i>
                                <span class="ms-1">Share</span>
                            </button>
                        </div>

                        <!-- Comments Form -->
                        <form action="{{ route('user.tasks.interaction', $userTask->task->id) }}" method="POST"
                            class="mb-4">
                            @csrf
                            <input type="hidden" name="type" value="comment">
                            <div class="input-group">
                                <textarea name="comment" class="form-control" placeholder="Add a comment..." rows="1" required></textarea>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Comments List -->
                        <div class="comments-section">
                            @foreach ($userTask->task->comments()->latest()->get() as $comment)
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-circle">
                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">{{ $comment->user->name }}</h6>
                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Complete Task Card -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">Task Completion</h5>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%" id="video-progress"></div>
                        </div>
                        <form action="{{ route('user.tasks.complete', $userTask->id) }}" method="POST">
                            @csrf
                            <button type="submit" id="complete-task-btn" class="btn btn-success w-100 d-none">
                                <i class="bi bi-check-circle me-2"></i>Complete Task
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Share Modal -->
    <div class="modal fade" id="shareModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Share This Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Share Link:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="shareLink" value="{{ request()->url() }}"
                                readonly>
                            <button class="btn btn-primary" id="copyShareLink">
                                <i class="bi bi-clipboard"></i> Copy
                            </button>
                        </div>
                    </div>
                    <form id="shareForm" action="{{ route('user.tasks.interaction', $userTask->task->id) }}"
                        method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="type" value="share">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .points-badge {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            color: white;
            padding: 1rem;
            border-radius: 1rem;
            text-align: center;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            background-color: #6B73FF;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .comments-section {
            max-height: 400px;
            overflow-y: auto;
        }

        .progress {
            height: 0.5rem;
            border-radius: 1rem;
        }

        .progress-bar {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            transition: width 0.3s ease;
        }

        /* Custom scrollbar for comments */
        .comments-section::-webkit-scrollbar {
            width: 6px;
        }

        .comments-section::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .comments-section::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .comments-section::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Animations */
        .card {
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .btn {
            transition: all 0.2s ease;
        }

        textarea {
            resize: none;
            transition: height 0.2s ease;
        }

        textarea:focus {
            height: 100px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
        let player;
        let progressBar;
        let progressInterval;

        function getYouTubeVideoId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }

        function onYouTubeIframeAPIReady() {
            const videoUrl = "{{ $userTask->task->video_url }}";
            const videoId = getYouTubeVideoId(videoUrl);

            player = new YT.Player('youtube-player', {
                videoId: videoId,
                playerVars: {
                    'enablejsapi': 1,
                    'origin': window.location.origin,
                    'autoplay': 0,
                    'rel': 0
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function onPlayerReady(event) {
            progressBar = document.getElementById('video-progress');

            // Update progress every second
            progressInterval = setInterval(() => {
                if (player && player.getCurrentTime) {
                    const progress = (player.getCurrentTime() / player.getDuration()) * 100;
                    progressBar.style.width = `${progress}%`;
                }
            }, 1000);
        }

        function onPlayerStateChange(event) {
            if (event.data === YT.PlayerState.ENDED) {
                clearInterval(progressInterval);
                progressBar.style.width = '100%';
                showCompleteButton();
            }
        }

        function showCompleteButton() {
            fetch("{{ route('user.tasks.markWatched', $userTask->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const completeBtn = document.getElementById('complete-task-btn');
                        completeBtn.classList.remove('d-none');
                        completeBtn.classList.add('animate__animated', 'animate__fadeIn');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('task-video');
            if (video) {
                video.addEventListener('ended', showCompleteButton);
                video.addEventListener('timeupdate', () => {
                    const progress = (video.currentTime / video.duration) * 100;
                    document.getElementById('video-progress').style.width = `${progress}%`;
                });
            }
        });

        document.getElementById('copyShareLink').addEventListener('click', function() {
            // Copy link
            const shareLink = document.getElementById('shareLink');
            shareLink.select();
            document.execCommand('copy');

            // Submit share interaction
            document.getElementById('shareForm').submit();

            // Show feedback
            this.innerHTML = '<i class="bi bi-check"></i> Copied!';
            setTimeout(() => {
                this.innerHTML = '<i class="bi bi-clipboard"></i> Copy';
            }, 2000);
        });
    </script>
@endpush
