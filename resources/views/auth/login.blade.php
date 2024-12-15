<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <div class="illustration">
            <img src="{{ url('gallery/logologin.jpg') }}" alt="Secure Login Illustration">
        </div>
        <div class="login-form">
            <div class="logo">
                <img src="{{ url('gallery/logobrand.png') }}" class="logoatas">
                <p>Login into your account</p>
            </div>

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <label for="email">Email Id:</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" placeholder="test@program.com" required>
                    <span class="icon2">&#9993;</span>
                </div>

                <label for="password">Password:</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <span class="icon2">&#128274;</span>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger">
                        These credentials do not match our records.
                    </div>
                @endif

                <div class="forgot-password">
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit" class="btn primary-btn">
                    Login now
                </button>

                <div class="or">
                    <span>OR</span>
                </div>

                <button type="button" class="btn google-btn">
                    <a href="{{ route('social.redirect', ['provider' => 'google']) }}" 
                       style="text-decoration: none; color:white;">
                        Continue with Google
                    </a>
                </button>

                <button type="button" class="btn signup-btn">
                    <a href="{{ route('register') }}" class="registers">Sign up</a>
                </button>
            </form>
        </div>
    </div>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'Invalid email or password',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
</body>
</html>