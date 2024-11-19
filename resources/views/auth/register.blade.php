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
            <img src="{{ url('gallery/logo.jpg') }}" class="logoatas"/>
            <h2>Sign up into your account</h2>
            <form method="POST" action="{{ route('login') }}">
            <div class="form-group">
                <label for="first-name">Name</label>
                <input type="text" id="name" placeholder="Enter your name...">
            </div>
            <div class="form-group">
                <label for="email">Email ID</label>
                <input type="email" id="email" placeholder="info@xyz.com">
            </div>
            <div class="form-group">
                <label for="mobile">Mobile No.</label>
                <input type="tel" id="mobile" placeholder="+91 - 98596 58000">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="********">
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" placeholder="********">
            </div>
            <div class="form-group">
                <input type="submit" value="Sign Up">
            </div>
        </div>
        <div class="illustration">
            <img src="{{ url('gallery/logoregister.png') }}"/>
        </div>
    </div>
</body>
</html>
