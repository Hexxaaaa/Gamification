<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <a href="/">
                                <img src="{{ asset('logo.png') }}" alt="Logo" class="mb-3" style="width: 80px;">
                            </a>
                            <h4 class="fw-light">Register</h4>
                        </div>

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input id="age" type="number" class="form-control" name="age" value="{{ old('age') }}" required min="0">
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input id="location" type="text" class="form-control" name="location" value="{{ old('location') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">Already registered?</a>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ url('auth/google') }}" class="btn btn-danger">Google</a>
                            <a href="{{ url('auth/facebook') }}" class="btn btn-primary">Facebook</a>
                            <a href="{{ url('auth/instagram') }}" class="btn btn-warning">Instagram</a>
                            <a href="{{ url('auth/twitter') }}" class="btn btn-info">Twitter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>