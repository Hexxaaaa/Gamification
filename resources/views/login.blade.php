<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">

</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="{{ url('gallery/logo.jpg') }}" class="logoatas">
      <h2>Login into your account</h2>
    </div>
    <form class="login-form">
      <label for="email">Email Id :</label>
      <div class="input-container">
        <input type="email" id="email" placeholder="testing@gmail.com" required>
        <span class="icon" class="icon2">&#9993;</span>
      </div>

      <label for="password">Password</label>
      <div class="input-container">
        <input type="password" id="password" placeholder="Enter your password" required>
        <span class="icon">&#128274;</span>
      </div>

      <a href="#" class="forgot-password">Forgot password?</a>

      <button type="submit" class="login-button">Login now</button>
<br>
      <div class="social-login">
        <class="divider"><span>OR</span><hr class="divider">
        <br>
        <div class="social-icons">
          <a href="#"><img src="{{ url('gallery/facebook.png') }}" alt="Facebook"></a>
          <a href="#"><img src="{{ url('gallery/instagram.png') }}" alt="Instagram"></a>
          <a href="#"><img src="{{ url('gallery/twitter.png') }}" alt="Twitter"></a>
        </div>
      </div>

      <button type="button" class="signup-button">Signup now</button>
    </form>
  </div>
</body>
</html>
