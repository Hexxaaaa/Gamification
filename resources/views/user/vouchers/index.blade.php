<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PointPlay Rewards</title>
    <link rel="stylesheet" href="{{ asset('css/rewards.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ url('gallery/logopointplay.png') }}" alt="PointPlay Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
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
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="rounded-circle me-2" height="40">
                    @else
                        <img src="{{ url('gallery/userfoto.png') }}" alt="Default Profile" class="rounded-circle me-2" height="40">
                    @endif
                    <div>
                        <span class="d-block fw-bold">{{ $user->name }}</span>
                        <small>{{ number_format($user->total_points) }} Pts</small>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="profil-container mt-4">
        <div class="row justify-content-between">
            <div class="col-md-6">
                <div class="profile-card" style="border-radius:30px; border: 2px solid black;">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="rounded-circle mb-3" style="border-radius: 50%; border: 4px solid rgb(236, 230, 230);">
                    @else
                        <img src="{{ url('gallery/userfoto.png') }}" alt="Default Profile" class="rounded-circle mb-3" style="border-radius: 50%; border: 4px solid rgb(236, 230, 230);">
                    @endif
                    <h5>{{ $user->name }}</h5>
                    <p class="text-muted mb-1">Rank Progression</p>
                    <p>🎉 Congratulations! You've reached <strong>{{ $user->rank ?? 'Newbie' }}</strong>!</p>
                    <div>
                        <a href="#" class="me-3 text-decoration-none">
                            <img src="{{ url('gallery/instagram.png') }}" style="width: 20px"> {{ $user->instagram ?? '@username' }}
                        </a>
                        <a href="#" class="text-decoration-none">
                            <img src="{{ url('gallery/fb.png') }}" style="width: 20px"> {{ $user->facebook ?? '@username' }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="balance-card" style="border-radius:30px; border: 2px solid black;">
                    <h3 class="display-5 text-warning">{{ number_format($user->total_points) }}</h3>
                    <p class="fw-bold">Your Balance</p>
                    <small>Earn more points, redeem exciting gifts, and enjoy your PointPlay experience.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="voucher-section">
        <div class="container">
            <h2 class="text-center mb-5">Unlock exclusive perks and maximize your experience.</h2>
            <div id="voucherCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($vouchers as $index => $voucher)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="voucher-card text-center p-4" style="background: {{ $voucher->background_color }}">
                                @if($voucher->image)
                                    <img src="{{ Storage::url($voucher->image) }}" class="rounded-circle mb-3" alt="{{ $voucher->code }}"/>
                                @endif
                                <h5 class="text-white">{{ $voucher->code }}</h5>
                                <p class="text-white-50">Points Required:</p>
                                <p><strong>{{ number_format($voucher->points_required) }}</strong></p>
                                <form action="{{ route('user.vouchers.redeem', $voucher->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-light w-100 fw-bold" 
                                            {{ $user->total_points < $voucher->points_required ? 'disabled' : '' }}>
                                        {{ $user->total_points < $voucher->points_required ? 'Insufficient Points' : 'Redeem' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#voucherCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#voucherCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="container points-history-container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-12">
                <h3>Points History</h3>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-secondary" type="button">
                        <img src="{{ url('gallery/settings.png') }}" style="width: 25px">
                    </button>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Voucher</th>
                            <th scope="col">Type</th>
                            <th scope="col">Date</th>
                            <th scope="col">Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pointsHistory as $history)
                            <tr>
                                <td>{{ $history->voucher->code }}</td>
                                <td>Voucher Redemption</td>
                                <td>{{ $history->created_at->format('M d, Y, \a\t H:i A') }}</td>
                                <td class="text-danger">-{{ number_format($history->voucher->points_required) }} Points</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No redemption history found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4 col-md-12 illustration">
                <img src="{{ url('gallery/logorewards.png') }}">
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>