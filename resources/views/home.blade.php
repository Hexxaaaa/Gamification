<!-- resources/views/standalone_home.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Application</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        @guest
            <div class="jumbotron text-center">
                <h1 class="display-4">Welcome to Our Application!</h1>
                <p class="lead">Join us today and start earning points by completing tasks and redeeming exciting vouchers.</p>
                <hr class="my-4">
                <p>
                    <a class="btn btn-primary btn-lg" href="{{ route('register') }}" role="button">Register</a>
                    <a class="btn btn-success btn-lg" href="{{ route('login') }}" role="button">Login</a>
                </p>
            </div>
        @else
            <div class="text-center">
                <h1 class="display-4">Hello, {{ Auth::user()->name }}!</h1>
                <p class="lead">Explore the dashboard to manage your tasks and vouchers.</p>
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
            </div>
        @endguest
    </div>
</body>
</html>