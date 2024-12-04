{{-- resources/views/user/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PointPlay - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="{{ asset('js/dashboard.js') }}"></script>
</head>

<body>
    <header class="header">
        <div class="logo">
            <img src="{{ url('gallery/logobrand.png') }}" class="logobrand" alt="Logo Brand">
        </div>
        <nav class="nav">
            <ul>
                <li><a href="{{ route('user.dashboard') }}"
                        class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('user.tasks.index') }}"
                        class="{{ request()->routeIs('user.tasks.index') ? 'active' : '' }}">Tasks</a></li>
                {{-- <li><a href="{{ route('user.rewards.index') }}"
                        class="{{ request()->routeIs('user.rewards.*') ? 'active' : '' }}">Rewards</a></li>
                <li><a href="{{ route('user.leaderboard') }}"
                        class="{{ request()->routeIs('user.leaderboard') ? 'active' : '' }}">Leaderboard</a></li> --}}
            </ul>
        </nav>
        <div class="user-info">
            <div class="profile">
                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : url('gallery/userfoto.png') }}"
                    class="profileheader" alt="User Profile">
                <span class="points">{{ number_format($user->total_points) }} Pts</span>
            </div>

            <!-- Add logout form here -->
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link text-white" style="text-decoration: none;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </header>
    <main class="mainutama">
        <section class="hero">
            <div class="hero-text">
                <b>
                    <h1>Earn Points,</h1>
                </b>
                <h1>Rewards Easily,</h1>
                <h1>and enjoy.</h1>
                <p>Complete tasks, collect points, and unlock exclusive rewards to keep your engagement fun and
                    rewarding</p>
                <a class="btn btn-primary" href="#" role="button">Get Started</a>
            </div>
            <br>
            <div class="reward-card">
                <div class="user-card">
                    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : url('gallery/userfoto.png') }}"
                        class="profileheader" alt="User Profile">
                    <div class="ml-3">
                        <p>{{ $user->name }}</p>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
                <div class="points2">
                    <p class="user">Total Points</p>
                    <h2 class="pointuser">{{ number_format($user->total_points) }}</h2>
                    <p class="tanggaluser">{{ $user->updated_at->format('F d, Y') }}</p>
                </div>
                <div class="tomboltukar text-center mt-3">
                    {{-- <a href="{{ route('user.vouchers.redeem') }}"> --}}
                    <img src="{{ url('gallery/coin.png') }}" class="koin" alt="Coin"> Tukar Poin
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
                        <img src="{{ url('gallery/logobrand.png') }}" alt="Logo">
                    </div>
                    <div><img src="{{ url('gallery/heart.png') }}" class="insightbtn" alt="Likes">
                        {{ $completedTasks }}</div>
                    <div><img src="{{ url('gallery/comment.png') }}" class="insightbtn" alt="Comments">
                        {{ $engagedUsers }}</div>
                    <div><img src="{{ url('gallery/share.png') }}" class="insightbtn" alt="Shares">
                        {{ $totalTasks }}</div>
                    <div class="score">Total Score : {{ number_format($totalPoints) }}</div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title">Daily Check-in</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0">Next Reward: <span id="nextReward">-- points</span></p>
                            <small class="text-muted">Day <span id="dayCount">-</span> of 7</small>
                        </div>
                        <form action="{{ route('user.check-in') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary" id="checkInBtn" disabled>
                                <i class="fas fa-calendar-check me-2"></i>Check In
                            </button>
                        </form>
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
        <h1 class="tulisakhir">OUR MISSION</h1>
        <h3>Gamification Platform</h3>
        <h3>Highlight</h3>
    </div>
    <br>
    <div class="tulisakhir2">
        <p>Complete missions, engage with content, and earn</p>
        <p>rewards that motivate and inspire</p>
    </div>
    <br><br>
    <div class="angkafooter">
        <h3>90+</h3>
        <h3>700+</h3>
        <h3>100%</h3>
    </div>
    <div class="angkafooter2">
        <p>Highly rewarding missions</p>
        <p>Engaged users worldwide</p>
        <p>Transparent and fair challenges</p>
    </div>
    <div class="container2">
        <div class="title2">
            <h1>TRY IT NOW</h1>
            <br><br>
            <h2>Ready to level up your engagement</h2>
            <h2>journey</h2>
            <br>
            <p>Empower users with exciting challenges, rewarding missions,</p>
            <p>and seamless progress tracking to boost participation and motivation.</p>
        </div>
    </div>

    {{-- Footer Scripts --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
    <script>
        // Script untuk slider gambar
        let slideIndex = 0;
        const slides = document.querySelectorAll('.slide');

        function showSlides() {
            slides.forEach((slide, index) => {
                slide.style.display = 'none';
            });
            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1 }
            slides[slideIndex - 1].style.display = 'block';
            setTimeout(showSlides, 5000); // Ubah gambar setiap 5 detik
        }

        function moveSlide(n) {
            slideIndex += n;
            if (slideIndex > slides.length) { slideIndex = 1 }
            if (slideIndex < 1) { slideIndex = slides.length }
            slides.forEach((slide, index) => {
                slide.style.display = 'none';
            });
            slides[slideIndex - 1].style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', () => {
            showSlides();
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route('user.check-in.status') }}')
                .then(response => response.json())
                .then(data => {
                    const checkInBtn = document.getElementById('checkInBtn');
                    const nextReward = document.getElementById('nextReward');
                    const dayCount = document.getElementById('dayCount');

                    checkInBtn.disabled = !data.can_check_in;
                    nextReward.textContent = `${data.next_reward} points`;
                    dayCount.textContent = data.day_count;
                });
        });
    </script>
</body>

</html>
