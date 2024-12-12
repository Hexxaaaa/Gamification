<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Card Layout with Bootstrap</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/tugas.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<style>
  *{
  font-family: 'Poppins',serif; font-weight:500; font-style: normal;
}
</style>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="{{ url('gallery/logopointplay.png') }}" alt="logobrand" style="width: 100px">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse mt-1" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/dashboard">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/tasks">Tasks</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/rewards">Rewards</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/leaderboard">Leaderboard</a>
          </li>
        </ul>
        <div class="d-flex align-items-center">
          <span class="me-3">Anon User</span>
          <span class="badge bg-primary">21,870 Pts</span>
        </div>
      </div>
    </div>
  </nav>
  <div class="container card-container">
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <article class="card-article">
          <img src="{{ asset('gallery/Agaklaen.jpeg') }}" alt="image" class="card-img">
        </article>
      </div>
      <div class="col-md-6 col-lg-4">
        <article class="card-article">
          <img src="{{ asset('gallery/bilaesokibu.jpeg') }}" alt="image" class="card-img">
        </article>
      </div>
      <div class="col-md-6 col-lg-4">
        <article class="card-article">
          <img src="{{ asset('gallery/jendelaseribusungai.jpeg') }}" alt="image" class="card-img">
           
        </article>
      </div>
    </div>
  </div>
  
  <div class="container my-5">
    <!-- Search bar -->
    <div class="container">
      <div class="row justify-content-center mb-4">
          <div class="col-12 col-sm-8 col-md-6 col-lg-5">
              <form class="d-flex">
                  <input type="text" class="form-control me-2" placeholder="Search Videos">
                  <button class="btn btn-danger" type="submit">Search</button>
              </form>
          </div>
      </div>
  </div>
    <!-- Title -->
    <div class="row mb-3">
        <div class="col-12 text-center">
            <h6 class="text-muted">TOTAL IS IN QUEUE</h6>
        </div>
    </div>

    <!-- Video Cards -->
    <div class="row text-center">
        <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="card">
                <img src="{{ asset('gallery/gambarlist.png') }}" class="card-img-top" alt="Games of Naruto">
                <div class="card-body">
                    <p class="card-text">Games of Naruto<br>2009</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="card">
                <img src="{{ asset('gallery/gambarlist2.png') }}" class="card-img-top" alt="Games of Naruto">
                <div class="card-body">
                    <p class="card-text">Games of Naruto<br>2009</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="card">
                <img src="{{ asset('gallery/gambarlist3.png') }}" class="card-img-top" alt="Games of Naruto">
                <div class="card-body">
                    <p class="card-text">Games of Naruto<br>2009</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="card">
                <img src="{{ asset('gallery/gambarlist2.png') }}" class="card-img-top" alt="Games of Naruto">
                <div class="card-body">
                    <p class="card-text">Games of Naruto<br>2009</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="card">
                <img src="{{ asset('gallery/gambarlist4.png') }}" class="card-img-top" alt="Games of Naruto">
                <div class="card-body">
                    <p class="card-text">Games of Naruto<br>2009</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
            <div class="card">
                <img src="{{ asset('gallery/gambarlist3.png') }}" class="card-img-top" alt="Games of Naruto">
                <div class="card-body">
                    <p class="card-text">Games of Naruto<br>2009</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container py-5">
  <div class="row image-row">
      <div class="col-md-2 mb-4">
          <div class="image-container">
            <a href="/video">
              <img src="{{ asset('gallery/list2gambar1.png') }}" alt="Naruto Figure 1"> </a>
          </div>
      </div>
      <div class="col-md-2 mb-4">
          <div class="image-container">
            <a href="/video">
              <img src="{{ asset('gallery/list2gambar2.png') }}" alt="Naruto Figure 2"></a>
              
          </div>
      </div>
      <div class="col-md-2 mb-4">
          <div class="image-container">
            <a href="/video">
              <img src="{{ asset('gallery/list2gambar3.png') }}" alt="Naruto Figure 3"></a>
    
          </div>
      </div>
      <div class="col-md-2 mb-4">
          <div class="image-container">
            <a href="/video">
              <img src="{{ asset('gallery/list2gambar1.png') }}" alt="Naruto Figure 4"></a>
          </div>
      </div>
      <div class="col-md-2 mb-4">
          <div class="image-container">
            <a href="/video">
              <img src="{{ asset('gallery/list2gambar4.png') }}" alt="Naruto Figure 5"></a>
          </div>
      </div>
  </div>
</div>
<div class="container mt-5" style="background-color: #d0e7f9; padding:100px; border-radius:30px;">
  <div class="text-center">
      <h5 class="section-title">Earn Special Points every time you finish watching videos!</h5>
      <p>Every time you finish watching a video, you'll earn special points here! Keep watching videos, commenting, liking, and sharing!</p>
      <br>
  </div>

  <div class="row text-center">
      <!-- First section: Claim your points -->
      <div class="col-md-3">
          <div class="icon-section">
              <img src="{{ asset('gallery/icon1.png') }}" alt="logoicon1footer" style="width: 50px">
          </div>
          <p class="section-description">Claim your points after finishing watching the video.</p>
      </div>

      <!-- Second section: Share the video -->
      <div class="col-md-3">
          <div class="icon-section">
            <img src="{{ asset('gallery/sharetask.png') }}" alt="logoicon1footer" style="width: 50px">
          </div>

          <p class="section-description">Share the video on social media or with your friends!</p>
      </div>

      <!-- Third section: Like the video -->
      <div class="col-md-3">
          <div class="icon-section">
            <img src="{{ asset('gallery/like.png') }}" alt="logoicon1footer" style="width: 50px">
          </div>
          <p class="section-description">Don't forget to like the video to earn even more points!</p>
      </div>

      <!-- Fourth section: Leave a comment -->
      <div class="col-md-3">
          <div class="icon-section">
            <img src="{{ asset('gallery/comment.png') }}" alt="logoicon1footer" style="width: 50px;">
          </div>
          <p class="section-description">Leave your comment after watching the video about what you think!</p>
      </div>
  </div>
</div>
<div class="container my-5">
  <!-- Points Section -->
  <div class="card  text-white p-3 mb-4" style="background-color: #002366">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h5>Your Points <img src="{{ asset('gallery/coindaily.png') }}" alt="" style="width: 24px; height: 24px; border:2px white;"></h5>
        
        <h3>428 <span class="text-warning">= Rp42</span></h3>
      </div>
      <button class="btn btn-warning text-dark">Redeem Voucher</button>
    </div>
  </div>

  <!-- Task Section -->
  <div class="card text-white p-3" style="background-color: #002366">
    <h5 class="col-md-3">Complete today's task and earn rewards!</h5>
    <h3>Rp10.220 <small>(102,200 points)</small></h3>
    <div class="my-3 text-center">
      <p>Watch a video and earn <strong>1,400 points</strong>.</p>
      <button class="btn btn-danger">Watch</button>
    </div>
    <div class="text-left">
      <button class="btn btn-secondary btn-sm">Watch for 10 minutes</button>
    </div>
  </div>

  <!-- Feedback -->
  <div class="text-center mt-4">
    <img src="{{ asset('gallery/comment.png') }}" alt="feedbackcomment" style="width: 30px">
    <a href="#" class="text-dark" style="text-decoration: none">Share your feedback</a> 
  </div>
</div>
<footer class="footer text-center py-4" style="background-color: #E5EDFF">
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
    <div class="help-button mt-3">
      <a href="/bantuan" class="btn btn-help">Butuh Bantuan?</a>
    </div>
  </div>
</footer>
<script src="{{ asset('js/tugas.js') }}"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>