<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pointplay Rewards Session</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/rewards.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="bagianatas" style="background-color: #E5EDFF">
        @include('layouts.header')

        <div class="container mt-5">
            <div class="row">
                <!-- Profile Section -->
                <div class="col-md-8">
                    <div class="profile-card d-flex align-items-center" style="background-color: #000d71">
                        @if ($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" class="rounded-circle me-3"
                                alt="User Image" style="width: 80px">
                        @else
                            <img src="{{ asset('gallery/userfoto.png') }}" class="rounded-circle me-3" alt="User Image"
                                style="width: 80px">
                        @endif

                        <div>
                            <h5 class="text-white">{{ $user->name ?? 'Anon User' }}</h5>
                            <p class="mb-1 text-white">
                                @if ($currentBadge) <!-- Changed from isset($badge) -->
                                    🎉 Your Current Level:
                                    <span class="text-decoration-none text-primary">
                                        Level {{ $currentBadge->level }} - {{ $currentBadge->name }}
                                    </span>
                                    @if (isset($previousBadge))
                                        <span class="text-white-50 small">
                                            <i class="fas fa-arrow-up"></i>
                                            Upgraded from {{ $previousBadge->name }}
                                        </span>
                                    @endif
                                    <div class="progress mt-2" style="height: 6px; width: 200px;">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{ $currentBadge && $currentBadge->points_required > 0 ? ($user->total_points / $currentBadge->points_required * 100) : 0 }}%"
                                            aria-valuenow="{{ $user->total_points }}" 
                                            aria-valuemin="0"
                                            aria-valuemax="{{ $currentBadge ? $currentBadge->points_required : 0 }}">
                                        </div>
                                    </div>
                                    <small class="text-white-50">
                                        {{ number_format($user->total_points) }} /
                                        {{ number_format($currentBadge->points_required) }} points
                                    </small>
                                    <div class="mt-3">
                                        <h6 class="text-white">Badges Obtained:</h6>
                                        <ul class="list-unstyled">
                                            @foreach ($user->badges()->wherePivot('status', 'collected')->orderBy('level', 'asc')->get() as $badge)
                                                <li>
                                                    <span class="badge bg-success">{{ $badge->name }} (Level {{ $badge->level }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    Welcome to PointPlay! <span class="badge bg-secondary rounded-pill">Beginner</span>
                                @endif
                            </p>
                            <div class="d-flex">
                                <a href="#" class="text-decoration-none me-3 text-white">
                                    {{ $user->social_handle1 ?? '@' . strtolower($user->name) }}
                                </a>
                                <a href="#" class="text-decoration-none text-white">
                                    {{ $user->social_handle2 ?? '@' . strtolower(str_replace(' ', '', $user->name)) }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Balance Section -->
                <div class="col-md-4" style="background-color: #E5EDFF">
                    <div class="balance-card">
                        <img src="{{ asset('gallery/coindaily.png') }}" alt="" width="40px">
                        <div class="balance">{{ number_format($user->total_points ?? 800) }}</div>
                        <p>Your Balance</p>
                        <p class="text-muted">
                            Earn more points, redeem exciting gifts, and enjoy your TBH experience
                        </p>
                    </div>
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



        <div class="voucher-section">
            <div class="container">
                <h2 class="text-center mb-4">Unlock exclusive perks and maximize your experience.</h2>
                <div class="row justify-content-center">
                    @forelse ($vouchers as $voucher)
                        <div class="col-12 col-md-4 mb-4">
                            <div class="voucher-card text-center p-3"
                                style="background: {{ $voucher->background_color }}; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                @if ($voucher->image)
                                    <img src="{{ Storage::url($voucher->image) }}" class="rounded-circle mb-2"
                                        alt="{{ $voucher->code }}"
                                        style="width: 60px; height: 60px; object-fit: cover;" />
                                @endif
                                <h5 class="text-white" style="font-family: 'Poppins'; font-size: 1rem;">
                                    {{ $voucher->code }}
                                </h5>
                                <p class="text-white" style="font-family: 'Poppins'; font-size: 0.9rem;">
                                    {{ $voucher->description }}
                                </p>
                                <p class="text-white-50" style="font-size: 0.9rem;">
                                    Points Required: <strong>{{ number_format($voucher->points_required) }}</strong>
                                </p>
                                <form action="{{ route('user.vouchers.redeem', $voucher->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-light w-100 fw-bold"
                                        style="font-size: 0.9rem; color: blue;"
                                        {{ !$voucher->isRedeemableBy(Auth::user()) ? 'disabled' : '' }}>
                                        @if ($voucher->userVouchers()->where('user_id', Auth::id())->exists())
                                            Already Redeemed
                                        @elseif($voucher->user_limit && $voucher->userVouchers()->count() >= $voucher->user_limit)
                                            Limit Reached
                                        @elseif(Auth::user()->total_points < $voucher->points_required)
                                            Insufficient Points
                                        @elseif($voucher->expiration_date && $voucher->expiration_date < now())
                                            Expired
                                        @else
                                            Redeem
                                        @endif
                                    </button>
                                </form>
                                @if ($voucher->user_limit)
                                    <small class="text-white-50 mt-2 d-block">
                                        {{ $voucher->userVouchers()->count() }}/{{ $voucher->user_limit }} claimed
                                    </small>
                                @endif
                                @if ($voucher->expiration_date)
                                    <small class="text-white-50 d-block">
                                        Expires:
                                        {{ Carbon\Carbon::parse($voucher->expiration_date)->format('M d, Y') }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">No vouchers available at the moment.</p>
                        </div>
                    @endforelse
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
                                <th scope="col">Code</th>
                                <th scope="col">Description</th>
                                <th scope="col">Date</th>
                                <th scope="col">Points Redeemed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pointsHistory as $history)
                                <tr>
                                    <td>{{ $history->voucher->code }}</td>
                                    <td>{{ $history->voucher->description }}</td>
                                    <td>{{ $history->created_at->format('M d, Y, \a\t g:i A') }}</td>
                                    <td class="text-primary">+{{ number_format($history->voucher->points_required) }}
                                        Points</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No points history available</td>
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


        <script src="{{ asset('js/rewards.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
