<!doctype html>
<html lang="en">

<head>
    <title>Beranda</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rewards.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    @include('layouts.header')
    <main>
        <div class="container py-5">
            <div class="row align-items-center">
                <!-- Left Section -->
                <div class="col-md-6">
                    <h1><b>Earn Points</b><br>Rewards Easily<br>and Enjoy</h1>
                    <p>Complete tasks, collect points, and unlock exclusive rewards to keep your engagement fun and
                        rewarding.</p>
                    <a href="#" class="btn btn-primary btn-lg">Get Started</a>
                    <div class="reward-logo mt-4 col-12 gap-5">
                        @foreach ($cardData['partnerLogos'] as $partner => $logo)
                            <img src="{{ asset($logo) }}" alt="{{ ucfirst($partner) }}">
                        @endforeach
                    </div>
                </div>

                <!-- Right Section -->
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="card-custom text-center">
                        <div class="position-relative d-inline-block">
                            <a href="{{ route('user.profile.show') }}" class="profile-link" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" title="Click to view profile">
                                @if (isset($user) && $user->profile_image)
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}"
                                        class="rounded-circle profile-image"
                                        style="width: 70px; height: 70px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('gallery/userfoto.png') }}" alt="Default Profile"
                                        class="rounded-circle profile-image"
                                        style="width: 70px; height: 70px; object-fit: cover;">
                                @endif
                                <div class="position-absolute top-0 start-0 w-100 h-100 rounded-circle overlay"></div>
                            </a>
                        </div>
                        <h5 class="mt-3">{{ $user->name ?? 'Anon User' }}</h5>
                        <p class="text-muted">{{ $cardData['userEmail'] }}</p>
                        <div class="mt-4">
                            <p class="total-points">{{ number_format($totalPoints, 2) }}</p>
                            <p class="text-muted">{{ $cardData['displayDate'] }}</p>
                        </div>
                        <button class="btn-redeem"
                            onclick="window.location.href='{{ route('user.vouchers.index') }}'">Redeem Points</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-5">
            <div class="row justify-content-center g-4">
                <!-- Card Section -->
                <div class="col-lg-10 col-md-12">
                    <div class="card-progress">
                        <!-- Section Header -->
                        <div class="section-header mb-4">
                            <div class="d-flex justify-content-between flex-column flex-md-row">
                                <div class="text-start mb-3 mb-md-0">
                                    <h6>PROGRESS INSIGHTS</h6><br>
                                    <h2 style="font-size: 2rem">Insights that elevate your engagement.</h2>
                                </div>
                                <div class="text-start col-12 col-md-7 mt-3 mt-md-5 ms-auto">
                                    <p>
                                        Track user participation and progress with real-time analytics designed to
                                        optimize engagement
                                        and maximize rewards, creating a dynamic and interactive experience.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table custom-table table-bordered align-middle">
                                <thead>
                                    <div class="table-responsive">
                                        <table class="table custom-table table-bordered align-middle">
                                            <thead>
                                                <tr>
                                                    <td class="platform-logo">
                                                        <img src="{{ asset($platformStats['logo']) }}" alt="Logo"
                                                            style="width: 100px">
                                                    </td>
                                                    <td>
                                                        <img src="{{ asset('gallery/like.png') }}" alt="Likes"
                                                            style="width: 20px">
                                                        {{ $platformStats['metrics']['likes'] }}
                                                    </td>
                                                    <td>
                                                        <img src="{{ asset('gallery/icon2.png') }}" alt="Engagement"
                                                            style="width: 20px">
                                                        {{ $platformStats['metrics']['engagement'] }}
                                                    </td>
                                                    <td>
                                                        <img src="{{ asset('gallery/commentask.png') }}" alt="Comments"
                                                            style="width: 20px">
                                                        {{ $platformStats['metrics']['comments'] }}
                                                    </td>
                                                    <td>
                                                        <img src="{{ asset('gallery/sharetask.png') }}" alt="Shares"
                                                            style="width: 20px">
                                                        {{ $platformStats['metrics']['shares'] }}
                                                    </td>
                                                    <td>
                                                        <img src="{{ asset('gallery/icon2.png') }}" alt="Reach"
                                                            style="width: 20px">
                                                        {{ $platformStats['metrics']['reach'] }}
                                                    </td>
                                                    <td class="table-score">
                                                        {{ $platformStats['metrics']['total_score'] }}</td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-5">
            <h1 class=" text-black mb-4">Featured Video</h1>

            <div class="carousel-container position-relative">
                <!-- Navigation Buttons -->
                <button class="carousel-nav prev" aria-label="Previous">
                    <span class="carousel-arrow">‹</span>
                </button>
                <button class="carousel-nav next" aria-label="Next">
                    <span class="carousel-arrow">›</span>
                </button>

                <!-- Movie Cards Container -->
                
                <div class="movie-carousel">
                    @foreach ($featuredTasks as $task)
                        <div class="movie-card">
                            <img src="{{ $task->thumbnail_url ?? asset('gallery/default.jpeg') }}"
                                alt="{{ $task->description }}" class="movie-image">
                            <div class="movie-overlay">
                                <div class="movie-content">
                                    <h3 class="movie-title">{{ Str::limit($task->description, 50) }}</h3>
                                    <div class="movie-info">
                                        @if ($task->video_duration)
                                            <span>{{ gmdate('H:i:s', $task->video_duration) }}</span>
                                            <span class="separator">•</span>
                                        @endif
                                        <span>{{ number_format($task->points) }} Points</span>
                                    </div>
                                    <div class="movie-buttons">
                                        <button onclick="startTaskWithAnimation({{ $task->id }})"
                                            class="btn btn-light btn-sm">
                                            WATCH
                                        </button>
                                        @if (!$task->userTasks->where('user_id', Auth::id())->first())
                                            <button onclick="startTask({{ $task->id }})"
                                                class="btn btn-outline-light btn-sm">
                                                ADD LIST
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        

          <!-- Daily Rewards Section -->
          <div class="daily-rewards mt-5" style="background-color: #E5EDFF">
            <h3
                style="font-family: 'Poppins',sans-serif, font-weight: 500; font-style: normal; font-size: 65px; color: #007DFC;">
                Daily Rewards
            </h3>
            <p style="font-family: 'Poppins',sans-serif, font-weight: 100; font-style: normal;">
                Watch Videos Daily, Complete Missions, and Earn Rewards!
            </p>
            <p>Collect up to <strong><img src="{{ asset('gallery/kado.png') }}" style="width: 22px;">
                    <span id="next-reward">350</span> points</strong>
            </p>
            <button class="btn btn-primary" id="checkInButton" style="border-radius: 200px">
                Check-in
            </button>
            <div id="check-in-streak" class="mt-2"></div>
        </div>

        <!-- Progress Section -->
        <div class="progress-container" id="progressContainer">
            @for ($day = 1; $day <= 7; $day++)
                @if ($day > 1)
                    <div class="line {{ $day <= ($currentDay ?? 0) ? 'complete' : '' }}"
                        data-day="{{ $day }}"></div>
                @endif
                <div class="progress-step {{ $day <= ($currentDay ?? 0) ? 'completed' : '' }} {{ $day === ($currentDay ?? 0) ? 'current' : '' }}"
                    data-day="{{ $day }}">
                    <div class="progress-circle">
                        @if ($day <= ($currentDay ?? 0))
                            <img src="{{ asset('gallery/verifiedbiru.png') }}" alt="Completed"
                                class="status-icon complete">
                        @else
                            <img src="{{ asset('gallery/verifiedabu.png') }}" alt="Waiting"
                                class="status-icon incomplete">
                        @endif
                    </div>
                    <div class="step-label">{{ $day <= ($currentDay ?? 0) ? 'Completed' : 'Waiting' }}</div>
                    <div class="step-points">Day-{{ $day }} {{ 50 * $day }} points</div>
                </div>
            @endfor
        </div>

        <br><br><br>




        <div class="container text-center">
            <h4 class="text-primary mt-4">OUR MISSION</h4>
            <h1 class="fw-bold mt-2">Gamification platform highlights</h1>
            <p class="text-muted">Complete missions, engage with content, and earn rewards that motivate and inspire
            </p>

            <div class="row stats">
                <div class="col-md-4">
                    <h3>{{ $totalMissions }}+</h3>
                    <p>Highly rewarding missions</p>
                </div>
                <div class="col-md-4">
                    <h3>{{ $engagedUsers }}+</h3>
                    <p>Engaged users worldwide</p>
                </div>
                <div class="col-md-4">
                    <h3>{{ $missionStats['transparency'] }}%</h3>
                    <p>Transparent and fair challenges</p>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div class="engagement-section text-start">
                <h6>Try It Now</h6>
                <h3 class="col-11" style="font-size: 50px">Ready to level up your engagement journey</h3>
                <p class="col-5">Empower users with exciting challenges, rewarding missions, and seamless progress
                    tracking to boost participation and motivation.</p>
                <div class="container mt-5 text-center">
                    <div class="icon d-inline-flex">
                        <a href="#" class="me-2"><img src="{{ asset('gallery/youtube.png') }}"
                                alt="YouTube"></a>
                        <a href="#" class="me-2"><img src="{{ asset('gallery/facebook.png') }}"
                                alt="Facebook"></a>
                        <a href="#" class="me-2"><img src="{{ asset('gallery/twitter.png') }}"
                                alt="Twitter"></a>
                        <a href="#"><img src="{{ asset('gallery/instagram.png') }}" alt="Instagram"></a>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/rewards.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>

</html>
