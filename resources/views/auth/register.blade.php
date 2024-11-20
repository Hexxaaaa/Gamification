<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
</head>
<body>
  
    <div class="container">
        <div class="form">
            <img src="{{ url('gallery/logobrand.png') }}" class="logoatas"/>
            <h2>Sign up into your account</h2>
            <form method="POST" action="{{ route('register.submit') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name..." required>
                </div>
                <div class="form-group">
                    <label for="email">Email ID</label>
                    <input type="email" id="email" name="email" placeholder="info@xyz.com" required>
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile No.</label>
                    <input type="tel" id="mobile" name="phone_number" placeholder="+91 - 98596 58000">
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" placeholder="Enter your age">
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" placeholder="Enter your location">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="********" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="password_confirmation" placeholder="********" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Sign Up">
                </div>
            </form>
        </div>
        <div class="illustration">
            <img src="{{ url('gallery/logoregister.png') }}"/>
        </div>
    </div>
</body>
</html>
