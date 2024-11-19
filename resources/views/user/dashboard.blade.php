<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <header>
        <div class="logo">Logoipsum</div>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                {{-- <li><a href="{{ route('user.tasks.index') }}">Tasks</a></li>
                <li><a href="{{ route('user.leaderboard') }}">Leaderboard</a></li> --}}
            </ul>
        </nav>
        <div class="user-actions">
            <a href="#"><img src="{{ asset('images/search-icon.png') }}" alt="Search"></a>
            <a href="{{ route('user.profile.show') }}"><img src="{{ asset('images/user-icon.png') }}" alt="User"></a>
        </div>
        <!-- User Profile Dropdown (Optional) -->
        <div class="user-profile">
            <img src="{{ $user->profile_photo_url ?? asset('images/user-photo.png') }}" alt="User Photo">
            <p>{{ $user->name }}</p>
            <p>{{ $user->email }}</p>
            <p>Points: {{ number_format($user->total_points) }}</p>
            <button onclick="location.href='{{ route('user.profile.show') }}'">Profile</button>
            {{-- <button onclick="location.href='{{ route('user.logout') }}'">Logout</button> --}}
        </div>
    </header>
    <main>
        <!-- Hero Section -->   
        <section class="hero">
            <h1>Earn Points and Unlock Rewards</h1>
            <p>Complete tasks to earn points and unlock exclusive rewards. Elevate your engagement and enjoy the benefits!</p>
            {{-- <button onclick="location.href='{{ route('user.tasks.index') }}'">Get Started</button>
            <button onclick="location.href='{{ route('user.leaderboard') }}'">View Leaderboard</button> --}}
        </section>

        <!-- Progress Insights Section -->
        <section class="progress-insights">
            <h2>Insights that Elevate Your Engagement</h2>
            <p>Track your participation with real-time analytics designed to optimize engagement and maximize rewards.</p>
            <table>
                <thead>
                    <tr>
                        <th>Total Tasks</th>
                        <th>Completed Tasks</th>
                        <th>Total Points</th>
                        <th>Completion Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $totalTasks }}</td>
                        <td>{{ $completedTasks }}</td>
                        <td>{{ number_format($totalPoints) }}</td>
                        <td>{{ number_format($completionRate, 2) }}%</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Featured Video Section -->
        <section class="featured-video">
            <h2>Featured Video</h2>
            @if($featuredTask)
                <div class="video-container">
                    @if($featuredTask->video_type === 'file' && $featuredTask->video_url)
                        <video width="640" height="360" controls>
                            <source src="{{ asset('storage/' . str_replace('/storage/', '', $featuredTask->video_url)) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @elseif($featuredTask->video_type === 'youtube' && $featuredTask->video_url)
                        <iframe width="640" height="360" src="{{ $featuredTask->video_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @else
                        <p>Video content is currently unavailable.</p>
                    @endif
                    <p>{{ $featuredTask->description }}</p>
                </div>
            @else
                <p>No featured content available at the moment.</p>
            @endif
        </section>

        <!-- Mission Statistics Section -->
        <section class="mission-statistics">
            <h2>Mission Statistics</h2>
            <div class="stats-cards">
                <div class="card">
                    <h3>Total Missions</h3>
                    <p>{{ $totalMissions }}</p>
                </div>
                <div class="card">
                    <h3>Engaged Users</h3>
                    <p>{{ $engagedUsers }}</p>
                </div>
            </div>
            <div class="gamification-highlights">
                <h3>Gamification Highlights</h3>
                <ul>
                    @foreach($gamificationHighlights as $highlight)
                        <li>{{ $highlight }}</li>
                    @endforeach
                </ul>
            </div>
        </section>


        <!-- Call to Action Section -->
        <section class="call-to-action">
            <h2>Ready to Level Up Your Engagement Journey?</h2>
            <p>Empower yourself with our gamification platform. Complete tasks, earn points, and unlock exclusive rewards today!</p>
            {{-- <button onclick="location.href='{{ route('user.tasks.index') }}'">Start Now</button> --}}
        </section>
    </main>
    <footer>
        <div class="social-media">
            <a href="#"><img src="{{ asset('gallery/facebook.png') }}" alt="Facebook"></a>
            <a href="#"><img src="{{ asset('gallery/twitter.png') }}" alt="Twitter"></a>
            <a href="#"><img src="{{ asset('gallery/instagram.png') }}" alt="Instagram"></a>
        </div>
        <p>&copy; 2024 Logoipsum. All rights reserved.</p>
    </footer>
</body>

</html>
