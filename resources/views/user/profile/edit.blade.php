<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - {{ $user->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li><a href="{{ route('user.dashboard') }}">
                    <img src="{{ url('gallery/logopoint.png') }}" alt="logo">
                </a></li>
                {{-- <li><a href="{{ route('user.tasks.index') }}">
                    <img src="{{ url('gallery/list.png') }}" alt="listtugas">
                </a></li>
                <li><a href="{{ route('user.vouchers.index') }}">
                    <img src="{{ url('gallery/reward.png') }}" alt="reward">
                </a></li> --}}
                <li><a href="#">
                    <img src="{{ url('gallery/statistics.png') }}" alt="statistics">
                </a></li>
                <li><a href="{{ route('user.profile.show') }}">
                    <img src="{{ url('gallery/user.png') }}" alt="profile">
                </a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Edit Profile</h1>
                <div class="search-bar">
                    <input type="search" placeholder="Search">
                    <img src="{{ url('gallery/bell.png') }}" alt="notifications" class="iconbell">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="logouser">
                    @else
                        <img src="{{ url('gallery/userfoto.png') }}" alt="Default Profile" class="logouser">
                    @endif
                </div>
            </div>

            <div class="edit-profile-section">
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="edit-form">
                    @csrf
                    @method('PUT')

                    <div class="profile-image-section">
                        <div class="current-image">
                            @if($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Current Profile Photo">
                            @else
                                <img src="{{ url('gallery/userfoto.png') }}" alt="Default Profile">
                            @endif
                        </div>
                        <div class="image-upload">
                            <label for="profile_image">Change Profile Image</label>
                            <input type="file" 
                                   id="profile_image" 
                                   name="profile_image" 
                                   accept="image/*"
                                   class="form-control">
                            <small>Maximum file size: 2MB</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ $user->name }}" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ $user->email }}" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" 
                               id="age" 
                               name="age" 
                               value="{{ $user->age }}" 
                               min="0">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="location">Country</label>
                        <input type="text" 
                               id="location" 
                               name="location" 
                               value="{{ $user->location }}">
                    </div>

                    <div class="button-group">
                        <a href="{{ route('user.profile.show') }}" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-save">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('profile_image')?.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.current-image img').src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
</body>
</html>