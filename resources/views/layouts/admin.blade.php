<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - @yield('title', 'PointPlay')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom admin CSS -->
    <style>
        :root {
            --sidebar-width: 250px;
        }
        
        .admin-sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #2c3e50;
            padding-top: 1rem;
        }
        
        .admin-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }
        
        .sidebar-link {
            color: #ecf0f1;
            text-decoration: none;
            padding: 0.75rem 1.25rem;
            display: block;
            transition: all 0.3s;
        }
        
        .sidebar-link:hover {
            background: #34495e;
            color: #fff;
        }
        
        .sidebar-link.active {
            background: #3498db;
            color: #fff;
        }
        
        .admin-header {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .admin-brand {
            color: #fff;
            font-size: 1.5rem;
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #34495e;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .admin-content {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="admin-sidebar">
            <div class="admin-brand mb-4">
                PointPlay Admin
            </div>
                       <div class="nav flex-column">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Users
                </a>
                <a href="{{ route('admin.tasks.index') }}" class="sidebar-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
                    <i class="fas fa-tasks me-2"></i> Tasks
                </a>
                <a href="{{ route('admin.vouchers.index') }}" class="sidebar-link {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}">
                    <i class="fas fa-gift me-2"></i> Vouchers
                </a>
                <a href="{{ route('admin.badges.index') }}" class="sidebar-link {{ request()->routeIs('admin.badges.*') ? 'active' : '' }}">
                    <i class="fas fa-award me-2"></i> Badges
                </a>
                <a href="{{ route('admin.activities') }}" class="sidebar-link {{ request()->routeIs('admin.activities') ? 'active' : '' }}">
                    <i class="fas fa-history me-2"></i> Activity Logs
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="admin-content w-100">
            <!-- Header -->
            <header class="admin-header d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">@yield('title', 'Dashboard')</h1>
                <div class="d-flex align-items-center">
                    <span class="me-3">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (if needed) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('scripts')
</body>
</html>