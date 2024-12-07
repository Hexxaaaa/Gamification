<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - {{ $user->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li><a href="{{ route('user.dashboard') }}"><img src="{{ url('gallery/logopoint.png') }}"
                            alt="logo"></a></li>
                <li><a href="{{ route('user.tasks.index') }}"><img src="{{ url('gallery/list.png') }}" alt="listtugas"></a></li>
                <li><a href="{{ route('user.vouchers.index') }}"><img src="{{ url('gallery/reward.png') }}" alt="reward"></a></li>
                <li><a href="#"><img src="{{ url('gallery/statistics.png') }}" alt="statistics"></a></li>
                <li><a href="{{ route('user.profile.show') }}"><img src="{{ url('gallery/user.png') }}"
                            alt="profile"></a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Welcome, {{ $user->name }}</h1>
                <br><br><br>
                <div class="search-bar">
                    <input type="search" placeholder="Search">
                    <img src="{{ url('gallery/bell.png') }}" alt="notifications" class="iconbell">
                    @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="logouser">
                    @else
                        <img src="{{ url('gallery/userfoto.png') }}" alt="Default Profile" class="logouser">
                    @endif
                    <!-- Add logout form -->
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <div class="profile-section">
                <div class="profile-photo">
                    @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Photo">
                    @else
                        <img src="{{ url('gallery/userfoto.png') }}" alt="Default Profile">
                    @endif
                </div>
                <div class="details">
                  <a href="{{ route('user.profile.edit') }}" class="edit-button">Edit</a>
                    <label>Full Name</label>
                    <input type="text" value="{{ $user->name }}" readonly>

                    <label>Email</label>
                    <input type="email" value="{{ $user->email }}" readonly>

                    <label>Age</label>
                    <input type="text" value="{{ $user->age ?? 'Not set' }}" readonly>

                    <label>Gender</label>
                    <select disabled>
                        <option {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>

                    <label>Country</label>
                    <select disabled>
                        <option>{{ $user->location ?? 'Indonesia' }}</option>
                    </select>
                </div>
            </div>

            <div class="history-section">
                <div class="task-history">
                    <h2>Completed Task History</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Platform</th>
                                <th><img src="{{ url('gallery/heart.png') }}" alt="Likes"></th>
                                <th><img src="{{ url('gallery/comment.png') }}" alt="Comments"></th>
                                <th><img src="{{ url('gallery/share.png') }}" alt="Shares"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="{{ url('gallery/logopointplay.png') }}" alt="PointPlay"
                                        style="width: 100px"></td>
                                <td>{{ $taskStats['like'] }}%</td>
                                <td>{{ $taskStats['comment'] }}%</td>
                                <td>{{ $taskStats['share'] }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="voucher-history">
                    <h2>Voucher Redemption History</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Voucher</th>
                                @foreach ($vouchers as $voucher)
                                    <th><img src="{{ url('gallery/coupon.png') }}" alt="Voucher"></th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Status</th>
                                @foreach ($vouchers as $voucher)
                                    <td class="status">Done</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- 
    <!-- Mobile View -->
    <div class="mobiledevice">
        <div class="profile-header">
            <h1>Profile</h1>
        </div>

        <div class="profile-container">
            <div class="profile-image">
                @if ($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Picture">
                @else
                    <img src="{{ url('gallery/userfoto.png') }}" alt="Default Profile">
                @endif
            </div>
            <div class="profile-info">
                <p><span>Name:</span> {{ $user->name }}</p>
                <p><span>Gender:</span> {{ $user->gender ?? 'Not set' }}</p>
                <p><span>Age:</span> {{ $user->age ?? 'Not set' }} Years</p>
                <p><span>Email:</span> {{ $user->email }}</p>
                <p><span>Phone:</span> {{ $user->phone_number ?? 'Not set' }}</p>
                <p><span>Password:</span> ********</p>
                <a href="{{ route('user.profile.edit') }}" class="edit-button">Edit</a>
            </div>

            <div class="task-history">
                <h3>Completed Task History</h3>
                <table>
                    <tr>
                        <th>Platform</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>PointPlay</td>
                        <td>{{ $taskCompletion }}%</td>
                    </tr>
                </table>
            </div>

            <div class="voucher-history">
                <h3>Voucher Redemption History</h3>
                <table>
                    <tr>
                        <th>Voucher</th>
                        <th>Status</th>
                    </tr>
                    @foreach ($vouchers as $voucher)
                    <tr>
                        <td>{{ $voucher->voucher->code }}</td>
                        <td class="done-status">Done</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div> --}}
</body>

</html>
