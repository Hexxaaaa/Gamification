<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <a href="/" class="d-inline-block">
                                <x-application-logo class="img-fluid" style="width: 80px; height: 80px;" />
                            </a>
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-3" :status="session('status')" />

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-3" :errors="$errors" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">{{ __('Email') }}</label>
                                <input id="email" 
                                       type="email"
                                       class="form-control form-control-lg bg-light"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                                <input id="password"
                                       type="password"
                                       class="form-control form-control-lg bg-light"
                                       name="password"
                                       required>
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                    <label class="form-check-label" for="remember_me">
                                        {{ __('Remember me') }}
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif

                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    {{ __('Log in') }}
                                </button>
                            </div>

                            <!-- Social Login Divider -->
                            <div class="position-relative my-4">
                                <hr>
                                <div class="position-absolute top-50 start-50 translate-middle px-3 bg-white">
                                    <span class="text-muted">{{ __('Or continue with') }}</span>
                                </div>
                            </div>

                            <!-- Google Login -->
                            <a href="{{ route('social.redirect', 'google') }}" 
                               class="btn btn-outline-secondary btn-lg w-100 d-flex align-items-center justify-content-center gap-2">
                                <svg class="bi" width="20" height="20" fill="#4285F4">
                                    <path d="M12.24 10.285V14.4h6.806c-.275 1.765-2.056 5.174-6.806 5.174-4.095 0-7.439-3.389-7.439-7.574s3.345-7.574 7.439-7.574c2.33 0 3.891.989 4.785 1.849l3.254-3.138C18.189 1.186 15.479 0 12.24 0c-6.635 0-12 5.365-12 12s5.365 12 12 12c6.926 0 11.52-4.869 11.52-11.726 0-.788-.085-1.39-.189-1.989H12.24z"/>
                                </svg>
                                <span>{{ __('Login with Google') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

<style>
.form-control {
    transition: all 0.3s ease;
}
.form-control:focus {
    border-color: #6610f2;
    box-shadow: 0 0 0 0.2rem rgba(102, 16, 242, 0.15);
}
.btn-primary {
    background: linear-gradient(to right, #6610f2, #6f42c1);
    border: none;
    transition: all 0.3s ease;
}
.btn-primary:hover {
    background: linear-gradient(to right, #5a0ce7, #633ab7);
    transform: translateY(-1px);
}
.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
}
</style>