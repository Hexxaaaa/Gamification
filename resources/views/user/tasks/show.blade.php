<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TASK SESSION</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ url('css/task.css') }}">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="#">
                    <img src="{{ url('gallery/logopointplay.png') }}" alt="logobrand" style="width: 100px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/task">Tasks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/rewards">Rewards</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/leaderboard">Leaderboard</a>
                        </li>
                    </ul>
                </div>
                <div class="ms-3 d-flex align-items-center">
                    <span class="points">{{ number_format($userTask->user->total_points) }} PTS</span>
                    <a href="{{ route('user.profile.show') }}">
                        @if ($userTask->user->profile_image)
                            <img src="{{ asset('storage/' . $userTask->user->profile_image) }}"
                                alt="{{ $userTask->user->name }}'s Avatar" class="rounded-circle ms-2" width="40px">
                        @else
                            <img src="{{ url('gallery/userfoto.png') }}" alt="Default Avatar"
                                class="rounded-circle ms-2" width="40px">
                        @endif
                    </a>
                </div>

            </div>
        </nav>
    </header>

    <main class="py-5">
        <div class="container">
            <div class="video-container position-relative">
                @if ($userTask->task->video_type === 'youtube')
                    <iframe id="youtube-player" width="100%" height="600"
                        src="{{ $userTask->task->video_url }}?enablejsapi=1&origin={{ url('/') }}" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                @elseif($userTask->task->video_type === 'file')
                    <video id="task-video" width="100%" height="600" controls>
                        <source src="{{ $userTask->task->video_url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>

            <!-- Progress bar -->
            <div class="progress mt-3" style="height: 0.5rem;">
                <div class="progress-bar" role="progressbar" style="width: 0%" id="video-progress"></div>
            </div>

            <div class="mt-4 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary">Continue Watching</button>
                <form action="{{ route('user.tasks.complete', $userTask->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" id="complete-task-btn" class="btn btn-success d-none">
                        Complete Task
                    </button>
                </form>
            </div>

            <h3 class="mt-4">Experience the Fun of Progress</h3>
            <p>{{ $userTask->task->description }}</p>
            <div class="action-buttons d-flex gap-5">
                <button
                    class="btn btn-outline-primary interact-btn {{ in_array('like', $userInteractions) ? 'active' : '' }}"
                    data-type="like" data-task="{{ $userTask->task_id }}" data-points="10">
                    <img src="{{ url('gallery/like.png') }}" alt="iconjempol" style="width: 30px">
                    <span class="d-block mt-1">+10 pts</span>
                </button>

                <button
                    class="btn btn-outline-primary interact-btn {{ in_array('share', $userInteractions) ? 'active' : '' }}"
                    data-type="share" data-task="{{ $userTask->task_id }}" data-points="50" data-bs-toggle="modal"
                    data-bs-target="#shareModal">
                    <img src="{{ url('gallery/sharetask.png') }}" alt="iconshare" style="width: 30px">
                    <span class="d-block mt-1">+50 pts</span>
                </button>

                <button
                    class="btn btn-outline-primary interact-btn {{ in_array('comment', $userInteractions) ? 'active' : '' }}"
                    data-type="comment" data-task="{{ $userTask->task_id }}" data-points="20" data-bs-toggle="modal"
                    data-bs-target="#commentModal">
                    <img src="{{ url('gallery/commentask.png') }}" alt="iconkomen" style="width: 30px">
                    <span class="d-block mt-1">+20 pts</span>
                </button>
            </div>

            <p>Discover a platform where every action counts! Watch videos, like, comment, and share to earn points
                effortlessly. Turn your daily interactions into exciting rewards and climb the leaderboard with
                every step forward. Whether you're enjoying your favorite content or unlocking exclusive perks,
                PointPlay makes every moment rewarding. Start now and experience progress like never before!</p>
            <div class="row mt-5">
                @foreach ($relatedTasks as $relatedTask)
                    <div class="col-6 col-md-3">
                        <iframe width="100%" height="150" src="{{ $relatedTask->video_url }}"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Add Share Modal -->
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
                                <input type="text" class="form-control" id="shareLink"
                                    value="{{ request()->url() }}" readonly>
                                <button class="btn btn-primary" id="copyShareLink">
                                    <i class="bi bi-clipboard"></i> Copy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comment Modal -->
        <div class="modal fade" id="commentModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Comment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="commentText" class="form-label">Your Comment:</label>
                            <textarea class="form-control" id="commentText" rows="3" required></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" id="submitComment">
                            <i class="bi bi-send"></i> Submit Comment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container text-center">

            <div class="d-flex justify-content-center gap-3">
                <a href="#"><i class="bi bi-youtube"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-twitter"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
    </footer>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>

    <script>
        let player;
        let progressBar;
        let progressInterval;

        // YouTube player initialization
        function onYouTubeIframeAPIReady() {
            const videoUrl = "{{ $userTask->task->video_url }}";
            const videoId = getYouTubeVideoId(videoUrl);

            if (document.getElementById('youtube-player')) {
                player = new YT.Player('youtube-player', {
                    videoId: videoId,
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    },
                    playerVars: {
                        'enablejsapi': 1,
                        'origin': window.location.origin,
                        'autoplay': 0,
                        'rel': 0
                    }
                });
            }
        }

        // YouTube helper functions
        function getYouTubeVideoId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }

        function onPlayerReady(event) {
            progressBar = document.getElementById('video-progress');
            // Update task status to 'started' when video is ready
            fetch("{{ route('user.tasks.start', $userTask->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            updateProgressBar();
        }

        function onPlayerStateChange(event) {
            if (event.data === YT.PlayerState.PLAYING) {
                updateProgressBar();
            } else if (event.data === YT.PlayerState.ENDED) {
                clearInterval(progressInterval);
                progressBar.style.width = '100%';
                showCompleteButton();
            }
        }

        // Progress tracking
        function updateProgressBar() {
            if (!progressInterval && player && player.getCurrentTime) {
                progressInterval = setInterval(() => {
                    if (player.getPlayerState() === YT.PlayerState.PLAYING) {
                        const duration = player.getDuration();
                        const currentTime = player.getCurrentTime();
                        const progress = (currentTime / duration) * 100;

                        progressBar.style.width = `${progress}%`;

                        if (progress >= 95) {
                            clearInterval(progressInterval);
                            progressBar.style.width = '100%';
                            showCompleteButton();
                        }
                    }
                }, 1000);
            }
        }

        // HTML5 video handling
        const video = document.getElementById('task-video');
        if (video) {
            video.addEventListener('play', () => {
                // Update task status to 'started' when video starts playing
                fetch("{{ route('user.tasks.start', $userTask->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            });
            video.addEventListener('timeupdate', () => {
                const progress = (video.currentTime / video.duration) * 100;
                progressBar.style.width = `${progress}%`;

                if (progress >= 95) {
                    showCompleteButton();
                }
            });

            video.addEventListener('ended', showCompleteButton);
        }

        // Task completion handling
        function showCompleteButton() {
            fetch("{{ route('user.tasks.markWatched', $userTask->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('complete-task-btn').classList.remove('d-none');
                    }
                });
        }

        $(document).ready(function() {
            // General interaction handler for like/share/comment buttons
            $('.interact-btn').click(function() {
                const button = $(this);
                const type = button.data('type');

                // If it's a comment, let the comment modal handle it
                if (type === 'comment') {
                    return;
                }

                handleInteraction(button);
            });

            // Share functionality
            $('#copyShareLink').click(function() {
                const shareBtn = $('.interact-btn[data-type="share"]');

                if (shareBtn.hasClass('active')) {
                    showNotification('info', 'Already Shared', 'You have already shared this task!');
                    return;
                }

                const shareLink = document.getElementById('shareLink');
                shareLink.select();
                document.execCommand('copy');

                // Update copy button UI
                this.innerHTML = '<i class="bi bi-check"></i> Copied!';
                setTimeout(() => {
                    this.innerHTML = '<i class="bi bi-clipboard"></i> Copy';
                }, 2000);

                // Trigger share interaction
                handleInteraction(shareBtn);
            });

            // Comment functionality
            $('#submitComment').click(function() {
                const commentBtn = $('.interact-btn[data-type="comment"]');
                const commentText = $('#commentText').val().trim();

                // Validate empty comment
                if (!commentText) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Empty Comment',
                        text: 'Please write something before submitting.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return;
                }

                // Check if already commented
                if (commentBtn.hasClass('active')) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Already Commented',
                        text: 'You have already commented on this task!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return;
                }

                // Submit comment
                $.ajax({
                    url: "{{ route('user.tasks.interaction', ['task' => ':taskId']) }}".replace(
                        ':taskId', commentBtn.data('task')),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        type: 'comment',
                        comment: commentText
                    },
                    success: function(response) {
                        if (response.success) {

                            // Mark as commented
                            commentBtn.addClass('active');

                            // Update points
                            updatePoints(commentBtn.data('points'));

                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Comment Posted!',
                                text: `+${commentBtn.data('points')} points for commenting!`,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            // Reset form
                            $('#commentText').val('');
                            $('#commentModal').modal('hide');

                            // Disable comment button
                            commentBtn.prop('disabled', true);
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to post comment!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });
            });

            // Helper Functions
            function handleInteraction(button) {
                const type = button.data('type');
                const taskId = button.data('task');
                const points = button.data('points');

                if (button.hasClass('active')) {
                    showNotification('info', 'Already Interacted', `You have already ${type}d this task!`);
                    return;
                }

                $.ajax({
                    url: "{{ route('user.tasks.interaction', ['task' => ':taskId']) }}".replace(':taskId',
                        taskId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        type: type
                    },
                    success: function(response) {
                        if (response.success) {
                            button.addClass('active');
                            updatePoints(points);
                            showNotification('success', 'Points Earned!',
                                `+${points} points for ${type}ing this task!`);
                            button.prop('disabled', true);
                        }
                    },
                    error: function() {
                        showNotification('error', 'Oops...', 'Something went wrong!');
                    }
                });
            }

            function showNotification(icon, title, text) {
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: text,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }


            function updatePoints(points) {
                const pointsElement = $('.points');
                const currentPoints = parseInt(pointsElement.text().replace(/[^0-9]/g, ''));
                pointsElement.text(`${(currentPoints + points).toLocaleString()} PTS`);
            }
        });
    </script>
</body>

</html>
