<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TASK SESSION</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ url('css/task.css') }}">
</head>
<body>

<header>
  <nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary" href="#">
        <img src="{{ url('gallery/logopointplay.png') }}" alt="logobrand" style="width: 100px">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="/dashboard">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/task">Tasks</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/rewards">Rewards</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/leaderboard">Leaderboard</a>
          </li>
        </ul>
        </div>
        <div class="ms-3 d-flex align-items-center">
          <span class="points">21,870 PTS</span>
          <a href="/profile">
            <img src="{{ url('gallery/userfoto.png') }}" alt="User Avatar" class="rounded-circle ms-2" width="40px">
        </a>    
        </div>
      
    </div>
  </nav>
</header>

<main class="py-5">
  <div class="container">
    <div class="video-container position-relative">
        <iframe 
          width="100%" 
          height="600" 
          src="https://www.youtube.com/embed/-P0JuP6dZc4"
          frameborder="0" 
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
          allowfullscreen>
        </iframe>
        <div class="position-absolute top-50 start-50 translate-middle">
          </button>
        </div>
      </div>
    <div class="mt-4 d-flex justify-content-between align-items-center">
      <button class="btn btn-primary">Continue Watching</button>
      <button class="btn btn-outline-secondary">Next</button>
    </div>
    <h3 class="mt-4">Experience the Fun of Progress</h3>
    <p>Discover a platform where every action counts! Watch videos, like, comment, and share to earn points effortlessly. Turn your daily interactions into exciting rewards and climb the leaderboard with every step forward. Whether you're enjoying your favorite content or unlocking exclusive perks, PointPlay makes every moment rewarding. Start now and experience progress like never before!</p>
    <div class="action-buttons d-flex gap-5">
     <button class="btn btn-outline-primary" > <img src="{{ url('gallery/like.png') }}" alt="iconjempol" style="width: 30px"></button>
      <button class="btn btn-outline-primary"> <img src="{{ url('gallery/sharetask.png') }}" alt="iconshare" style="width: 30px"></button>
      <button class="btn btn-outline-primary"> <img src="{{ url('gallery/commentask.png') }}" alt="iconkomen" style="width: 30px"></button>
    </div>
    <div class="row mt-5">
        <div class="col-6 col-md-3">
          <iframe
            width="100%"
            height="150"
            src="https://www.youtube.com/embed/Jqtigc72crw"
            title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
          </iframe>
        </div>
        <div class="col-6 col-md-3">
          <iframe
            width="100%"
            height="150"
            src="https://www.youtube.com/embed/kzi37atRshI"
            title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
          </iframe>
        </div>
        <div class="col-6 col-md-3">
          <iframe
            width="100%"
            height="150"
            src="https://www.youtube.com/embed/7oBZ8sBjdyQ"
            title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
          </iframe>
        </div>
        <div class="col-6 col-md-3">
          <iframe
            width="100%"
            height="150"
            src="https://www.youtube.com/embed/AbILPD3ZsZY"
            title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
          </iframe>
        </div>
      </div>      
  </div>
</main>

<footer>
  <div class="container text-center">
    
    <div class="d-flex justify-content-center gap-3">
      <a href="#"><i class="bi bi-youtube"></i></a>
      <a href="#"><i class="bi bi-facebook"></i></a>
      <a href="#"><i class="bi bi-twitter"></i></a>
      <a href="#"><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
