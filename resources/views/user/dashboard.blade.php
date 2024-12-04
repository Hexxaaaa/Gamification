<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PointPlay</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

</head>

<body>
    <header class="header">
        <div class="logo align-top" style="50%">
            <img src="{{ url('gallery/brandlogo.png') }}" class="logobrand">
        </div>
        <nav class="nav">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="{{ route('user.tasks.index') }}">Tasks</a></li>
                <li><a href="{{ route('user.vouchers.index') }}">Rewards</a></li>
                <li><a href="{{ route('user.leaderboard.index') }}">Leaderboard</a></li>
            </ul>
        </nav>
        <div class="user-info">
            <a href=""><img src="{{ url('gallery/bell.png') }}" class="notification"></a>
            <div class="profile">
                <a href="{{ route('user.profile.show') }}">
                    @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" class="profileheader"
                            alt="Profile Photo">
                    @else
                        <img src="{{ url('gallery/userfoto.png') }}" class="profileheader" alt="Default Profile">
                    @endif
                </a>
                <span class="points ms-2 fw-bold">{{ number_format($user->total_points) }} Pts</span>
            </div>
        </div>

    </header>
    <main class="mainutama">
        <section class="hero">
            <div class="hero-text">
                <br>
                <div class="display-2 col-md-6 offset-1" style="width=40%">
                    <h1>
                        <b>Earn Points</b> Rewards Easily and enjoy
                    </h1>
                </div>

                <br>
                <div class="bawahheader col-md-6 col-lg-12 offset-1">
                    <p>Complete tasks, collect points, and unlock exclusive rewards to keep your engagement fun and
                        rewarding</p>
                </div>

                <a class="btn btn-primary col-md-2 offset-1" href="#" role="button">Get Started</a>
                <br><br>
                <div class="partners">
                    <img src="{{ url('gallery/axon.png') }}" alt="Axon Airlines">
                    <img src="{{ url('gallery/jetstar.png') }}" alt="Jetstar">
                    <img src="{{ url('gallery/qantas.png') }}" alt="Qantas">
                    <img src="{{ url('gallery/alitalia.png') }}" alt="Alitalia">
                </div>
            </div>

            <br>
            <div class="reward-card">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <!-- Profile Section -->
                        <div class="text-center mb-3">
                            <a href="{{ route('user.profile.show') }}" class="d-inline-block">
                                @if ($user->profile_image)
                                    <img src="{{ asset('storage/' . $user->profile_image) }}"
                                        class="rounded-circle mb-3" alt="Profile Photo"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <img src="{{ url('gallery/userfoto.png') }}" class="rounded-circle mb-3"
                                        alt="Default Profile" style="width: 100px; height: 100px; object-fit: cover;">
                                @endif
                            </a>
                            <div class="text-center">
                                <h5 class="mb-1">{{ $user->name }}</h5>
                                <p class="text-muted small">{{ $user->email }}</p>
                            </div>
                        </div>

                        <!-- Points Display -->
                        <div class="text-center mb-4">
                            <h6 class="text-muted small text-uppercase">Total Points</h6>
                            <h3 class="fw-bold text-primary mb-1">{{ number_format($user->total_points) }}</h3>
                            <small class="text-muted">{{ now()->format('F d, Y') }}</small>
                        </div>

                        <!-- Daily Reward Section -->
                        <div class="text-center border-top pt-3">
                            <button id="dailyCheckIn"
                                class="btn btn-primary btn-lg w-75 position-relative d-flex align-items-center justify-content-center mx-auto">
                                <img src="{{ url('gallery/coindaily.png') }}" alt="Daily Reward" class="me-2"
                                    style="width: 24px; height: 24px;">
                                <span>Daily Reward</span>
                            </button>
                            <small class="text-muted d-block mt-2">Check in daily to earn points!</small>
                        </div>

                        <!-- Redeem Button -->
                        <div class="text-center mt-3">
                            <a href="{{ route('user.vouchers.index') }}"
                                class="btn btn-outline-primary w-75 d-flex align-items-center justify-content-center mx-auto">
                                <img src="{{ url('gallery/coin.png') }}" alt="Coin" class="me-2"
                                    style="width: 20px; height: 20px;">
                                REDEEM POINTS
                            </a>
                        </div>
                    </div>
                </div>
                <div class="points2">
                    <p class="user">Total Points</p>
                    <h2 class="pointuser">{{ number_format($user->total_points) }}</h2>
                    <p class="tanggaluser">{{ now()->format('F d, Y') }}</p>
                </div>
                <div class="tomboltukar">
                    <a href="{{ route('user.vouchers.index') }}">
                        <img src="{{ url('gallery/coin.png') }}" class="koin">REDEEM POINTS
                    </a>
                </div>
            </div>
            <div class="container">
                <div class="title">
                    <h1>PROGRESS INSIGHTS</h1>
                </div>
                <div class="tittle2">
                    <h1>Insights that elevate</h1>
                    <h1>your engangement.</h1>
                </div>
                <div class="description">
                    Track user participation and progress with real-time analytics designed to optimize engagement and
                    maximize rewards, creating a dynamic and interactive experience.
                </div>
                <div class="table">
                    <div class="platform">
                        <img src="{{ url('gallery/logopointplay.png') }}" alt="Logo">
                    </div>
                    <div>
                        <img src="{{ url('gallery/heart.png') }}" class="insightbtn">
                        {{ $interactions['like'] ?? 0 }}
                    </div>
                    <div>
                        <img src="{{ url('gallery/comment.png') }}" class="insightbtn">
                        {{ $interactions['comment'] ?? 0 }}
                    </div>
                    <div>
                        <img src="{{ url('gallery/share.png') }}" class="insightbtn">
                        {{ $interactions['share'] ?? 0 }}
                    </div>
                    <div class="score">
                        Total Score : {{ number_format($totalPoints) }}
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
    <br>

    <br>
    <div class="listgambar">
        <div class="list">
            <div class="slide"><img src="{{ url('gallery/pengantiniblis.jpeg') }}" alt="Image 1"></div>
            <div class="slide"><img src="{{ url('gallery/perayaanmati.jpeg') }}" alt="Image 2"></div>
            <div class="slide"><img src="{{ url('gallery/bilaesokibu.jpeg') }}" alt="Image 3"></div>
            <div class="slide"><img src="{{ url('gallery/Agaklaen.jpeg') }}" alt="Image 4"></div>
            <div class="slide"><img src="{{ url('gallery/jendelaseribusungai.jpeg') }}" alt="Image 5"></div>
        </div>
        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
        <button class="next" onclick="moveSlide(1)">&#10095;</button>
    </div>
    <br><br><br>
    <div class="footer">

        <h1 class="tulisakhir">OUR MISION</h1>
        <h3>Gamification Platform</h3>
        <h3>highlight</h3>
    </div><br>
    <div class="tulisakhir2">
        <p>Complete missions, engage with content, and earn</p>
        <p>rewards that motivate and inspire</p>
    </div><br><br>
    <div class="angkafooter">
        <h3>{{ $totalMissions }}+</h3>
        <h3>{{ $engagedUsers }}+</h3>
        <h3>100%</h3>
    </div>
    <div class="angkafooter2">
        <p>{{ $gamificationHighlights[0] }}</p>
        <p>{{ $gamificationHighlights[1] }}</p>
        <p>{{ $gamificationHighlights[2] }}</p>
    </div>
    <div class="container">
        <div class="content">
            <h1>Ready to level up your engagement journey</h1><br>
            <p>
                Empower users with exciting challenges, rewarding missions, and seamless progress tracking to boost
                participation and motivation.
            </p>
        </div>
        <div class="social-icons">
            <a href="#" aria-label="Youtube"><img src="{{ url('gallery/youtube.png') }}" class="icon"></a>
            <a href="#" aria-label="Facebook"><img src="{{ url('gallery/fb.png') }}" class="icon"></a>
            <a href="#" aria-label="Twitter"><img src="{{ url('gallery/twitter.png') }}" class="icon"></a>
            <a href="#" aria-label="Instagram"><img src="{{ url('gallery/instagram.png') }}"class="icon"></a>
            <a href="#" aria-label="LinkedIn"><img src="{{ url('gallery/linkedin.png') }}"class="icon"></a>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>

</html>
