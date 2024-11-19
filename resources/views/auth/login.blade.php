<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
  <div class="container">
    <!-- Left section with illustration -->
    <div class="illustration">
      <img src="{{ url('gallery/logologin.jpg') }}" alt="Secure Login Illustration">
    </div>

    <!-- Right section with login form -->
    <div class="login-form">
      <div class="logo">
        <img src="{{ url('gallery/logo.jpg') }}" class="logoatas">
        <p>Login into your account</p>
      </div>
      <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <label for="email">Email Id:</label>
        <input type="email" id="email" name="email" placeholder="test@program.com" required>
        <span class="icon">&#9993;</span>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
        <span class="icon2">&#128274;</span>

        <div class="forgot-password">
          <a href="#">Forgot password?</a>
        </div>

        <button type="submit" class="btn primary-btn">
          Login now
        </button>

        <div class="or">
          <span>OR</span>
        </div>

       <button class="btn google-btn"> <a href="{{ route('social.redirect', ['provider' => 'google']) }}">
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
</html>
