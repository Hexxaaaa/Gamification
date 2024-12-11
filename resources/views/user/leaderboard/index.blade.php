<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/leaderboard.css') }}">
</head>

<body>

    <!-- Navbar -->
    @include('layouts.header')

    <!-- Main Content -->
    <div class="container mt-5 col-md-11">
        <div class="row">
            <!-- Left Section -->
            <div class="col-md-8">
                <div class="leaderboard-card shadow-sm bg-white"
                    style="border-radius: 30px; border: 2px solid black; background: linear-gradient(45deg, #ff9a9e, #fad0c4, #fbc2eb, #a18cd1);">
                    <h2 class="text-left">Leaderboard and Badge</h2>
                    <p class="text-left col-6">Track your rank and see how you stack up against others this week</p><br>
                    <div class="leaderboard-bar">
                        @php
                            // Sort users by points and get top 3
                            $topThree = $topUsers->take(3)->values();

                            // Reorder array to show: 2nd, 1st, 3rd
                            $orderedUsers = collect([
                                $topThree->get(1), // 2nd place
                                $topThree->get(0), // 1st place
                                $topThree->get(2), // 3rd place
                            ]);

                            // Define visual properties for each position
                            $heights = ['230px', '290px', '100px']; // Left, Center, Right
                            $margins = ['180px', '250px', '50px']; // Left, Center, Right
                            $borders = ['#578EE4', 'black', '#55C25A']; // Left, Center, Right
                            $delays = ['0.5s', '0s', '1s']; // Left, Center, Right
                        @endphp

                        @foreach ($orderedUsers as $index => $user)
                            <div class="bar star-bar"
                                style="height: {{ $heights[$index] }}; animation: bounce 3s infinite {{ $delays[$index] }}; background: linear-gradient(45deg, #009FFD, #2A2A72, #70CFFF);">
                                <span
                                    class="badge bg-secondary rounded-pill mt-2">{{ number_format($user->total_points) }}</span>
                                <div class="profile-circle"
                                    style="margin-top: {{ $margins[$index] }}; width: 80px; height: 80px; border-radius: 50%; border: 4px solid {{ $borders[$index] }}; overflow: hidden;">
                                    @if ($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}"
                                            alt="{{ $user->name }}"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('gallery/userfoto.png') }}" alt="{{ $user->name }}"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    @endif
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
            <!-- Right Section - Leaderboard List -->
            <div class="col-md-4">
                <div class="leaderboard-list shadow-sm p-3"
                    style="border-radius:30px; border: 2px solid black; background: linear-gradient(45deg, #ff9a9e, #fad0c4, #fbc2eb, #a18cd1);">
                    <h5 class="text-left">Leaderboard List</h5>
                    <p class="text-left" style="font-family: 'Poppins'">Visualize your weekly progress</p>
                    <ul class="list-group gap-5">
                        @foreach ($leaderboardUsers as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                style="border-radius:30px; border: 2px solid #89A8B2;">
                                <div>
                                    @if ($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}"
                                            class="rounded-circle me-2" alt="{{ $user->name }}"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('gallery/userfoto.png') }}" class="rounded-circle me-2"
                                            alt="Default Avatar" style="width: 40px">
                                    @endif
                                    <span>{{ $user->name }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge bg-primary rounded-pill me-2">{{ number_format($user->total_points) }}
                                        Points</span>
                                    <img src="{{ asset('gallery/coin.png') }}" alt="Coin Icon"
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
                @if ($badge['level'] <= 10)
                    <div class="col-6 col-sm-4 col-md-2 mb-3 badge-box-container">
                        <div class="badge-box text-center p-4 border rounded shadow {{ $badge['level'] == 10 ? 'elite-badge' : '' }}"
                            style="background-color: {{ $badge['status'] === 'collected' ? '#2C3034' : ($badge['level'] == 10 ? 'linear-gradient(45deg, #FFD700, #FFA500)' : '#55C25A') }}">

                            <!-- Special styling for level 10 -->
                            @if ($badge['level'] == 10)
                                <div class="position-relative">
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        Elite
                                        <span class="visually-hidden">Elite Badge</span>
                                    </span>
                                    <h6 class="text-black fw-bold mb-3">
                                        <i class="fas fa-crown text-warning me-1"></i>
                                        Level {{ $badge['level'] }}
                                    </h6>
                                </div>
                                <div class="icon mt-4 position-relative">
                                    <div class="badge-glow"></div>
                                    <img src="{{ url('gallery/coindaily.png') }}" alt="logocoin" class="badge-image"
                                        style="width: 60px; background-color: transparent; border: none;">
                                </div>
                                <br>
                                <p class="text-black fw-bold h5">{{ number_format($badge['points']) }}</p>
                            @else
                                <h6
                                    style="color: {{ $badge['status'] === 'collected' ? 'white' : ($badge['level'] === 2 ? 'blue' : 'inherit') }}">
                                    Level {{ $badge['level'] }}
                                </h6>
                                <div class="icon mt-4" style="background-color: transparent;">
                                    <img src="{{ url('gallery/coindaily.png') }}" alt="logocoin"
                                        style="width: 50px; background-color: transparent; border: none;">
                                </div>
                                <br>
                                <p style="color: white;">{{ number_format($badge['points']) }}</p>
                            @endif

                            @if ($badge['status'] === 'collected')
                                <button class="btn btn-secondary btn-sm" disabled>Collected</button>
                            @elseif($badge['status'] === 'available')
                                <form action="{{ route('user.badges.claim', $badge['id']) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-primary btn-sm {{ $badge['level'] == 10 ? 'btn-claim-elite' : '' }}">
                                        Claim
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled style="background-color: #2C3034">
                                    <img src="{{ url('gallery/padlock.png') }}" alt="logokunci" style="width: 25px">
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
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
                <a href="{{ route('user.faq.index') }}" class="btn btn-help">Butuh bantuan?</a>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/leaderboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
