<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/leaderboard.css') }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ url('gallery/logopointplay.png') }}" alt="logobrand" style="width: 100px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-1" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.tasks.index') }}">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.vouchers.index') }}">Rewards</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.leaderboard.index') }}">Leaderboard</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    @if ($currentUser->profile_image)
                        <img src="{{ asset('storage/' . $currentUser->profile_image) }}" alt="Profile"
                            class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <img src="{{ url('gallery/userfoto.png') }}" alt="Default Profile" class="rounded-circle me-2"
                            style="width: 40px; height: 40px; object-fit: cover;">
                    @endif
                    <span class="me-3">{{ $currentUser->name }}</span>
                    <span class="badge bg-primary">{{ number_format($currentUser->total_points) }} Pts</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5 col-md-11">
        <div class="row">
            <!-- Left Section -->
            <div class="col-md-8">
                <div class="leaderboard-card shadow-sm bg-white " style="border-radius: 30px; border: 2px solid black;">
                    <h2 class="text-left">Leaderboard and Badge</h2>
                    <p class="text-left col-6">Track your rank and see how you stack up against others this week</p><br>
                    <div class="leaderboard-bar">
                        @foreach ($topUsers as $index => $user)
                            @php
                                // Define heights and positions for 1st, 2nd, and 3rd place
                                $heights = ['290', '230', '180'];
                                $marginTops = ['250', '180', '140'];
                                $colors = ['#FFD700', '#C0C0C0', '#CD7F32']; // Gold, Silver, Bronze

                                // Get position based on points ranking
                                $position = $topUsers->sortByDesc('total_points')->keys()->search($index);
                            @endphp
                            <div class="bar" style="height: {{ $heights[$position] }}px;">
                                <span class="badge bg-secondary rounded-pill mt-2">
                                    {{ number_format($user->total_points) }}
                                </span>
                                <div class="profile-circle"
                                    style="margin-top: {{ $marginTops[$position] }}px; 
                                           width: 80px; 
                                           height: 80px; 
                                           border-radius: 50%; 
                                           border: 4px solid {{ $colors[$position] }}; 
                                           overflow: hidden;">
                                    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : url('gallery/userfoto.png') }}"
                                        alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <br>
                    <div class="badge-reward">
                        <h5>Badge Reward</h5>
                        <p>Congratulations to our top scorer of the week!</p>
                    </div>
                </div>
            </div>
            <!-- Right Section -->
            <div class="col-md-4">
                <div class="leaderboard-list shadow-sm p-3" style="border-radius:30px; border: 2px solid black;">
                    <h5 class="text-left">Leaderboard List</h5>
                    <p class="text-left" style="font-family: 'Poppins">Visualize your weekly progress</p>
                    <ul class="list-group gap-5">
                        @foreach ($leaderboardUsers as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                style="border-radius:30px; border: 2px solid #89A8B2;">
                                <div>
                                    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : url('gallery/userfoto.png') }}"
                                        class="rounded-circle me-2" alt="Avatar" style="width: 40px">
                                    <span>{{ $user->name }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge bg-primary rounded-pill me-2">{{ number_format($user->total_points) }}
                                        Points</span>
                                    <img src="{{ url('gallery/coin.png') }}" alt="Coin Icon"
                                        style="width: 32px; height: 30px;">
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    <div id="badgeContainer" class="container badge-container hidden">
        <h3 class="text-center mb-4">Badge Reward</h3>
        <div class="row justify-content-center">
            @foreach ($badges as $badge)
                <div class="col-6 col-sm-4 col-md-2 mb-3 badge-box-container">
                    <div class="badge-box text-center p-4 border rounded shadow"
                        style="background-color: {{ $badge['status'] === 'collected' ? '#2C3034' : '#55C25A' }}">
                        <h6
                            style="color: {{ $badge['status'] === 'collected' ? 'white' : ($badge['level'] === 2 ? 'blue' : 'inherit') }}">
                            Level {{ $badge['level'] }}
                        </h6>
                        <div class="icon mt-4" style="background-color: transparent;">
                            <img src="{{ url('gallery/coindaily.png') }}" alt="logocoin"
                                style="width: 50px; background-color: transparent; border: none;">
                        </div><br>
                        <div class="points-info mb-3">
                            @if ($badge['status'] === 'collected')
                                <p style="color: white;">Earned: {{ number_format($badge['points_required']) }}</p>
                            @else
                                <p style="color: white;">Required: {{ number_format($badge['points_required']) }}</p>
                                @if ($badge['status'] === 'available')
                                    <small style="color: #E2E8F0">You have enough points!</small>
                                @else
                                    <small style="color: #E2E8F0">Need
                                        {{ number_format($badge['points_required'] - $currentUser->total_points) }}
                                        more points</small>
                                @endif
                            @endif
                        </div>
                        @if ($badge['status'] === 'collected')
                            <button class="btn btn-secondary btn-sm bg-zinc-200" disabled>Collection</button>
                        @elseif($badge['status'] === 'available')
                            <form action="{{ route('user.badges.claim', $badge['id']) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Claim</button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled style="background-color: #2C3034">
                                <img src="{{ url('gallery/padlock.png') }}" alt="logokunci" style="width: 25px">
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer text-center py-4">
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
                <a href="{{ route('user.faq.index') }}" class="btn btn-help">Butuh Bantuan?</a>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/leaderboard.js') }}"></script>
</body>

</html>
