<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $user->name }} - Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container-fluid h-100">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-auto bg-light p-3 text-center">
                <ul class="list-unstyled">
                    <li><a href="{{ route('user.dashboard') }}"><img src="{{ url('gallery/logopoint.png') }}"
                                alt="logo" class="img-fluid mb-3" style="width: 40px"></a></li>
                    <li><a href="{{ route('user.dashboard') }}"><img src="{{ url('gallery/menu.png') }}" alt="menu"
                                class="img-fluid mb-3" style="width: 40px"></a></li>
                    <li><a href="{{ route('user.tasks.index') }}"><img src="{{ url('gallery/list.png') }}"
                                alt="listtugas" class="img-fluid mb-3" style="width: 40px"></a></li>
                    <li><a href="{{ route('user.vouchers.index') }}"><img src="{{ url('gallery/reward.png') }}"
                                alt="reward" class="img-fluid mb-3" style="width: 40px"></a></li>
                    <li><a href="{{ route('user.leaderboard.index') }}"><img src="{{ url('gallery/statistics.png') }}"
                                alt="statistics" class="img-fluid mb-3" style="width: 40px"></a></li>
                    <li><a href="{{ route('user.profile.show') }}"><img src="{{ url('gallery/user.png') }}"
                                alt="user" class="img-fluid mb-3" style="width: 40px"></a></li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                    <h1 class="h5">Welcome, {{ $user->name }}</h1>
                    <div class="d-flex align-items-center">
                        <input type="search" class="form-control me-2" placeholder="Search">
                        <img src="{{ url('gallery/bell.png') }}" alt="logolonceng" class="img-fluid me-2"
                            style="width: 20px;">
                        @if ($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}"
                                class="rounded-circle" style="width: 40px;">
                        @else
                            <img src="{{ url('gallery/userfoto.png') }}" alt="Default Profile" class="rounded-circle"
                                style="width: 40px;">
                        @endif
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                @if ($user->profile_image)
                                    <img src="{{ asset('storage/' . $user->profile_image) }}"
                                        alt="{{ $user->name }}" class="rounded-circle" style="width: 100px;">
                                @else
                                    <img src="{{ url('gallery/userfoto.png') }}" alt="Default Profile"
                                        class="rounded-circle" style="width: 100px;">
                                @endif
                            </div>
                            <div class="col">
                                <form id="profileForm" action="{{ route('user.profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="fullname" name="name"
                                            value="{{ $user->name }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $user->email }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="age" class="form-label">Age</label>
                                        <input type="number" class="form-control" id="age" name="age"
                                            value="{{ $user->age ?? '' }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-control" id="gender" name="gender" disabled>
                                            <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>
                                                Male</option>
                                            <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>
                                                Female</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" class="form-control" id="country" name="location"
                                            value="{{ $user->location ?? '' }}" disabled>
                                    </div>
                                    
                                    <button type="button" id="editBtn" class="btn btn-primary">Edit</button>
                                    <button type="submit" id="saveBtn" class="btn btn-success d-none">Save
                                        Changes</button>
                                    <button type="button" id="cancelBtn"
                                        class="btn btn-secondary d-none">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- History Section -->
                <div class="row mt-4">
                    <!-- Task History -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Completed Task History</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Platform</th>
                                            <th><img src="{{ url('gallery/heart.png') }}" alt="heart"
                                                    class="img-fluid" style="width: 20px;"></th>
                                            <th><img src="{{ url('gallery/comment.png') }}" alt="comment"
                                                    class="img-fluid" style="width: 20px;"></th>
                                            <th><img src="{{ url('gallery/share.png') }}" alt="share"
                                                    class="img-fluid" style="width: 20px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><img src="{{ url('gallery/logobrand.png') }}" alt="logobrand"
                                                    class="img-fluid" style="width: 20px;"></td>
                                            <td>{{ $taskStats['like'] }}%</td>
                                            <td>{{ $taskStats['comment'] }}%</td>
                                            <td>{{ $taskStats['share'] }}%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Voucher History -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Voucher Redemption History</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Voucher</th>
                                            @foreach ($vouchers as $voucher)
                                                <th><img src="{{ url('gallery/coupon.png') }}" alt="coupon"
                                                        class="img-fluid" style="width: 20px;"></th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Status</th>
                                            @foreach ($vouchers as $voucher)
                                                <td
                                                    class="fw-bold {{ $voucher->voucher->getCurrentStatus() === 'active' ? 'text-success' : 'text-danger' }}">
                                                    {{ ucfirst($voucher->voucher->getCurrentStatus()) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('profileForm');
            const inputs = form.querySelectorAll('input, select');
            const editBtn = document.getElementById('editBtn');
            const saveBtn = document.getElementById('saveBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const originalValues = {};

            // Store original values
            inputs.forEach(input => {
                originalValues[input.name] = input.value;
            });

            // Edit button handler
            editBtn.addEventListener('click', function() {
                inputs.forEach(input => input.disabled = false);
                editBtn.classList.add('d-none');
                saveBtn.classList.remove('d-none');
                cancelBtn.classList.remove('d-none');
            });

            // Cancel button handler
            cancelBtn.addEventListener('click', function() {
                inputs.forEach(input => {
                    input.value = originalValues[input.name];
                    input.disabled = true;
                });
                editBtn.classList.remove('d-none');
                saveBtn.classList.add('d-none');
                cancelBtn.classList.add('d-none');
            });

            // Form submission handler
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update original values
                            inputs.forEach(input => {
                                originalValues[input.name] = input.value;
                                input.disabled = true;
                            });

                            editBtn.classList.remove('d-none');
                            saveBtn.classList.add('d-none');
                            cancelBtn.classList.add('d-none');

                            // Show success message
                            alert('Profile updated successfully!');
                        } else {
                            alert('Error updating profile');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error updating profile');
                    });
            });
        });
    </script>
</body>

</html>
