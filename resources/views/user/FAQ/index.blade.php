<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        *{
    font-family: 'Poppins',serif; font-weight:500; font-style: normal;
  }
        body {
            background-color: #f9f9f9;
        }
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .faq-header {
            margin-top: 2rem;
            margin-bottom: 1.5rem;
        }
        .faq-list {
            list-style: none;
            padding: 0;
        }
        .faq-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #eaeaea;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .faq-item:hover {
            background-color: #f1f1f1;
            transform: translateX(10px);
        }
        .faq-item .icon {
            font-size: 1.2rem;
            transition: transform 0.3s;
        }
        .faq-item:hover .icon {
            transform: rotate(90deg);
        }
        .faq-content {
            max-height: 0;
            overflow: hidden;
            padding: 0 1rem;
            border-left: 4px solid #007bff;
            margin-bottom: 1rem;
            background-color: #f8f9fa;
            transition: max-height 0.5s ease-in-out, padding 0.5s ease-in-out;
        }
        .faq-item:hover + .faq-content {
            max-height: 200px;
            padding: 0.5rem 1rem;
        }
        .navbar {
    background-color: #fff;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }
  .navbar.scrolled {
    background-color: #007bff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  }
  .navbar-brand, .nav-link {
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
</head>
<body>
    <!-- Navbar -->
    @include('layouts.header')

    <!-- FAQ Section -->
    <div class="container">
        <div class="text-center faq-header">
            <h1>Frequently Asked Questions</h1>
            <p class="text-muted">This FAQ page provides answers to common questions about the gamification application designed to enhance user experience through game elements.</p>
        </div>

        <ul class="faq-list">
            <li class="faq-item">
                <span>Who can use PointPlay?</span>
                <span class="icon">&rsaquo;</span>
            </li>
            <div class="faq-content">PointPlay can be used by anyone who wants to participate in gamified activities and earn rewards for completing tasks.</div>

            <li class="faq-item">
                <span>How can I earn points on PointPlay?</span>
                <span class="icon">&rsaquo;</span>
            </li>
            <div class="faq-content">You can earn points by completing tasks, participating in challenges, and achieving milestones within the app.</div>

            <li class="faq-item">
                <span>Do my points expire?</span>
                <span class="icon">&rsaquo;</span>
            </li>
            <div class="faq-content">Points on PointPlay typically do not expire, but it's always a good idea to check the terms and conditions for specific activities.</div>

            <li class="faq-item">
                <span>Can I invite friends to join PointPlay?</span>
                <span class="icon">&rsaquo;</span>
            </li>
            <div class="faq-content">Yes, you can invite friends to join PointPlay and even earn bonus points for successful referrals.</div>

            <li class="faq-item">
                <span>What should I do if I encounter issues with my account?</span>
                <span class="icon">&rsaquo;</span>
            </li>
            <div class="faq-content">If you encounter issues, please contact our support team through the app or via our website for assistance.</div>

            <li class="faq-item">
                <span>How is my personal data protected on PointPlay?</span>
                <span class="icon">&rsaquo;</span>
            </li>
            <div class="faq-content">Your data is protected with industry-standard encryption and privacy measures to ensure your information remains secure.</div>

            <li class="faq-item">
                <span>What should I do if I experience technical issues?</span>
                <span class="icon">&rsaquo;</span>
            </li>
            <div class="faq-content">For technical issues, try restarting the app or device. If the issue persists, contact our technical support team.</div>

            <li class="faq-item">
                <span>Does PointPlay support multiple languages?</span>
                <span class="icon">&rsaquo;</span>
            </li>
            <div class="faq-content">Yes, PointPlay supports multiple languages to cater to a diverse user base. Check the settings to switch languages.</div>
        </ul>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
