<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/tugas.css') }}">
    <style>
        .hover-overlay {
            transition: opacity 0.3s ease;
        }

        .card:hover .hover-overlay {
            opacity: 1 !important;
        }

        .transform-scale {
            transition: transform 0.3s ease;
        }

        .transform-scale:hover {
            transform: scale(1.1);
        }
    </style>

</head>

<body>
    @include('layouts.header')
    <div class="container py-5">
        <!-- Animated Section Header -->
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="position-relative mb-4">
                    <div class="badge bg-primary bg-gradient px-4 py-2 rounded-pill mb-3 shadow-sm">
                        <i class="fas fa-crown me-2"></i>Featured Tasks
                    </div>
                    <h2 class="display-4 fw-bold mb-3">Special Tasks</h2>
                    <p class="lead text-muted">Complete these featured tasks to earn bonus points and exclusive rewards!
                    </p>
                    <div class="position-relative">
                        <hr class="w-25 mx-auto my-4 bg-primary opacity-75" style="height: 3px;">
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3">
                            <i class="fas fa-star text-warning"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Tasks Grid -->
        <div class="row g-4">
            @foreach ($featuredMovies as $movie)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 bg-light shadow-sm position-relative overflow-hidden">
                        <!-- Floating Badge -->
                        <div class="position-absolute top-0 start-0 p-3 z-index-1">
                            <span class="badge bg-warning bg-gradient px-3 py-2 rounded-pill shadow-sm">
                                <i class="fas fa-star me-1"></i>Featured
                            </span>
                        </div>

                        <!-- Card Image with Overlay -->
                        <div class="position-relative">
                            <img src="{{ $movie->thumbnail_url ?? asset('gallery/default.jpeg') }}" class="card-img-top"
                                alt="{{ $movie->description }}" style="height: 240px; object-fit: cover;">
                            <div
                                class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-10 opacity-0 hover-overlay d-flex align-items-center justify-content-center">
                                <button onclick="startTaskWithAnimation({{ $movie->id }})"
                                    class="btn btn-lg btn-light rounded-circle shadow p-3 transform-scale">
                                    <i class="fas fa-play"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="card-body p-4">
                            <div class="d-flex flex-column h-100">
                                <h5 class="card-title fw-bold mb-3">{{ $movie->description }}</h5>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-coins text-warning me-2"></i>
                                        <span class="fw-bold text-primary">{{ number_format($movie->points) }}
                                            pts</span>
                                    </div>
                                    <button onclick="startTask({{ $movie->id }})"
                                        class="btn btn-primary btn-sm px-4 rounded-pill">
                                        Start Now
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Corner -->
                        <div class="position-absolute bottom-0 end-0 mb-n1 me-n1">
                            <svg width="120" height="120" viewBox="0 0 120 120" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="120" cy="120" r="120" fill="var(--bs-primary)"
                                    fill-opacity="0.05" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container my-5">
        <!-- Search bar -->
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5">
                    <form class="d-flex" action="{{ route('user.tasks.search') }}" method="GET">
                        <input type="text" name="search" class="form-control me-2" placeholder="Search Videos"
                            value="{{ request('search') }}">
                        <button class="btn btn-danger" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Title -->
        <div class="row mb-3">
            <div class="col-12 text-center">
                <h6 class="text-muted">{{ $totalInQueue }} TOTAL IN QUEUE</h6>
            </div>
        </div>

        <!-- Video Cards -->
        <div class="row text-center">
            @foreach ($movies as $movie)
                <div class="col-6 col-md-4 col-lg-2 mb-4">
                    <div class="card task-card" style="cursor: pointer;" onclick="startTask({{ $movie->id }})">
                        <img src="{{ $movie->thumbnail_url ?? asset('gallery/gambarlist.png') }}" class="card-img-top"
                            alt="{{ $movie->description }}">
                        <div class="card-body">
                            <p class="card-text">{{ $movie->description }}<br>{{ $movie->created_at->format('Y') }}
                            </p>
                            <span class="badge bg-primary">{{ number_format($movie->points) }} points</span>
                            @php
                                $userTask = $movie->userTasks()->where('user_id', Auth::id())->first();
                            @endphp
                            @if ($userTask)
                                @if ($userTask->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @else
                                    <span class="badge bg-info">In Progress</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{-- <div class="container py-5">
        <div class="row image-row">
            @foreach ($bottomMovies as $movie)
            <div class="col-md-2 mb-4">
                <div class="image-container">
                    <img src="{{ $movie->thumbnail_url ?? asset('gallery/list2gambar1.png') }}" alt="{{ $movie->description }}">
                </div>
            </div>
            @endforeach
        </div>
    </div> --}}
    <div class="container mt-5" style="background-color: #d0e7f9; padding:100px; border-radius:30px;">
        <div class="text-center">
            <h5 class="section-title">Earn Special Points every time you finish watching videos!</h5>
            <p>Every time you finish watching a video, you'll earn special points here! Keep watching videos,
                commenting, liking, and sharing!</p>
            <br>
        </div>

        <div class="row text-center">
            <!-- First section: Claim your points -->
            <div class="col-md-3">
                <div class="icon-section">
                    <img src="{{ asset('gallery/icon1.png') }}" alt="logoicon1footer" style="width: 50px">
                </div>
                <p class="section-description">Claim your points after finishing watching the video.</p>
            </div>

            <!-- Second section: Share the video -->
            <div class="col-md-3">
                <div class="icon-section">
                    <img src="{{ asset('gallery/sharetask.png') }}" alt="logoicon1footer" style="width: 50px">
                </div>

                <p class="section-description">Share the video on social media or with your friends!</p>
            </div>

            <!-- Third section: Like the video -->
            <div class="col-md-3">
                <div class="icon-section">
                    <img src="{{ asset('gallery/like.png') }}" alt="logoicon1footer" style="width: 50px">
                </div>
                <p class="section-description">Don't forget to like the video to earn even more points!</p>
            </div>

            <!-- Fourth section: Leave a comment -->
            <div class="col-md-3">
                <div class="icon-section">
                    <img src="{{ asset('gallery/comment.png') }}" alt="logoicon1footer" style="width: 50px;">
                </div>
                <p class="section-description">Leave your comment after watching the video about what you think!</p>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <!-- Points Section -->
        <div class="card text-white p-3 mb-4" style="background-color: #002366">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Your Points <img src="{{ asset('gallery/coindaily.png') }}" alt=""
                            style="width: 24px; height: 24px; border:2px white;"></h5>
                    <h3>{{ Auth::user()->total_points ?? 0 }} <span class="text-warning">=
                            Rp{{ number_format(Auth::user()->total_points / 10, 2) }}</span></h3>
                </div>
                <a href="{{ route('user.vouchers.index') }}" class="btn btn-warning text-dark">Redeem Voucher</a>
            </div>
        </div>

        <!-- Task Section -->
        @if ($inProgressTasks->isNotEmpty())
            <div class="card text-white p-3" style="background-color: #002366">
                <h5 class="col-md-3">Continue your task in progress!</h5>

                @foreach ($inProgressTasks as $userTask)
                    <div class="task-progress-card mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4>{{ $userTask->task->description }}</h4>
                                <p class="mb-2">
                                    <span class="badge bg-warning">
                                        {{ number_format($userTask->task->points) }} points
                                    </span>
                                    <span class="badge bg-info ms-2">
                                        {{ $userTask->status === 'started' ? 'In Progress' : 'Pending' }}
                                    </span>
                                </p>
                            </div>
                            <a href="{{ route('user.tasks.show', $userTask->id) }}" class="btn btn-danger">
                                {{ $userTask->status === 'started' ? 'Continue' : 'Start' }}
                            </a>
                        </div>
                        @if ($userTask->status === 'started')
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $userTask->progress ?? 0 }}%"></div>
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="text-left mt-3">
                    <small class="text-muted">Complete tasks to earn points and rewards!</small>
                </div>
            </div>
        @else
            <div class="card text-white p-3" style="background-color: #002366">
                <h5 class="col-md-3">No tasks in progress</h5>
                <p>Start watching videos to earn points!</p>
                <a href="#available-tasks" class="btn btn-danger">Browse Available Tasks</a>
            </div>
        @endif

        <!-- Feedback -->
        <div class="text-center mt-4">
            <img src="{{ asset('gallery/comment.png') }}" alt="feedbackcomment" style="width: 30px">
            <a href="#" class="text-dark" style="text-decoration: none">Share your feedback</a>
        </div>
    </div>
    <footer class="footer text-center py-4" style="background-color: #E5EDFF">
        <div class="container">
            <div class="social-icons">
                <a href="#" target="_blank" class="icon-link">
                    <img src="{{ asset('gallery/twitter.png') }}" alt="logotwitter" style="width: 15px">
                </a>
                <a href="#" target="_blank" class="icon-link">
                    <img src="{{ asset('gallery/fb.png') }}" alt="logofb" style="width: 15px">
                </a>
                <a href="#" target="_blank" class="icon-link">
                    <img src="{{ asset('gallery/youtube.png') }}" alt="logofb" style="width: 15px">
                </a>
            </div>
            <div class="help-button mt-3">
                <a href="{{ route('user.faq.index') }}" class="btn btn-help">Butuh bantuan?</a>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/tugas.js') }}"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
