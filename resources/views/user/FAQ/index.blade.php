<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('layouts.header')

    <div class="container my-5">
        <h2 class="fw-bold mb-4" style="font-family: 'Poppins'; font-weight:500">Frequently Asked Questions</h2>
        <p class="text-muted">
            This FAQ page provides answers to common questions about the gamification application
            designed to enhance user experience through game elements. The FAQ aims to help you
            understand how the application works, the available features, and its benefits.
        </p>
        <ul class="list-unstyled">
            <li class="d-flex align-items-center py-3">
                <span class="me-2 text-primary">●</span>
                <a href="#" class="text-decoration-none text-dark flex-grow-1">Who can use PointPlay?</a>

            </li>
            <li class="d-flex align-items-center py-3">
                <span class="me-2 text-primary">●</span>
                <a href="#" class="text-decoration-none text-dark flex-grow-1">How can I earn points on
                    PointPlay?</a>
            </li>
            <li class="d-flex align-items-center py-3">
                <span class="me-2 text-primary">●</span>
                <a href="#" class="text-decoration-none text-dark flex-grow-1">Do my points expire? </a>
            </li>
            <li class="d-flex align-items-center py-3">
                <span class="me-2 text-primary">●</span>
                <a href="#" class="text-decoration-none text-dark flex-grow-1">Can I invite friends to join
                    PointPlay?</a>
            </li>
            <li class="d-flex align-items-center py-3">
                <span class="me-2 text-primary">●</span>
                <a href="#" class="text-decoration-none text-dark flex-grow-1">What should I do if I encounter
                    issues with my account?</a>
            </li>
            <li class="d-flex align-items-center py-3">
                <span class="me-2 text-primary">●</span>
                <a href="#" class="text-decoration-none text-dark flex-grow-1">How is my personal data protected
                    on PointPlay?</a>
            </li>
            <li class="d-flex align-items-center py-3">
                <span class="me-2 text-primary">●</span>
                <a href="#" class="text-decoration-none text-dark flex-grow-1">What should I do if I experience
                    technical issues?</a>
            </li>
            <li class="d-flex align-items-center py-3">
                <span class="me-2 text-primary">●</span>
                <a href="#" class="text-decoration-none text-dark flex-grow-1">Does PointPlay support multiple
                    languages?</a>
            </li>
        </ul>
    </div>
    <footer class="footer text-center py-4">
        <div class="container">
            <div class="social-icons">
                <a href="#" target="_blank" class="icon-link">
                    <img src="{{ asset('gallery/twitter.png') }}" alt="logotwitter" style="width: 15px">
                </a>
                <a href="#" target="_blank" class="icon-link">
                    <img src="{{ asset('gallery/fb.png') }}" alt="logofb" style="width: 15px">
                </a>
                <a href="#" target="_blank" class="icon-link">
                    <img src="{{ asset('gallery/youtube.png') }}" alt="logofb" style="width: 15px">
                </a>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
<style>
    .footer {
        background-color: #ADD8E6;
        /* Light blue background */
        color: white;
        padding: 20px 0;
    }

    .navbar {
        background-color: #fff;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .navbar.scrolled {
        background-color: #007bff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .navbar-brand,
    .nav-link {
        transition: color 0.3s ease;
    }

    .navbar.scrolled .navbar-brand,
    .navbar.scrolled .nav-link {
        color: #fff !important;
    }

    .nav-link:hover {
        color: #007bff !important;
        transform: scale(1.1);
    }
</style>

</html>
-
