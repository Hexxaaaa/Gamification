<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="illustration">
            <img src="{{ url('gallery/logologin.jpg') }}" alt="Secure Login Illustration">
        </div>
        <div class="login-form">
            <div class="logo">
                <img src="{{ url('gallery/logopointplay.png') }}" class="logoatas">
                <p>Login into your account</p>
            </div>
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <label for="email">Email Id:</label>
                <div class="input-wrapper">
                  <input type="email" 
                         id="email" 
                         name="email" 
                         placeholder="test@program.com"
                         value="{{ old('email') }}" 
                         required>
                  <span class="icon2">&#9993;</span>
                </div>

                <label for="password">Password:</label>
                <div class="input-wrapper">
                  <input type="password" 
                         id="password" 
                         name="password" 
                         placeholder="Enter your password" 
                         required>
                  <span class="icon2">&#128274;</span>
                </div>

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
</body>
<style>
    *{
  font-family: 'Poppins',serif; font-weight:500; font-style: normal;
}
</style>
</html>
